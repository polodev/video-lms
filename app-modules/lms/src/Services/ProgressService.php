<?php

namespace Modules\Lms\Services;

use Modules\Lms\Models\Enrollment;
use Modules\Lms\Models\Video;
use Modules\Lms\Models\VideoProgress;

class ProgressService
{
    public function updateProgress(int $userId, int $videoId, int $watchedSeconds, int $totalSeconds): VideoProgress
    {
        $progress = VideoProgress::updateOrCreate(
            ['user_id' => $userId, 'video_id' => $videoId],
            ['watched_seconds' => $watchedSeconds, 'total_seconds' => $totalSeconds]
        );

        // Auto-enroll user
        $video = Video::with('chapter.series')->find($videoId);
        if ($video) {
            Enrollment::firstOrCreate(
                ['user_id' => $userId, 'series_id' => $video->chapter->series_id],
                ['enrolled_at' => now()]
            );
        }

        return $progress;
    }

    public function markCompleted(int $userId, int $videoId): VideoProgress
    {
        return VideoProgress::updateOrCreate(
            ['user_id' => $userId, 'video_id' => $videoId],
            ['completed' => true, 'completed_at' => now()]
        );
    }

    public function markUncompleted(int $userId, int $videoId): VideoProgress
    {
        return VideoProgress::updateOrCreate(
            ['user_id' => $userId, 'video_id' => $videoId],
            ['completed' => false, 'completed_at' => null]
        );
    }

    public function toggleComplete(int $userId, int $videoId): VideoProgress
    {
        $progress = VideoProgress::where('user_id', $userId)->where('video_id', $videoId)->first();

        if ($progress && $progress->completed) {
            return $this->markUncompleted($userId, $videoId);
        }

        return $this->markCompleted($userId, $videoId);
    }

    public function getSeriesProgress(int $userId, int $seriesId): array
    {
        $videoIds = Video::whereHas('chapter', fn ($q) => $q->where('series_id', $seriesId))
            ->pluck('id');

        $total = $videoIds->count();
        $completed = VideoProgress::where('user_id', $userId)
            ->whereIn('video_id', $videoIds)
            ->where('completed', true)
            ->count();

        return [
            'completed' => $completed,
            'total' => $total,
            'percentage' => $total > 0 ? round(($completed / $total) * 100) : 0,
        ];
    }

    public function getChapterProgress(int $userId, int $chapterId): array
    {
        $videoIds = Video::where('chapter_id', $chapterId)->pluck('id');

        $total = $videoIds->count();
        $completed = VideoProgress::where('user_id', $userId)
            ->whereIn('video_id', $videoIds)
            ->where('completed', true)
            ->count();

        return [
            'completed' => $completed,
            'total' => $total,
            'percentage' => $total > 0 ? round(($completed / $total) * 100) : 0,
        ];
    }
}
