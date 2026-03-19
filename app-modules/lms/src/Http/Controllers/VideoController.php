<?php

namespace Modules\Lms\Http\Controllers;

use App\Http\Controllers\Controller;
use Modules\Lms\Models\Video;
use Modules\Lms\Models\VideoProgress;
use Modules\Lms\Services\VideoStream;

class VideoController extends Controller
{
    public function show(Video $video)
    {
        $video->load('chapter.series.chapters.videos');

        $series = $video->chapter->series;
        $chapters = $series->chapters;

        // Find prev/next video
        $allVideos = $chapters->flatMap->videos->values();
        $currentIndex = $allVideos->search(fn ($v) => $v->id === $video->id);
        $prevVideo = $currentIndex > 0 ? $allVideos[$currentIndex - 1] : null;
        $nextVideo = $currentIndex < $allVideos->count() - 1 ? $allVideos[$currentIndex + 1] : null;

        // User progress
        $watchedSeconds = 0;
        $completed = false;
        $userProgress = [];

        if (auth()->check()) {
            $progress = VideoProgress::where('user_id', auth()->id())
                ->where('video_id', $video->id)
                ->first();

            if ($progress) {
                $watchedSeconds = $progress->watched_seconds;
                $completed = $progress->completed;
            }

            $userProgress = VideoProgress::where('user_id', auth()->id())
                ->whereIn('video_id', $allVideos->pluck('id'))
                ->pluck('completed', 'video_id')
                ->toArray();
        }

        // User bookmarks for the add-to-bookmark dropdown
        $bookmarks = auth()->user()->bookmarks()->get();

        return view('lms::videos.show', compact(
            'video', 'series', 'chapters', 'prevVideo', 'nextVideo',
            'watchedSeconds', 'completed', 'userProgress', 'bookmarks'
        ));
    }

    public function myVideos()
    {
        $completedProgress = VideoProgress::where('user_id', auth()->id())
            ->where('completed', true)
            ->with('video.chapter.series')
            ->latest('completed_at')
            ->paginate(30);

        return view('lms::videos.my-videos', compact('completedProgress'));
    }

    public function stream(Video $video)
    {
        $path = $video->path_name;

        if (!file_exists($path)) {
            abort(404, 'Video file not found.');
        }

        $stream = new VideoStream($path);
        $stream->start();
    }

    public function renderPdf(Video $video)
    {
        $path = $video->path_name;

        if (!file_exists($path)) {
            abort(404, 'PDF file not found.');
        }

        return response()->file($path, ['Content-Type' => 'application/pdf']);
    }
}
