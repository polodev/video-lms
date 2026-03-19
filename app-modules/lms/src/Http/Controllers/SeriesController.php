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

        if ($request->filled('topic')) {
            $query->whereHas('topics', fn ($q) => $q->where('slug', $request->input('topic')));
        }

        $all_series = $query->paginate(15)->withQueryString();
        $search = $request->input('query', '');
        $topics = Topic::withCount('series')->orderBy('title')->get();
        $activeTopic = $request->input('topic', '');

        return view('lms::series.index', compact('all_series', 'search', 'topics', 'activeTopic'));
    }

    public function indexHidden()
    {
        $all_series = Series::with('topics')->hidden()->latest()->paginate(15);
        $search = '';
        $topics = Topic::withCount('series')->orderBy('title')->get();
        $activeTopic = '';

        return view('lms::series.index', compact('all_series', 'search', 'topics', 'activeTopic'));
    }

    public function create()
    {
        $topics = Topic::orderBy('title')->get();

        return view('lms::series.create', compact('topics'));
    }

    public function bulkCreate()
    {
        return view('lms::series.bulk-create');
    }

    public function bulkStore(Request $request)
    {
        $request->validate([
            'parent_path' => 'required|string',
        ]);

        $parentPath = rtrim($request->input('parent_path'), '/');

        if (!is_dir($parentPath)) {
            return back()->withInput()->withErrors(['parent_path' => 'The given path is not a valid directory.']);
        }

        $folders = array_filter(glob($parentPath . '/*'), 'is_dir');

        if (empty($folders)) {
            return back()->withInput()->withErrors(['parent_path' => 'No subdirectories found under this path.']);
        }

        $existingUrls = Series::whereIn('url', $folders)->pluck('url')->flip();

        $created = 0;
        foreach ($folders as $folderPath) {
            if ($existingUrls->has($folderPath)) {
                continue;
            }
            $folderName = basename($folderPath);
            Series::create([
                'title' => $folderName,
                'url'   => $folderPath,
            ]);
            $created++;
        }

        $skipped = count($folders) - $created;
        $message = "{$created} series created successfully.";
        if ($skipped > 0) {
            $message .= " {$skipped} skipped (already exist).";
        }

        return redirect()->route('series.index')->with('success', $message);
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'url' => 'required|string',
        ]);

        $series = Series::create($request->only('title', 'url', 'description'));

        $topicIds = $request->input('topic_ids', []);
        $topicIds = array_merge($topicIds, $this->createNewTopics($request->input('new_topics', '')));
        if (!empty($topicIds)) {
            $series->topics()->attach($topicIds);
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

        $topicIds = $request->input('topic_ids', []);
        $topicIds = array_merge($topicIds, $this->createNewTopics($request->input('new_topics', '')));
        $series->topics()->sync($topicIds);

        return redirect()->route('series.show', $series)->with('success', 'Series updated successfully.');
    }

    public function destroy(Series $series)
    {
        $series->delete();

        return redirect()->route('series.index')->with('success', 'Series deleted.');
    }

    private function createNewTopics(?string $input): array
    {
        if (empty(trim($input))) {
            return [];
        }

        $names = array_filter(array_map('trim', explode(',', $input)));
        $ids = [];

        foreach ($names as $name) {
            if (empty($name)) continue;
            $topic = Topic::firstOrCreate(
                ['slug' => \Illuminate\Support\Str::slug($name)],
                ['title' => $name]
            );
            $ids[] = $topic->id;
        }

        return $ids;
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
