<?php

namespace App\Http\Controllers;

use App\Models\BlogPost;
use App\Models\Page;
use Illuminate\View\View;

class BlogController extends Controller
{
    public function index(): View
    {
        $posts = BlogPost::published()->ordered()->get();

        return view('pages.blog', [
            'page' => Page::bySlug('blog'),
            'featured' => $posts->firstWhere('is_featured', true) ?? $posts->first(),
            'posts' => $posts->reject(fn ($p) => $p->is_featured)->values(),
        ]);
    }

    public function show(BlogPost $post): View
    {
        abort_unless($post->is_published, 404);

        $related = BlogPost::published()
            ->where('id', '!=', $post->id)
            ->ordered()
            ->limit(3)
            ->get();

        return view('pages.blog-show', [
            'post' => $post,
            'related' => $related,
        ]);
    }
}
