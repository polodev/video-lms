<?php

namespace Modules\Lms\Http\Controllers;

use App\Http\Controllers\Controller;
use Modules\Lms\Models\Enrollment;
use Modules\Lms\Services\ProgressService;

class DashboardController extends Controller
{
    public function index(ProgressService $progressService)
    {
        $enrollments = Enrollment::where('user_id', auth()->id())
            ->with('series.chapters.videos')
            ->latest('enrolled_at')
            ->get();

        $enrolledSeries = $enrollments->map(function ($enrollment) use ($progressService) {
            $progress = $progressService->getSeriesProgress(auth()->id(), $enrollment->series_id);
            $enrollment->progress = $progress;
            return $enrollment;
        });

        return view('lms::dashboard.index', compact('enrolledSeries'));
    }
}
