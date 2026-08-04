<?php

namespace App\Support;

use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class FrontendMedia
{
    public const PROGRAM_FALLBACK = 'frontend/assets/img/program-placeholder.svg';
    public const LOGO_FALLBACK = 'frontend/assets/img/edegree-plus-square-white-bg-logo.png';
    public const HERO_FALLBACK = 'frontend/assets/img/edegreeplus-rectungular-white-bg-logo.png';

    public static function image(?string $path, string $fallback = self::PROGRAM_FALLBACK): string
    {
        if (filled($path)) {
            $path = trim((string) $path);

            if (Str::startsWith($path, ['http://', 'https://', '//'])) {
                return self::normalizeUrl($path);
            }

            $relativePath = self::cleanRelativePath($path);

            if ($relativePath !== '' && (self::relativeFileExists($relativePath) || self::isPublicAssetPath($relativePath))) {
                return self::normalizeUrl(asset($relativePath));
            }
        }

        if (Str::startsWith($fallback, ['http://', 'https://', '//'])) {
            return self::normalizeUrl($fallback);
        }

        return self::normalizeUrl(asset(self::cleanRelativePath($fallback)));
    }

    private static function cleanRelativePath(string $path): string
    {
        $path = trim($path);
        $path = preg_replace('#^https?://[^/]+/#i', '', $path) ?: $path;

        return ltrim(str_replace('\\', '/', $path), '/');
    }

    private static function isPublicAssetPath(string $path): bool
    {
        return Str::startsWith($path, [
            'uploads/',
            'storage/',
            'frontend/',
            'admin/',
            'adminlte/',
        ]);
    }

    private static function relativeFileExists(string $path): bool
    {
        $documentRoot = $_SERVER['DOCUMENT_ROOT'] ?? null;
        $candidates = [
            public_path($path),
            base_path($path),
            self::joinPath($documentRoot, $path),
            self::joinPath($documentRoot, 'public/'.$path),
        ];

        foreach (array_filter(array_unique($candidates)) as $candidate) {
            if (File::exists($candidate)) {
                return true;
            }
        }

        return false;
    }

    private static function joinPath(?string $root, string $path): ?string
    {
        if (! $root) {
            return null;
        }

        return rtrim($root, '/\\').DIRECTORY_SEPARATOR.str_replace(['/', '\\'], DIRECTORY_SEPARATOR, ltrim($path, '/\\'));
    }

    private static function normalizeUrl(string $url): string
    {
        if (Str::startsWith($url, '//')) {
            return '//'.(preg_replace('#/+#', '/', ltrim($url, '/')) ?: ltrim($url, '/'));
        }

        return preg_replace('#(?<!:)//+#', '/', $url) ?: $url;
    }
}
