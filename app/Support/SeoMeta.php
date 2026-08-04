<?php

namespace App\Support;

use App\Models\Siteinfo;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

class SeoMeta
{
    public static function fromModel(mixed $model = null, array $fallbacks = []): array
    {
        $packageMeta = self::packageMetaForCurrentUrl();
        $sources = [$packageMeta, $model, $fallbacks];

        $siteName = self::firstFilled($sources, ['site_name', 'siteName']) ?: 'eDegree+';
        $title = self::firstFilled($sources, ['seo_title', 'meta_title', 'title', 'page_title', 'page_name', 'program', 'name']) ?: $siteName;
        $description = self::firstFilled($sources, ['seo_description', 'meta_description', 'short_description', 'subtitle', 'excerpt', 'description', 'about_us'])
            ?: 'Advance your career with internationally accredited online university degrees.';
        $author = self::firstFilled($sources, ['author', 'author_name']) ?: 'eDegree+';
        $publisher = self::firstFilled($sources, ['publisher']) ?: $siteName;
        $copyright = self::firstFilled($sources, ['copyright']);
        $keywords = self::firstFilled($sources, ['keywords', 'meta_keywords', 'tags']);
        $robots = self::firstFilled($sources, ['robots', 'robots_tag', 'meta_robots']) ?: 'index, follow, max-image-preview:large, max-snippet:-1, max-video-preview:-1';
        $url = self::firstFilled($sources, ['canonical_url', 'url']) ?: url()->current();
        $image = self::firstFilled($sources, ['meta_image', 'og_image', 'twitter_image', 'image', 'image_1', 'featured_image_path', 'background_image', 'hero_background_path'])
            ?: self::siteDefaultMetaImage()
            ?: 'frontend/assets/img/edegree-plus-logo.png';
        $updatedAt = data_get($model, 'updated_at') ?: ($fallbacks['updated_at'] ?? now());
        $updatedAt = $updatedAt instanceof Carbon ? $updatedAt : Carbon::parse($updatedAt);

        return [
            'title' => self::cleanText($title, 70),
            'desc' => self::cleanText($description, 180),
            'ogTitle' => self::cleanText(self::firstFilled($sources, ['og_title']) ?: $title, 70),
            'ogDescription' => self::cleanText(self::firstFilled($sources, ['og_description']) ?: $description, 180),
            'twitterTitle' => self::cleanText(self::firstFilled($sources, ['twitter_title']) ?: $title, 70),
            'twitterDescription' => self::cleanText(self::firstFilled($sources, ['twitter_description']) ?: $description, 180),
            'author' => $author,
            'publisher' => $publisher,
            'copyright' => $copyright,
            'keywords' => $keywords,
            'url' => self::absoluteUrl($url),
            'indexable' => ! Str::contains(strtolower($robots), 'noindex'),
            'robots' => $robots,
            'siteName' => $siteName,
            'ogImage' => self::absoluteUrl($image),
            'updatedIso' => $updatedAt->toIso8601String(),
            'twitter' => $fallbacks['twitter'] ?? '@eDegreePlus',
        ];
    }

    private static function packageMetaForCurrentUrl(): array
    {
        try {
            if (! class_exists(\Nirjon\LaravelSeo\Models\SeoMeta::class) || ! Schema::hasTable('nirjon_seo_metas')) {
                return [];
            }

            $path = '/' . ltrim((string) request()->path(), '/');
            $path = $path === '/' ? '/' : rtrim($path, '/');

            $meta = \Nirjon\LaravelSeo\Models\SeoMeta::query()
                ->where('seoable_type', 'url')
                ->where('is_active', true)
                ->where(function ($query) use ($path) {
                    $query->where('url_path', $path);

                    if ($path !== '/') {
                        $query->orWhere('url_path', rtrim($path, '/'));
                    }
                })
                ->latest('id')
                ->first();

            return $meta ? $meta->toArray() : [];
        } catch (\Throwable) {
            return [];
        }
    }

    private static function siteDefaultMetaImage(): ?string
    {
        try {
            if (! Schema::hasTable('siteinfo') || ! Schema::hasColumn('siteinfo', 'default_meta_image')) {
                return null;
            }

            return Siteinfo::query()
                ->whereNotNull('default_meta_image')
                ->where('default_meta_image', '!=', '')
                ->latest('id')
                ->value('default_meta_image');
        } catch (\Throwable) {
            return null;
        }
    }

    private static function firstFilled(array $sources, array $keys): ?string
    {
        foreach ($keys as $key) {
            foreach ($sources as $source) {
                $value = data_get($source, $key);

                if (filled($value)) {
                    return (string) $value;
                }
            }
        }

        return null;
    }

    private static function cleanText(string $value, int $limit): string
    {
        return Str::limit(trim(preg_replace('/\s+/', ' ', strip_tags($value))), $limit, '');
    }

    private static function absoluteUrl(string $value): string
    {
        if (Str::startsWith($value, ['http://', 'https://'])) {
            return self::normalizeUrl($value);
        }

        return self::normalizeUrl(url(ltrim($value, '/')));
    }

    private static function normalizeUrl(string $value): string
    {
        return preg_replace('#(?<!:)//+#', '/', $value) ?: $value;
    }
}
