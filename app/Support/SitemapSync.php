<?php

namespace App\Support;

use App\Models\About;
use App\Models\BlogPost;
use App\Models\ContactPage;
use App\Models\CustomPage;
use App\Models\News;
use App\Models\Program;
use App\Models\SitemapEntry;
use App\Models\University;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;

class SitemapSync
{
    public static function sync(): int
    {
        $count = 0;

        foreach (self::entries() as $entry) {
            $sitemapEntry = SitemapEntry::firstOrNew(['url' => $entry['url']]);
            $preserveActiveState = $sitemapEntry->exists;

            if ($preserveActiveState) {
                unset($entry['is_active']);
            }

            $sitemapEntry->fill($entry)->save();

            $count++;
        }

        return $count;
    }

    public static function entries(): Collection
    {
        return collect()
            ->merge(self::staticEntries())
            ->merge(self::modelEntries(University::where('status', true)->get(), 'university', 'name', 'getSitemapUrl', 0.8))
            ->merge(self::modelEntries(Program::where('status', true)->get(), 'program', 'program', 'getSitemapUrl', 0.8))
            ->merge(self::modelEntries(BlogPost::where('is_published', true)->get(), 'blog_post', 'title', 'getSitemapUrl', 0.6))
            ->merge(self::modelEntries(News::where('status', true)->get(), 'news', 'title', 'getSitemapUrl', 0.6))
            ->merge(self::customPageEntries());
    }

    private static function staticEntries(): array
    {
        return [
            self::entry('Home', '/', 'static', null, 'daily', 1.0),
            self::entry('About', '/about', 'static', null, 'monthly', 0.7, About::latest('updated_at')->first()),
            self::entry('Contact', '/contact', 'static', null, 'monthly', 0.6, ContactPage::latest('updated_at')->first()),
            self::entry('Programs', '/programs', 'static', null, 'daily', 0.9),
            self::entry('Universities', '/universities', 'static', null, 'daily', 0.9),
            self::entry('Blog', '/blog', 'static', null, 'weekly', 0.7),
            self::entry('News', '/news', 'static', null, 'weekly', 0.7),
            self::entry('Sitemap', '/sitemap', 'static', null, 'monthly', 0.4),
        ];
    }

    private static function customPageEntries(): Collection
    {
        return CustomPage::where('status', true)->get()->map(function (CustomPage $page) {
            return self::entry(
                $page->page_name,
                $page->public_url,
                'custom_page',
                $page->id,
                'monthly',
                0.5,
                $page
            );
        });
    }

    private static function modelEntries(Collection $records, string $sourceType, string $titleColumn, string $urlMethod, float $priority): Collection
    {
        return $records->map(function (Model $record) use ($sourceType, $titleColumn, $urlMethod, $priority) {
            return self::entry(
                (string) $record->{$titleColumn},
                $record->{$urlMethod}(),
                $sourceType,
                $record->id,
                'weekly',
                $priority,
                $record
            );
        })->filter(fn (array $entry) => filled($entry['url']));
    }

    private static function entry(string $title, string $url, ?string $sourceType, ?int $sourceId, string $changefreq, float $priority, ?Model $record = null): array
    {
        return [
            'title' => $title,
            'url' => self::relativeUrl($url),
            'source_type' => $sourceType,
            'source_id' => $sourceId,
            'changefreq' => $changefreq,
            'priority' => $priority,
            'lastmod' => $record?->updated_at ?: now(),
            'is_active' => true,
        ];
    }

    private static function relativeUrl(string $url): string
    {
        if (Str::startsWith($url, ['http://', 'https://'])) {
            return '/'.ltrim(parse_url($url, PHP_URL_PATH) ?: '/', '/');
        }

        return '/'.ltrim($url, '/');
    }
}
