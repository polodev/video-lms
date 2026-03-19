<?php

namespace Modules\Lms\Services;

use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Modules\Lms\Models\Chapter;
use Modules\Lms\Models\Series;

class FolderScannerService
{
    private array $allowedExtensions = ['mp4', 'avi', 'mov', 'm4v', 'mkv', 'webm', 'pdf'];

    public function scan(Series $series): int
    {
        $url = $series->url;

        if (!File::exists($url)) {
            return 0;
        }

        // Delete existing chapters (videos cascade)
        $series->chapters()->delete();

        $subfolders = collect(File::directories($url))->sort(SORT_NATURAL)->values();

        if ($subfolders->isEmpty()) {
            // No subfolders — create single chapter from root files
            $files = $this->getMediaFiles($url);
            if (empty($files)) {
                return 0;
            }

            $chapter = $series->chapters()->create([
                'title' => $series->title,
                'folder_path' => $url,
                'sort_order' => 1,
            ]);

            $this->createVideosForChapter($chapter, $files);

            return count($files);
        }

        // Multi-chapter: each subfolder is a chapter
        $totalVideos = 0;
        foreach ($subfolders as $index => $folderPath) {
            $folderName = basename($folderPath);
            $files = $this->getMediaFiles($folderPath);

            if (empty($files)) {
                continue;
            }

            $chapter = $series->chapters()->create([
                'title' => $folderName,
                'folder_path' => $folderPath,
                'sort_order' => $index + 1,
            ]);

            $this->createVideosForChapter($chapter, $files);
            $totalVideos += count($files);
        }

        return $totalVideos;
    }

    private function getMediaFiles(string $directory): array
    {
        $files = File::allFiles($directory);

        $filtered = array_filter($files, function ($file) {
            return in_array(strtolower($file->getExtension()), $this->allowedExtensions);
        });

        usort($filtered, function ($a, $b) {
            return strnatcmp($a->getPathname(), $b->getPathname());
        });

        return array_values($filtered);
    }

    private function createVideosForChapter(Chapter $chapter, array $files): void
    {
        foreach ($files as $index => $file) {
            $extension = strtolower($file->getExtension());
            $fileType = $extension === 'pdf' ? 'pdf' : 'video';
            $pathName = $file->getPathname();
            $fileName = $file->getFilename();
            $fileNameWithoutExtension = basename($pathName, ".{$extension}");

            $chapter->videos()->create([
                'extension' => $extension,
                'path_name' => $pathName,
                'file_name' => $fileName,
                'file_type' => $fileType,
                'file_name_without_extension' => $fileNameWithoutExtension,
                'sort_order' => $index + 1,
            ]);
        }
    }
}
