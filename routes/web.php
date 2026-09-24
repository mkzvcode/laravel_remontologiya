<?php

use App\Http\Controllers\Admin\AuthController as AdminAuthController;
use App\Http\Controllers\Admin\CalculatorController as AdminCalculatorController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\EstimateController as AdminEstimateController;
use App\Http\Controllers\Admin\LeadController as AdminLeadController;
use App\Http\Controllers\Admin\PageContentController as AdminPageContentController;
use App\Http\Controllers\Admin\ResourceController as AdminResourceController;
use App\Http\Controllers\Admin\SettingController as AdminSettingController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\LeadController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\SitemapController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Публичный сайт
|--------------------------------------------------------------------------
*/

Route::get('/', [PageController::class, 'home'])->name('home');
Route::get('/services', [PageController::class, 'services'])->name('services');
Route::get('/prices', [PageController::class, 'prices'])->name('prices');
Route::get('/portfolio', [PageController::class, 'portfolio'])->name('portfolio');
Route::get('/reviews', [PageController::class, 'reviews'])->name('reviews');
Route::get('/guarantee', [PageController::class, 'guarantee'])->name('guarantee');
Route::get('/about', [PageController::class, 'about'])->name('about');
Route::get('/careers', [PageController::class, 'careers'])->name('careers');

Route::get('/blog', [BlogController::class, 'index'])->name('blog.index');
Route::get('/blog/{post:slug}', [BlogController::class, 'show'])->name('blog.show');

Route::post('/leads', [LeadController::class, 'store'])->name('leads.store');

Route::get('/sitemap.xml', SitemapController::class)->name('sitemap');
Route::get('/robots.txt', function () {
    return response(
        "User-agent: *\nDisallow: /admin\nDisallow: /storage/uploads\n\nSitemap: ".url('/sitemap.xml')."\n",
        200,
        ['Content-Type' => 'text/plain; charset=UTF-8']
    );
})->name('robots');

/*
|--------------------------------------------------------------------------
| Админ-панель
|--------------------------------------------------------------------------
*/

Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('login', [AdminAuthController::class, 'create'])->name('login');
    Route::post('login', [AdminAuthController::class, 'store']);

    Route::middleware('auth')->group(function () {
        Route::post('logout', [AdminAuthController::class, 'destroy'])->name('logout');

        Route::get('/', AdminDashboardController::class)->name('dashboard');

        Route::get('settings', [AdminSettingController::class, 'edit'])->name('settings.edit');
        Route::put('settings', [AdminSettingController::class, 'update'])->name('settings.update');

        Route::get('calculator', [AdminCalculatorController::class, 'edit'])->name('calculator.edit');
        Route::put('calculator', [AdminCalculatorController::class, 'update'])->name('calculator.update');

        Route::get('estimate-example', [AdminEstimateController::class, 'edit'])->name('estimate.edit');
        Route::put('estimate-example', [AdminEstimateController::class, 'update'])->name('estimate.update');

        Route::get('pages/{page:slug}', [AdminPageContentController::class, 'edit'])->name('pages.edit');
        Route::put('pages/{page:slug}', [AdminPageContentController::class, 'update'])->name('pages.update');

        Route::get('leads', [AdminLeadController::class, 'index'])->name('leads.index');
        Route::patch('leads/{lead}/read', [AdminLeadController::class, 'markRead'])->name('leads.read');
        Route::delete('leads/{lead}', [AdminLeadController::class, 'destroy'])->name('leads.destroy');

        // Универсальный CRUD для однотипных справочников контента.
        Route::get('{resource}', [AdminResourceController::class, 'index'])->name('resource.index');
        Route::get('{resource}/create', [AdminResourceController::class, 'create'])->name('resource.create');
        Route::post('{resource}', [AdminResourceController::class, 'store'])->name('resource.store');
        Route::get('{resource}/{id}/edit', [AdminResourceController::class, 'edit'])->name('resource.edit');
        Route::put('{resource}/{id}', [AdminResourceController::class, 'update'])->name('resource.update');
        Route::delete('{resource}/{id}', [AdminResourceController::class, 'destroy'])->name('resource.destroy');
        Route::patch('{resource}/{id}/toggle', [AdminResourceController::class, 'toggle'])->name('resource.toggle');
        Route::patch('{resource}/{id}/move/{direction}', [AdminResourceController::class, 'move'])
            ->whereIn('direction', ['up', 'down'])
            ->name('resource.move');
    });
});
