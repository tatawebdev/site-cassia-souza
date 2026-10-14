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

        return response()
            ->view('sitemap', ['urls' => $urls])
            ->header('Content-Type', 'application/xml; charset=UTF-8');
    }
}
