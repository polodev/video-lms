<?php

use Illuminate\Support\Facades\Route;
use Modules\Lms\Http\Controllers\SeriesController;
use Modules\Lms\Http\Controllers\VideoController;
use Modules\Lms\Http\Controllers\TopicController;
use Modules\Lms\Http\Controllers\BookmarkController;
use Modules\Lms\Http\Controllers\ProgressController;
use Modules\Lms\Http\Controllers\DashboardController;

Route::middleware(['web', 'auth'])->group(function () {
    // Home redirect
    Route::get('/', fn () => redirect()->route('series.index'));

    // Series
    Route::get('/series', [SeriesController::class, 'index'])->name('series.index');
    Route::get('/series/create', [SeriesController::class, 'create'])->name('series.create');
    Route::post('/series', [SeriesController::class, 'store'])->name('series.store');
    Route::get('/series/hidden', [SeriesController::class, 'indexHidden'])->name('series.hidden');
    Route::get('/series/{series}', [SeriesController::class, 'show'])->name('series.show');
    Route::get('/series/{series}/edit', [SeriesController::class, 'edit'])->name('series.edit');
    Route::put('/series/{series}', [SeriesController::class, 'update'])->name('series.update');
    Route::delete('/series/{series}', [SeriesController::class, 'destroy'])->name('series.destroy');
    Route::post('/series/{series}/scan', [SeriesController::class, 'scan'])->name('series.scan');

    // Videos
    Route::get('/video/{video}', [VideoController::class, 'show'])->name('video.show');
    Route::get('/video/{video}/stream', [VideoController::class, 'stream'])->name('video.stream');
    Route::get('/video/{video}/pdf', [VideoController::class, 'renderPdf'])->name('video.pdf');

    // Topics
    Route::get('/topics', [TopicController::class, 'index'])->name('topics.index');
    Route::post('/topics', [TopicController::class, 'store'])->name('topics.store');
    Route::get('/topics/create', [TopicController::class, 'create'])->name('topics.create');
    Route::get('/topics/{topic}', [TopicController::class, 'show'])->name('topics.show');
    Route::delete('/topics/{topic}', [TopicController::class, 'destroy'])->name('topics.destroy');

    // Bookmarks
    Route::get('/bookmarks', [BookmarkController::class, 'index'])->name('bookmarks.index');
    Route::post('/bookmarks', [BookmarkController::class, 'store'])->name('bookmarks.store');
    Route::get('/bookmarks/create', [BookmarkController::class, 'create'])->name('bookmarks.create');
    Route::get('/bookmarks/{bookmark}', [BookmarkController::class, 'show'])->name('bookmarks.show');
    Route::delete('/bookmarks/{bookmark}', [BookmarkController::class, 'destroy'])->name('bookmarks.destroy');
    Route::post('/bookmarks/{bookmark}/add', [BookmarkController::class, 'addVideo'])->name('bookmarks.addVideo');
    Route::post('/bookmarks/{bookmark}/remove', [BookmarkController::class, 'removeVideo'])->name('bookmarks.removeVideo');

    // Progress (AJAX)
    Route::post('/progress/update', [ProgressController::class, 'update'])->name('progress.update');
    Route::post('/progress/toggle-complete', [ProgressController::class, 'toggleComplete'])->name('progress.toggleComplete');

    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
});
