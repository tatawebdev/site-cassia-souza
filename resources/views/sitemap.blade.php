{{-- A declaração XML é posta pelo SitemapController: com short_open_tag ligado (produção), ela quebraria a view --}}
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
@foreach ($urls as $item)
    <url>
        <loc>{{ $item['url'] }}</loc>
@if ($item['lastmod'])
        <lastmod>{{ $item['lastmod']->toAtomString() }}</lastmod>
@endif
    </url>
@endforeach
</urlset>
