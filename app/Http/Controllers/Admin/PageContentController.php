<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Page;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\View\View;

class PageContentController extends Controller
{
    /**
     * Какие именованные секции есть на каждой странице и как их рисовать.
     * 'no_eyebrow'/'no_title'/'no_lead' скрывают лишние поля там, где текста
     * в оригинальном макете не было (например, у подвальных CTA нет глазка).
     * 'stats' задаёт число мини-статистик (num+label) внутри секции.
     */
    public static function sectionMap(string $slug): array
    {
        $cta = ['label' => 'Плашка-призыв в конце страницы', 'no_eyebrow' => true];

        return match ($slug) {
            'home' => [
                'promises' => ['label' => '01 — Обещания'],
                'services' => ['label' => 'Услуги', 'no_lead' => true],
                'calc' => ['label' => '02 — Калькулятор'],
                'pricing' => ['label' => '03 — Тарифы'],
                'works' => ['label' => '04 — Наши работы', 'no_lead' => true],
                'process' => ['label' => '05 — Как проходит ремонт'],
                'guarantees' => ['label' => '06 — Гарантии', 'no_lead' => true],
                'team' => ['label' => '07 — Команда'],
                'reviews' => ['label' => '08 — Отзывы', 'no_lead' => true],
                'faq' => ['label' => '09 — Вопросы'],
                'contacts' => ['label' => '10 — Контакты'],
                'footer_cta' => ['label' => 'Подвал: заголовок-призыв', 'no_eyebrow' => true, 'no_lead' => true],
            ],
            'services' => [
                'perks' => ['label' => 'Что входит всегда'],
                'cta' => $cta,
            ],
            'prices' => [
                'catalog' => ['label' => 'Прайс на работы'],
                'cta' => $cta,
            ],
            'portfolio' => [
                'details' => ['label' => 'Детали (черновые этапы)'],
                'cta' => $cta,
            ],
            'reviews' => [
                'list' => ['label' => 'Отзывы (заголовок блока)', 'no_lead' => true],
                'cases' => ['label' => 'Кейсы в цифрах', 'no_lead' => true],
                'cta' => $cta,
            ],
            'guarantee' => [
                'docs' => ['label' => 'Документы'],
                'checklist' => ['label' => 'Приёмка (чек-лист)', 'stats' => 3],
                'cta' => $cta,
            ],
            'about' => [
                'intro' => ['label' => 'Вступление', 'no_eyebrow' => true, 'no_title' => true, 'stats' => 4],
                'principles' => ['label' => 'Принципы', 'no_lead' => true],
                'timeline' => ['label' => 'Хронология', 'no_lead' => true],
                'team' => ['label' => 'Команда'],
                'cta' => $cta,
            ],
            'blog' => [
                'cta' => $cta,
            ],
            'careers' => [
                'openings' => ['label' => 'Открытые вакансии', 'no_lead' => true],
                'rules' => ['label' => 'Как мы работаем с бригадой', 'no_lead' => true],
                'cta' => $cta,
            ],
            default => [],
        };
    }

    public function edit(Page $page): View
    {
        return view('admin.pages.edit', [
            'page' => $page,
            'sectionMap' => static::sectionMap($page->slug),
        ]);
    }

    public function update(Request $request, Page $page): RedirectResponse
    {
        $data = $request->validate([
            'meta_title' => ['required', 'string', 'max:255'],
            'meta_description' => ['nullable', 'string', 'max:500'],
            'og_image' => ['nullable', 'image', 'max:5120'],
            'hero_eyebrow' => ['nullable', 'string', 'max:255'],
            'hero_title_html' => ['nullable', 'string', 'max:1000'],
            'hero_lead' => ['nullable', 'string', 'max:2000'],
            'hero_cta1_label' => ['nullable', 'string', 'max:64'],
            'hero_cta1_href' => ['nullable', 'string', 'max:255'],
            'hero_cta2_label' => ['nullable', 'string', 'max:64'],
            'hero_cta2_href' => ['nullable', 'string', 'max:255'],
            'hero_image' => ['nullable', 'image', 'max:5120'],
            'hero_image_alt' => ['nullable', 'string', 'max:255'],
            'hero_badge_label' => ['nullable', 'string', 'max:255'],
            'hero_badge_sum' => ['nullable', 'string', 'max:64'],
            'hero_badge_note' => ['nullable', 'string', 'max:255'],
            'hero_caption_meta' => ['nullable', 'string', 'max:255'],
            'hero_caption_title' => ['nullable', 'string', 'max:255'],
            'hero_caption_term' => ['nullable', 'string', 'max:64'],
            'hero_caption_note' => ['nullable', 'string', 'max:64'],
        ]);

        // Изображения — заливаем только если реально прислали новый файл.
        foreach (['og_image', 'hero_image'] as $imageField) {
            if ($request->hasFile($imageField)) {
                $old = $page->{$imageField};
                $data[$imageField] = '/storage/'.$request->file($imageField)->store('uploads', 'public');
                if ($old && str_starts_with($old, '/storage/')) {
                    Storage::disk('public')->delete(Str::after($old, '/storage/'));
                }
            } else {
                unset($data[$imageField]);
            }
        }

        // Статистики в шапке (num/label): произвольное число строк, пустые отбрасываем.
        $heroStats = collect($request->input('hero_stats', []))
            ->filter(fn ($row) => trim($row['num'] ?? '') !== '' || trim($row['label'] ?? '') !== '')
            ->map(fn ($row) => ['num' => trim($row['num'] ?? ''), 'label' => trim($row['label'] ?? '')])
            ->values()
            ->all();
        $data['hero_stats'] = $heroStats;

        // Бегущая строка (только на главной, но поле общее и безвредное для остальных).
        $marquee = collect($request->input('marquee_items', []))
            ->map(fn ($v) => trim((string) $v))
            ->filter()
            ->values()
            ->all();
        $data['marquee_items'] = $marquee;

        // Секции: eyebrow/title_html/lead (+опциональные stats) по фиксированному набору ключей страницы.
        $sections = [];
        foreach (static::sectionMap($page->slug) as $key => $meta) {
            $input = $request->input("sections.$key", []);
            $section = [
                'eyebrow' => trim($input['eyebrow'] ?? ''),
                'title_html' => trim($input['title_html'] ?? ''),
                'lead' => trim($input['lead'] ?? ''),
            ];

            if (! empty($meta['stats'])) {
                $section['stats'] = collect($input['stats'] ?? [])
                    ->filter(fn ($row) => trim($row['num'] ?? '') !== '' || trim($row['label'] ?? '') !== '')
                    ->map(fn ($row) => ['num' => trim($row['num'] ?? ''), 'label' => trim($row['label'] ?? '')])
                    ->values()
                    ->all();
            }

            $sections[$key] = $section;
        }
        $data['sections'] = $sections;

        $page->update($data);

        return back()->with('status', 'Страница сохранена.');
    }
}
