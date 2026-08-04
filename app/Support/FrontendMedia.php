<?php

namespace App\Support;

use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class FrontendMedia
{
    public const PROGRAM_FALLBACK = 'frontend/assets/img/edegree-plus-square-white-bg-logo.png';
    public const LOGO_FALLBACK = 'frontend/assets/img/edegree-plus-square-white-bg-logo.png';
    public const HERO_FALLBACK = 'frontend/assets/img/edegreeplus-rectungular-white-bg-logo.png';

    public static function image(?string $path, string $fallback = self::PROGRAM_FALLBACK): string
    {
        if (filled($path)) {
            $path = trim((string) $path);

            if (Str::startsWith($path, ['http://', 'https://'])) {
                return self::normalizeUrl($path);
            }

            $relativePath = ltrim($path, '/');

            if (File::exists(public_path($relativePath))) {
                return self::normalizeUrl(asset($relativePath));
            }
        }

        if (Str::startsWith($fallback, ['http://', 'https://'])) {
            return self::normalizeUrl($fallback);
        }

        return self::normalizeUrl(asset(ltrim($fallback, '/')));
    }

    private static function normalizeUrl(string $url): string
    {
        return preg_replace('#(?<!:)//+#', '/', $url) ?: $url;
    }
}
