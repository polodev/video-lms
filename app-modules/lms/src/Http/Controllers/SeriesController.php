<?php

namespace Modules\Lms\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\Lms\Models\Series;
use Modules\Lms\Models\Topic;
use Modules\Lms\Services\FolderScannerService;
use Modules\Lms\Services\ProgressService;

class SeriesController extends Controller
{
    public function index(Request $request)
    {
        $query = Series::query()->with('topics')->visible()->latest();

        if ($request->filled('query')) {
            $search = $request->input('query');
            $query->where(function ($q) use ($search) {
                $q->where('title', 'LIKE', "%{$search}%")
                  ->orWhere('url', 'LIKE', "%{$search}%");
            });
        }

        $all_series = $query->paginate(15)->withQueryString();
        $search = $request->input('query', '');

        return view('lms::series.index', compact('all_series', 'search'));
    }

    public function indexHidden()
    {
        $all_series = Series::with('topics')->hidden()->latest()->paginate(15);
        $search = '';

        return view('lms::series.index', compact('all_series', 'search'));
    }

    public function create()
    {
        $topics = Topic::orderBy('title')->get();

        return view('lms::series.create', compact('topics'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'url' => 'required|string',
        ]);

        $series = Series::create($request->only('title', 'url', 'description'));

        if ($request->filled('topic_ids')) {
            $series->topics()->attach($request->input('topic_ids'));
        }

        return redirect()->route('series.show', $series)->with('success', 'Series created successfully.');
    }

    public function show(Series $series, ProgressService $progressService)
    {
        $series->load(['chapters.videos', 'topics']);
        $progress = $progressService->getSeriesProgress(auth()->id(), $series->id);

        $userProgress = [];
        if (auth()->check()) {
            $userProgress = \Modules\Lms\Models\VideoProgress::where('user_id', auth()->id())
                ->whereIn('video_id', $series->chapters->flatMap->videos->pluck('id'))
                ->pluck('completed', 'video_id')
                ->toArray();
        }

        return view('lms::series.show', compact('series', 'progress', 'userProgress'));
    }

    public function edit(Series $series)
    {
        $topics = Topic::orderBy('title')->get();
        $selectedTopics = $series->topics->pluck('id')->toArray();

        return view('lms::series.edit', compact('series', 'topics', 'selectedTopics'));
    }

    public function update(Request $request, Series $series)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'url' => 'required|string',
        ]);

        $series->update($request->only('title', 'url', 'description', 'hidden'));

        $series->topics()->sync($request->input('topic_ids', []));

        return redirect()->route('series.edit', $series)->with('success', 'Series updated successfully.');
    }

    public function destroy(Series $series)
    {
        $series->delete();

        return redirect()->route('series.index')->with('success', 'Series deleted.');
    }

    public function scan(Series $series, FolderScannerService $scanner)
    {
        $count = $scanner->scan($series);

        if ($count === 0) {
            return back()->with('error', 'No media files found. Check the folder path.');
        }

        return back()->with('success', "Scanned successfully. Found {$count} files.");
    }
}
