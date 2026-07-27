{!! '<'.'?xml version="1.0" encoding="UTF-8"?'.'>' !!}
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
@foreach ($pages as $page)
    <url>
        <loc>{{ url('/'.ltrim($page->url_slug, '/')) }}</loc>
        @if ($page->updated_at)
        <lastmod>{{ $page->updated_at->toAtomString() }}</lastmod>
        @endif
        <changefreq>weekly</changefreq>
        <priority>1.0</priority>
    </url>
@endforeach
</urlset>
