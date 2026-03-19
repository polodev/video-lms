<?php

namespace Modules\Lms\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\Lms\Models\Topic;

class TopicController extends Controller
{
    public function index()
    {
        $topics = Topic::withCount('series')->orderBy('title')->get();

        return view('lms::topics.index', compact('topics'));
    }

    public function create()
    {
        return view('lms::topics.create');
    }

    public function store(Request $request)
    {
        $request->validate(['title' => 'required|string|max:255']);

        Topic::create(['title' => $request->input('title')]);

        return redirect()->route('topics.index')->with('success', 'Topic created.');
    }

    public function show(Topic $topic)
    {
        $topic->load(['series' => fn ($q) => $q->visible()->latest()]);

        return view('lms::topics.show', compact('topic'));
    }

    public function destroy(Topic $topic)
    {
        $topic->delete();

        return redirect()->route('topics.index')->with('success', 'Topic deleted.');
    }
}
