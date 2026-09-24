<?php

namespace App\Http\Controllers;

use App\Models\CalculatorSetting;
use App\Models\EstimateExample;
use App\Models\Faq;
use App\Models\GuaranteeDoc;
use App\Models\GuaranteeItem;
use App\Models\Page;
use App\Models\PortfolioCase;
use App\Models\PriceCategory;
use App\Models\Principle;
use App\Models\PricingPlan;
use App\Models\ProcessStep;
use App\Models\Promise;
use App\Models\Review;
use App\Models\ReviewCase;
use App\Models\Service;
use App\Models\ServicePerk;
use App\Models\TeamMember;
use App\Models\TimelineEvent;
use App\Models\Vacancy;
use Illuminate\View\View;

class PageController extends Controller
{
    public function home(): View
    {
        return view('pages.home', [
            'page' => Page::bySlug('home'),
            'promises' => Promise::ordered()->get(),
            'featuredServices' => Service::published()->where('is_featured_home', true)->ordered()->get(),
            'calc' => CalculatorSetting::current(),
            'plans' => PricingPlan::ordered()->get(),
            'homeCases' => PortfolioCase::published()->where('show_on_home', true)->ordered()->get(),
            'steps' => ProcessStep::ordered()->get(),
            'guaranteeItems' => GuaranteeItem::query()->ofType('covers')->ordered()->limit(4)->get(),
            'team' => TeamMember::where('show_on_home', true)->ordered()->get(),
            'reviews' => Review::published()->where('show_on_home', true)->ordered()->get(),
            'faqs' => Faq::published()->ordered()->get(),
        ]);
    }

    public function services(): View
    {
        return view('pages.services', [
            'page' => Page::bySlug('services'),
            'services' => Service::published()->ordered()->get(),
            'perks' => ServicePerk::ordered()->get(),
        ]);
    }

    public function prices(): View
    {
        return view('pages.prices', [
            'page' => Page::bySlug('prices'),
            'categories' => PriceCategory::ordered()->with('items')->get(),
            'example' => EstimateExample::current(),
        ]);
    }

    public function portfolio(): View
    {
        return view('pages.portfolio', [
            'page' => Page::bySlug('portfolio'),
            'cases' => PortfolioCase::published()->ordered()->get(),
        ]);
    }

    public function reviews(): View
    {
        return view('pages.reviews', [
            'page' => Page::bySlug('reviews'),
            'reviews' => Review::published()->ordered()->get(),
            'cases' => ReviewCase::ordered()->get(),
        ]);
    }

    public function guarantee(): View
    {
        return view('pages.guarantee', [
            'page' => Page::bySlug('guarantee'),
            'covers' => GuaranteeItem::query()->ofType('covers')->ordered()->get(),
            'excludes' => GuaranteeItem::query()->ofType('excludes')->ordered()->get(),
            'howto' => GuaranteeItem::query()->ofType('howto')->ordered()->get(),
            'docs' => GuaranteeDoc::ordered()->get(),
        ]);
    }

    public function about(): View
    {
        return view('pages.about', [
            'page' => Page::bySlug('about'),
            'principles' => Principle::ordered()->get(),
            'timeline' => TimelineEvent::ordered()->get(),
            'team' => TeamMember::ordered()->get(),
        ]);
    }

    public function careers(): View
    {
        return view('pages.careers', [
            'page' => Page::bySlug('careers'),
            'vacancies' => Vacancy::published()->ordered()->get(),
        ]);
    }
}
