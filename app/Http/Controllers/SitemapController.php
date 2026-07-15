<?php

namespace App\Http\Controllers;

use App\Models\Anime;
use Carbon\Carbon;
use Illuminate\Http\Response;

class SitemapController extends Controller
{
    public function index(): Response
    {
        $now = Carbon::now()->toAtomString();

        // Static routes
        $urls = [
            [
                'loc' => url('/'),
                'lastmod' => $now,
                'changefreq' => 'daily',
                'priority' => '1.0',
            ],
            [
                'loc' => url('/trending'),
                'lastmod' => $now,
                'changefreq' => 'daily',
                'priority' => '0.8',
            ],
            [
                'loc' => url('/catalog'),
                'lastmod' => $now,
                'changefreq' => 'daily',
                'priority' => '0.8',
            ],
        ];

        // Dynamic routes (Anime)
        $animes = Anime::select('slug', 'updated_at')->orderBy('updated_at', 'desc')->get();
        foreach ($animes as $anime) {
            $urls[] = [
                'loc' => url('/anime/' . $anime->slug),
                'lastmod' => $anime->updated_at ? $anime->updated_at->toAtomString() : $now,
                'changefreq' => 'weekly',
                'priority' => '0.6',
            ];
        }

        // Generate XML
        $xml = new \SimpleXMLElement('<?xml version="1.0" encoding="UTF-8"?><urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9"/>');

        foreach ($urls as $urlInfo) {
            $urlNode = $xml->addChild('url');
            $urlNode->addChild('loc', htmlspecialchars($urlInfo['loc']));
            $urlNode->addChild('lastmod', $urlInfo['lastmod']);
            $urlNode->addChild('changefreq', $urlInfo['changefreq']);
            $urlNode->addChild('priority', $urlInfo['priority']);
        }

        return response($xml->asXML(), 200)
            ->header('Content-Type', 'text/xml');
    }
}
