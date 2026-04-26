<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\Exceptions\DriverException;
use Intervention\Image\ImageManager;

final class MenuItemImageService
{
    private const SIZE = 900;

    public function storeCroppedSquare(UploadedFile $file): string
    {
        // #region agent log
        $this->agentDebugLog('H4', 'MenuItemImageService::storeCroppedSquare:entry', 'upload received', [
            'clientName' => $file->getClientOriginalName(),
            'mime' => $file->getMimeType(),
            'realPathLen' => is_string($file->getRealPath()) ? strlen($file->getRealPath()) : 0,
            'realPathEmpty' => $file->getRealPath() === false || $file->getRealPath() === '',
            'gd' => extension_loaded('gd'),
            'imagick' => extension_loaded('imagick'),
        ]);
        // #endregion

        $manager = $this->tryImageManager();
        if ($manager !== null) {
            try {
                $path = $file->getRealPath();
                if (is_string($path) && $path !== '') {
                    $image = $manager->read($path);
                    $image->cover(self::SIZE, self::SIZE);

                    $relative = 'menu-items/'.Str::uuid().'.jpg';
                    Storage::disk('public')->makeDirectory('menu-items');
                    $absolute = Storage::disk('public')->path($relative);
                    $image->toJpeg(quality: 88)->save($absolute);

                    $url = '/storage/'.$relative;
                    $exists = Storage::disk('public')->exists($relative);
                    // #region agent log
                    $this->agentDebugLog('H1', 'MenuItemImageService::storeCroppedSquare:processed', 'cropped jpeg path', [
                        'branch' => 'intervention_cover',
                        'relative' => $relative,
                        'url' => $url,
                        'urlLen' => strlen($url),
                        'fileExists' => $exists,
                    ]);
                    // #endregion

                    return $url;
                }
            } catch (\Throwable $e) {
                Log::warning('MenuItemImageService: crop failed, storing original upload.', [
                    'message' => $e->getMessage(),
                ]);
                // #region agent log
                $this->agentDebugLog('H2', 'MenuItemImageService::storeCroppedSquare:crop_fail', 'exception before fallback', [
                    'exceptionClass' => $e::class,
                    'message' => $e->getMessage(),
                ]);
                // #endregion
            }
        } else {
            Log::warning('MenuItemImageService: neither GD nor Imagick is available; image saved without crop. Install php-gd or php-imagick for 900×900 cropping.');
            // #region agent log
            $this->agentDebugLog('H4', 'MenuItemImageService::storeCroppedSquare:no_driver', 'using storeOriginalUpload', []);
            // #endregion
        }

        return $this->storeOriginalUpload($file);
    }

    private function tryImageManager(): ?ImageManager
    {
        if (extension_loaded('gd')) {
            try {
                return ImageManager::gd();
            } catch (DriverException) {
            }
        }
        if (extension_loaded('imagick')) {
            try {
                return ImageManager::imagick();
            } catch (DriverException) {
            }
        }

        return null;
    }

    private function storeOriginalUpload(UploadedFile $file): string
    {
        $ext = strtolower($file->getClientOriginalExtension() ?: '');
        if ($ext === '') {
            $ext = strtolower((string) $file->guessExtension());
        }
        if (! in_array($ext, ['jpg', 'jpeg', 'png', 'gif', 'webp'], true)) {
            $ext = 'jpg';
        }
        $name = Str::uuid().'.'.$ext;
        Storage::disk('public')->makeDirectory('menu-items');
        $file->storeAs('menu-items', $name, 'public');
        $relative = 'menu-items/'.$name;
        $url = '/storage/'.$relative;
        $exists = Storage::disk('public')->exists($relative);
        // #region agent log
        $this->agentDebugLog('H1', 'MenuItemImageService::storeOriginalUpload', 'fallback stored', [
            'branch' => 'original_upload',
            'name' => $name,
            'relative' => $relative,
            'url' => $url,
            'urlLen' => strlen($url),
            'fileExists' => $exists,
        ]);
        // #endregion

        return $url;
    }

    /** @param array<string, mixed> $data */
    private function agentDebugLog(string $hypothesisId, string $location, string $message, array $data): void
    {
        // #region agent log
        $line = json_encode([
            'sessionId' => 'ec7f84',
            'hypothesisId' => $hypothesisId,
            'location' => $location,
            'message' => $message,
            'data' => $data,
            'timestamp' => (int) (microtime(true) * 1000),
        ], JSON_UNESCAPED_SLASHES);
        if (is_string($line)) {
            @file_put_contents(base_path('.cursor/debug-ec7f84.log'), $line."\n", FILE_APPEND | LOCK_EX);
        }
        // #endregion
    }
}
