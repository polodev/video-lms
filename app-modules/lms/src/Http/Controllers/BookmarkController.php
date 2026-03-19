<?php

namespace Modules\Lms\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\Lms\Models\Bookmark;

class BookmarkController extends Controller
{
    public function index()
    {
        $bookmarks = auth()->user()->bookmarks()->withCount('videos')->latest()->get();

        return view('lms::bookmarks.index', compact('bookmarks'));
    }

    public function create()
    {
        return view('lms::bookmarks.create');
    }

    public function store(Request $request)
    {
        $request->validate(['title' => 'required|string|max:255']);

        auth()->user()->bookmarks()->create(['title' => $request->input('title')]);

        return redirect()->route('bookmarks.index')->with('success', 'Bookmark created.');
    }

    public function show(Bookmark $bookmark)
    {
        $this->authorizeBookmark($bookmark);
        $bookmark->load('videos.chapter.series');

        return view('lms::bookmarks.show', compact('bookmark'));
    }

    public function destroy(Bookmark $bookmark)
    {
        $this->authorizeBookmark($bookmark);
        $bookmark->delete();

        return redirect()->route('bookmarks.index')->with('success', 'Bookmark deleted.');
    }

    public function addVideo(Request $request, Bookmark $bookmark)
    {
        $this->authorizeBookmark($bookmark);
        $request->validate(['video_id' => 'required|exists:videos,id']);

        $bookmark->videos()->syncWithoutDetaching([$request->input('video_id')]);

        return back()->with('success', 'Video added to bookmark.');
    }

    public function removeVideo(Request $request, Bookmark $bookmark)
    {
        $this->authorizeBookmark($bookmark);
        $request->validate(['video_id' => 'required|exists:videos,id']);

        $bookmark->videos()->detach($request->input('video_id'));

        return back()->with('success', 'Video removed from bookmark.');
    }

    private function authorizeBookmark(Bookmark $bookmark): void
    {
        abort_if($bookmark->user_id !== auth()->id(), 403);
    }
}
