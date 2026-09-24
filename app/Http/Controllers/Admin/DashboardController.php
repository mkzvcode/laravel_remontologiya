<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BlogPost;
use App\Models\Lead;
use App\Models\Page;
use App\Models\PortfolioCase;
use App\Models\Review;
use App\Models\Service;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function __invoke(): View
    {
        return view('admin.dashboard', [
            'stats' => [
                ['label' => 'Новых заявок', 'value' => Lead::where('is_read', false)->count(), 'href' => route('admin.leads.index')],
                ['label' => 'Услуг', 'value' => Service::count(), 'href' => route('admin.resource.index', 'services')],
                ['label' => 'Объектов в портфолио', 'value' => PortfolioCase::count(), 'href' => route('admin.resource.index', 'portfolio-cases')],
                ['label' => 'Отзывов', 'value' => Review::count(), 'href' => route('admin.resource.index', 'reviews')],
                ['label' => 'Статей в блоге', 'value' => BlogPost::count(), 'href' => route('admin.resource.index', 'blog-posts')],
            ],
            'pages' => Page::orderBy('id')->get(),
            'recentLeads' => Lead::newest()->limit(6)->get(),
        ]);
    }
}
