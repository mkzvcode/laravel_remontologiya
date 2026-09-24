<?php

namespace App\Http\Controllers;

use App\Models\BlogPost;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\URL;

class SitemapController extends Controller
{
    public function __invoke(): Response
    {
        $urls = collect([
            ['loc' => URL::to('/'), 'priority' => '1.0'],
            ['loc' => URL::to('/services'), 'priority' => '0.9'],
            ['loc' => URL::to('/prices'), 'priority' => '0.9'],
            ['loc' => URL::to('/portfolio'), 'priority' => '0.8'],
            ['loc' => URL::to('/reviews'), 'priority' => '0.7'],
            ['loc' => URL::to('/guarantee'), 'priority' => '0.7'],
            ['loc' => URL::to('/about'), 'priority' => '0.6'],
            ['loc' => URL::to('/blog'), 'priority' => '0.6'],
            ['loc' => URL::to('/careers'), 'priority' => '0.4'],
        ]);

        foreach (BlogPost::published()->ordered()->get() as $post) {
            $urls->push([
                'loc' => URL::to('/blog/'.$post->slug),
                'priority' => '0.5',
                'lastmod' => $post->updated_at?->toAtomString(),
            ]);
        }

        $xml = view('sitemap', ['urls' => $urls])->render();

        return response($xml, 200)->header('Content-Type', 'application/xml; charset=UTF-8');
    }
}
