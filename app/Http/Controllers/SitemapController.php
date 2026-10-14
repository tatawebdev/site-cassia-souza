<?php

namespace App\Http\Controllers;

use App\Services\Sitemap;

/** /sitemap.xml: páginas institucionais + páginas de SEO liberadas para o Google */
class SitemapController extends Controller
{
    public function __invoke(Sitemap $sitemap)
    {
        $urls = collect(Sitemap::institucionais())
            ->map(fn ($url) => ['url' => $url, 'lastmod' => null])
            ->concat($sitemap->paginasSeo());

        $xml = '<'.'?xml version="1.0" encoding="UTF-8"?'.">\n".view('sitemap', ['urls' => $urls])->render();

        return response($xml)->header('Content-Type', 'application/xml; charset=UTF-8');
    }
}
