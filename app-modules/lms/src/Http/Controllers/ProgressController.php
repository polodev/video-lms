<?php

namespace Modules\Lms\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Modules\Lms\Services\ProgressService;

class ProgressController extends Controller
{
    public function update(Request $request, ProgressService $progressService): JsonResponse
    {
        $request->validate([
            'video_id' => 'required|exists:videos,id',
            'watched_seconds' => 'required|integer|min:0',
            'total_seconds' => 'required|integer|min:0',
        ]);

        $progressService->updateProgress(
            auth()->id(),
            $request->input('video_id'),
            $request->input('watched_seconds'),
            $request->input('total_seconds')
        );

        return response()->json(['status' => 'ok']);
    }

    public function toggleComplete(Request $request, ProgressService $progressService): JsonResponse
    {
        $request->validate(['video_id' => 'required|exists:videos,id']);

        $progress = $progressService->toggleComplete(auth()->id(), $request->input('video_id'));

        return response()->json([
            'status' => 'ok',
            'completed' => $progress->completed,
        ]);
    }
}
