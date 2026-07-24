{!! '<'.'?xml version="1.0" encoding="UTF-8"?'.'>' !!}
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
@foreach ($entries as $entry)
    <url>
        <loc>{{ $entry->absolute_url }}</loc>
        @if ($entry->lastmod)
        <lastmod>{{ $entry->lastmod->toAtomString() }}</lastmod>
        @endif
        <changefreq>{{ $entry->changefreq }}</changefreq>
        <priority>{{ number_format((float) $entry->priority, 1) }}</priority>
    </url>
@endforeach
</urlset>
