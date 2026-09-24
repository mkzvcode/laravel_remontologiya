<?php

namespace App\Admin;

use App\Models\BlogPost;
use App\Models\Faq;
use App\Models\GuaranteeDoc;
use App\Models\GuaranteeItem;
use App\Models\PortfolioCase;
use App\Models\PriceCategory;
use App\Models\PriceItem;
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

/**
 * Единый реестр справочников для generic CRUD-движка админки.
 *
 * Каждый пункт описывает: какую модель редактируем, какие у неё поля
 * (и как их рисовать формой), какие колонки показать в таблице списка,
 * можно ли двигать порядок (order) и есть ли переключатель публикации.
 *
 * Так вместо контроллера+3 вьюх на каждую из ~18 однотипных сущностей
 * есть один ResourceController и общие resources/index.blade.php,
 * resources/form.blade.php — который просто рендерит поля по описанию.
 */
class ResourceRegistry
{
    public static function all(): array
    {
        return [
            'promises' => [
                'model' => Promise::class,
                'title' => 'Обещания (главная)',
                'singular' => 'обещание',
                'hint' => 'Блок «Четыре обещания» на главной странице.',
                'orderable' => true,
                'list_columns' => ['number', 'title'],
                'fields' => [
                    ['name' => 'number', 'label' => 'Номер', 'type' => 'text', 'rules' => 'required|max:8'],
                    ['name' => 'title', 'label' => 'Заголовок', 'type' => 'text', 'rules' => 'required|max:255'],
                    ['name' => 'text', 'label' => 'Текст', 'type' => 'textarea', 'rules' => 'required'],
                    ['name' => 'is_dark', 'label' => 'Тёмная карточка', 'type' => 'checkbox'],
                ],
            ],

            'services' => [
                'model' => Service::class,
                'title' => 'Услуги',
                'singular' => 'услугу',
                'hint' => 'Список услуг: страница «Услуги» и блок на главной (первые 3 с флагом «на главной»).',
                'orderable' => true,
                'toggle_column' => 'is_published',
                'list_columns' => ['number', 'title', 'price_label', 'is_featured_home', 'is_published'],
                'fields' => [
                    ['name' => 'number', 'label' => 'Номер', 'type' => 'text', 'rules' => 'required|max:8'],
                    ['name' => 'title', 'label' => 'Заголовок', 'type' => 'text', 'rules' => 'required|max:255'],
                    ['name' => 'price_label', 'label' => 'Цена (текст)', 'type' => 'text', 'rules' => 'nullable|max:255', 'hint' => 'Например: «от 8 900 ₽/м² · 40–70 дней»'],
                    ['name' => 'description', 'label' => 'Описание', 'type' => 'textarea', 'rules' => 'required'],
                    ['name' => 'image', 'label' => 'Фото', 'type' => 'image', 'rules' => 'nullable|image|max:5120'],
                    ['name' => 'image_alt', 'label' => 'Alt-текст фото', 'type' => 'text', 'rules' => 'nullable|max:255'],
                    ['name' => 'is_featured_home', 'label' => 'Показывать на главной', 'type' => 'checkbox'],
                    ['name' => 'is_published', 'label' => 'Опубликовано', 'type' => 'checkbox'],
                ],
            ],

            'service-perks' => [
                'model' => ServicePerk::class,
                'title' => 'Что входит всегда',
                'singular' => 'пункт',
                'hint' => 'Шесть карточек в конце страницы «Услуги».',
                'orderable' => true,
                'list_columns' => ['title'],
                'fields' => [
                    ['name' => 'title', 'label' => 'Заголовок', 'type' => 'text', 'rules' => 'required|max:255'],
                    ['name' => 'text', 'label' => 'Текст', 'type' => 'textarea', 'rules' => 'required'],
                ],
            ],

            'pricing-plans' => [
                'model' => PricingPlan::class,
                'title' => 'Тарифы',
                'singular' => 'тариф',
                'hint' => 'Четыре карточки тарифов на главной («03 — тарифы»).',
                'orderable' => true,
                'list_columns' => ['name', 'price_from', 'is_featured'],
                'fields' => [
                    ['name' => 'name', 'label' => 'Название', 'type' => 'text', 'rules' => 'required|max:255'],
                    ['name' => 'description', 'label' => 'Описание', 'type' => 'textarea', 'rules' => 'required'],
                    ['name' => 'price_from', 'label' => 'Цена «от»', 'type' => 'text', 'rules' => 'required|max:32'],
                    ['name' => 'price_unit', 'label' => 'Единица цены', 'type' => 'text', 'rules' => 'required|max:32', 'hint' => 'Например: ₽/м² или просто ₽'],
                    ['name' => 'bg_variant', 'label' => 'Фон карточки', 'type' => 'select', 'options' => ['white' => 'Белый', 'ink' => 'Тёмный (акцент)', 'sand' => 'Песочный'], 'rules' => 'required'],
                    ['name' => 'is_featured', 'label' => 'Отметить как «Хит»', 'type' => 'checkbox'],
                    ['name' => 'badge_text', 'label' => 'Текст плашки', 'type' => 'text', 'rules' => 'nullable|max:32'],
                    ['name' => 'items', 'label' => 'Пункты списка', 'type' => 'repeater', 'rules' => 'nullable'],
                    ['name' => 'cta_label', 'label' => 'Текст кнопки', 'type' => 'text', 'rules' => 'required|max:64'],
                ],
            ],

            'price-categories' => [
                'model' => PriceCategory::class,
                'title' => 'Прайс: разделы',
                'singular' => 'раздел',
                'hint' => 'Разделы прайса (Демонтаж, Стены и т.д.). Строки внутри — в разделе «Прайс: позиции».',
                'orderable' => true,
                'list_columns' => ['number', 'title', 'subtitle'],
                'fields' => [
                    ['name' => 'number', 'label' => 'Номер', 'type' => 'text', 'rules' => 'required|max:8'],
                    ['name' => 'title', 'label' => 'Заголовок', 'type' => 'text', 'rules' => 'required|max:255'],
                    ['name' => 'subtitle', 'label' => 'Подзаголовок', 'type' => 'text', 'rules' => 'nullable|max:255'],
                ],
            ],

            'price-items' => [
                'model' => PriceItem::class,
                'title' => 'Прайс: позиции',
                'singular' => 'позицию',
                'hint' => 'Отдельные строки прайса внутри раздела.',
                'orderable' => true,
                'order_scope' => 'price_category_id', // порядок считаем внутри своего раздела, а не по всему прайсу
                'list_columns' => ['price_category_id', 'name', 'unit', 'price_text'],
                'fields' => [
                    ['name' => 'price_category_id', 'label' => 'Раздел', 'type' => 'select_model', 'model' => PriceCategory::class, 'option_label' => 'title', 'rules' => 'required|exists:price_categories,id'],
                    ['name' => 'name', 'label' => 'Название работы', 'type' => 'text', 'rules' => 'required|max:255'],
                    ['name' => 'unit', 'label' => 'Единица', 'type' => 'text', 'rules' => 'required|max:32'],
                    ['name' => 'price_text', 'label' => 'Цена (текст)', 'type' => 'text', 'rules' => 'required|max:64'],
                ],
            ],

            'process-steps' => [
                'model' => ProcessStep::class,
                'title' => 'Этапы ремонта',
                'singular' => 'этап',
                'hint' => 'Блок «Как проходит ремонт» на главной («05»).',
                'orderable' => true,
                'list_columns' => ['number', 'title', 'meta'],
                'fields' => [
                    ['name' => 'number', 'label' => 'Номер', 'type' => 'text', 'rules' => 'required|max:8'],
                    ['name' => 'meta', 'label' => 'Подпись срока', 'type' => 'text', 'rules' => 'required|max:255', 'hint' => 'Например: «Выезжаем в день обращения · 1 день»'],
                    ['name' => 'title', 'label' => 'Заголовок', 'type' => 'text', 'rules' => 'required|max:255'],
                    ['name' => 'text_body', 'label' => 'Текст', 'type' => 'textarea', 'rules' => 'required'],
                    ['name' => 'image', 'label' => 'Фото', 'type' => 'image', 'rules' => 'nullable|image|max:5120'],
                    ['name' => 'image_alt', 'label' => 'Alt-текст фото', 'type' => 'text', 'rules' => 'nullable|max:255'],
                ],
            ],

            'portfolio-cases' => [
                'model' => PortfolioCase::class,
                'title' => 'Портфолио',
                'singular' => 'объект',
                'hint' => 'Карточки объектов на странице «Работы» и (с флагом) до/после на главной.',
                'orderable' => true,
                'toggle_column' => 'is_published',
                'list_columns' => ['code', 'title', 'kind', 'budget', 'is_published'],
                'fields' => [
                    ['name' => 'kind', 'label' => 'Тип (для фильтра)', 'type' => 'select', 'options' => ['cos' => 'Косметический', 'kap' => 'Капитальный', 'diz' => 'Дизайнерский'], 'rules' => 'required'],
                    ['name' => 'tag_label', 'label' => 'Подпись на фото', 'type' => 'text', 'rules' => 'required|max:64'],
                    ['name' => 'code', 'label' => 'Код объекта', 'type' => 'text', 'rules' => 'required|max:255', 'hint' => 'Например: «Объект №031 · Ленинский район»'],
                    ['name' => 'title', 'label' => 'Заголовок', 'type' => 'text', 'rules' => 'required|max:255'],
                    ['name' => 'image', 'label' => 'Фото «после»', 'type' => 'image', 'rules' => 'nullable|image|max:5120'],
                    ['name' => 'image_alt', 'label' => 'Alt-текст фото', 'type' => 'text', 'rules' => 'nullable|max:255'],
                    ['name' => 'image_before', 'label' => 'Фото «до» (для слайдера на главной)', 'type' => 'image', 'rules' => 'nullable|image|max:5120'],
                    ['name' => 'area', 'label' => 'Площадь', 'type' => 'text', 'rules' => 'required|max:32'],
                    ['name' => 'days', 'label' => 'Срок', 'type' => 'text', 'rules' => 'required|max:32'],
                    ['name' => 'budget', 'label' => 'Бюджет работ', 'type' => 'text', 'rules' => 'required|max:32'],
                    ['name' => 'delta', 'label' => 'Отклонение от сметы', 'type' => 'text', 'rules' => 'required|max:32'],
                    ['name' => 'text_body', 'label' => 'Текст', 'type' => 'textarea', 'rules' => 'required'],
                    ['name' => 'chips', 'label' => 'Метки работ', 'type' => 'repeater', 'rules' => 'nullable'],
                    ['name' => 'show_on_home', 'label' => 'Показывать в блоке «Было / стало» на главной', 'type' => 'checkbox'],
                    ['name' => 'is_published', 'label' => 'Опубликовано', 'type' => 'checkbox'],
                ],
            ],

            'reviews' => [
                'model' => Review::class,
                'title' => 'Отзывы',
                'singular' => 'отзыв',
                'hint' => 'Отзывы клиентов: страница «Отзывы» и (с флагом) блок на главной.',
                'orderable' => true,
                'toggle_column' => 'is_published',
                'list_columns' => ['name', 'meta', 'show_on_home', 'is_published'],
                'fields' => [
                    ['name' => 'name', 'label' => 'Имя', 'type' => 'text', 'rules' => 'required|max:255'],
                    ['name' => 'meta', 'label' => 'Подпись (что за ремонт)', 'type' => 'text', 'rules' => 'required|max:255'],
                    ['name' => 'text_body', 'label' => 'Текст отзыва', 'type' => 'textarea', 'rules' => 'required'],
                    ['name' => 'avatar_letter', 'label' => 'Буква на аватаре', 'type' => 'text', 'rules' => 'required|max:4'],
                    ['name' => 'is_dark', 'label' => 'Тёмная карточка', 'type' => 'checkbox'],
                    ['name' => 'show_on_home', 'label' => 'Показывать на главной', 'type' => 'checkbox'],
                    ['name' => 'is_published', 'label' => 'Опубликовано', 'type' => 'checkbox'],
                ],
            ],

            'review-cases' => [
                'model' => ReviewCase::class,
                'title' => 'Кейсы в цифрах',
                'singular' => 'кейс',
                'hint' => 'Три карточки «Что стояло за тремя отзывами» на странице «Отзывы».',
                'orderable' => true,
                'list_columns' => ['code', 'title', 'budget'],
                'fields' => [
                    ['name' => 'code', 'label' => 'Код объекта', 'type' => 'text', 'rules' => 'required|max:255'],
                    ['name' => 'title', 'label' => 'Заголовок', 'type' => 'text', 'rules' => 'required|max:255'],
                    ['name' => 'text_body', 'label' => 'Текст', 'type' => 'textarea', 'rules' => 'required'],
                    ['name' => 'image', 'label' => 'Фото', 'type' => 'image', 'rules' => 'nullable|image|max:5120'],
                    ['name' => 'image_alt', 'label' => 'Alt-текст фото', 'type' => 'text', 'rules' => 'nullable|max:255'],
                    ['name' => 'budget', 'label' => 'Сумма', 'type' => 'text', 'rules' => 'required|max:32'],
                    ['name' => 'note', 'label' => 'Короткая заметка', 'type' => 'text', 'rules' => 'required|max:64'],
                ],
            ],

            'guarantee-items' => [
                'model' => GuaranteeItem::class,
                'title' => 'Гарантия: пункты',
                'singular' => 'пункт',
                'hint' => 'Списки «Покрывает» / «Не покрывает» / «Как заявить» на странице «Гарантия».',
                'orderable' => true,
                'list_columns' => ['type', 'text'],
                'fields' => [
                    ['name' => 'type', 'label' => 'Колонка', 'type' => 'select', 'options' => ['covers' => 'Покрывает', 'excludes' => 'Не покрывает', 'howto' => 'Как заявить'], 'rules' => 'required'],
                    ['name' => 'text', 'label' => 'Текст', 'type' => 'textarea', 'rules' => 'required'],
                ],
            ],

            'guarantee-docs' => [
                'model' => GuaranteeDoc::class,
                'title' => 'Гарантия: документы',
                'singular' => 'документ',
                'hint' => 'Семь карточек документов на странице «Гарантия».',
                'orderable' => true,
                'list_columns' => ['number', 'title', 'is_featured'],
                'fields' => [
                    ['name' => 'number', 'label' => 'Номер', 'type' => 'text', 'rules' => 'required|max:8'],
                    ['name' => 'title', 'label' => 'Заголовок', 'type' => 'text', 'rules' => 'required|max:255'],
                    ['name' => 'text_body', 'label' => 'Текст', 'type' => 'textarea', 'rules' => 'required'],
                    ['name' => 'is_featured', 'label' => 'Выделить акцентом', 'type' => 'checkbox'],
                ],
            ],

            'team-members' => [
                'model' => TeamMember::class,
                'title' => 'Команда',
                'singular' => 'сотрудника',
                'hint' => 'Карточки сотрудников: страница «О компании» и (с флагом) главная.',
                'orderable' => true,
                'list_columns' => ['name', 'role', 'show_on_home'],
                'fields' => [
                    ['name' => 'name', 'label' => 'Имя', 'type' => 'text', 'rules' => 'required|max:255'],
                    ['name' => 'role', 'label' => 'Роль', 'type' => 'text', 'rules' => 'required|max:255'],
                    ['name' => 'avatar_letter', 'label' => 'Буква на аватаре', 'type' => 'text', 'rules' => 'required|max:4'],
                    ['name' => 'note', 'label' => 'Заметка', 'type' => 'textarea', 'rules' => 'required'],
                    ['name' => 'show_on_home', 'label' => 'Показывать на главной', 'type' => 'checkbox'],
                ],
            ],

            'principles' => [
                'model' => Principle::class,
                'title' => 'Принципы (о компании)',
                'singular' => 'принцип',
                'hint' => 'Блок «Пять правил» на странице «О компании».',
                'orderable' => true,
                'list_columns' => ['number', 'title'],
                'fields' => [
                    ['name' => 'number', 'label' => 'Номер', 'type' => 'text', 'rules' => 'required|max:8'],
                    ['name' => 'title', 'label' => 'Заголовок', 'type' => 'text', 'rules' => 'required|max:255'],
                    ['name' => 'text_body', 'label' => 'Текст', 'type' => 'textarea', 'rules' => 'required'],
                ],
            ],

            'timeline-events' => [
                'model' => TimelineEvent::class,
                'title' => 'Хронология',
                'singular' => 'событие',
                'hint' => 'Блок «Как мы дошли до 42 объектов» на странице «О компании».',
                'orderable' => true,
                'list_columns' => ['year', 'title'],
                'fields' => [
                    ['name' => 'year', 'label' => 'Год', 'type' => 'text', 'rules' => 'required|max:8'],
                    ['name' => 'title', 'label' => 'Заголовок', 'type' => 'text', 'rules' => 'required|max:255'],
                    ['name' => 'text_body', 'label' => 'Текст', 'type' => 'textarea', 'rules' => 'required'],
                ],
            ],

            'faqs' => [
                'model' => Faq::class,
                'title' => 'Вопросы и ответы',
                'singular' => 'вопрос',
                'hint' => 'Блок FAQ на главной странице.',
                'orderable' => true,
                'toggle_column' => 'is_published',
                'list_columns' => ['question', 'is_published'],
                'fields' => [
                    ['name' => 'question', 'label' => 'Вопрос', 'type' => 'text', 'rules' => 'required|max:255'],
                    ['name' => 'answer', 'label' => 'Ответ', 'type' => 'textarea', 'rules' => 'required'],
                    ['name' => 'is_published', 'label' => 'Опубликовано', 'type' => 'checkbox'],
                ],
            ],

            'blog-posts' => [
                'model' => BlogPost::class,
                'title' => 'Статьи блога',
                'singular' => 'статью',
                'hint' => 'Статьи блога — у каждой своя страница и SEO-мета.',
                'orderable' => true,
                'toggle_column' => 'is_published',
                'list_columns' => ['title', 'category_label', 'is_featured', 'is_published'],
                'fields' => [
                    ['name' => 'title', 'label' => 'Заголовок', 'type' => 'text', 'rules' => 'required|max:255'],
                    ['name' => 'slug', 'label' => 'URL (slug)', 'type' => 'text', 'rules' => 'required|max:255', 'hint' => 'Латиницей, через дефис. Меняйте с осторожностью — старые ссылки перестанут работать.'],
                    ['name' => 'category_label', 'label' => 'Рубрика', 'type' => 'text', 'rules' => 'required|max:64'],
                    ['name' => 'minutes_read', 'label' => 'Время чтения, мин', 'type' => 'number', 'rules' => 'required|integer|min:1|max:60'],
                    ['name' => 'cover_image', 'label' => 'Обложка', 'type' => 'image', 'rules' => 'nullable|image|max:5120'],
                    ['name' => 'cover_image_alt', 'label' => 'Alt-текст обложки', 'type' => 'text', 'rules' => 'nullable|max:255'],
                    ['name' => 'excerpt', 'label' => 'Анонс (для карточки)', 'type' => 'textarea', 'rules' => 'required'],
                    ['name' => 'body', 'label' => 'Текст статьи', 'type' => 'richtext', 'rules' => 'nullable', 'hint' => 'Пустая строка между абзацами — новый абзац.'],
                    ['name' => 'is_featured', 'label' => 'Главный материал (крупная карточка)', 'type' => 'checkbox'],
                    ['name' => 'is_published', 'label' => 'Опубликовано', 'type' => 'checkbox'],
                    ['name' => 'meta_title', 'label' => 'SEO: заголовок страницы', 'type' => 'text', 'rules' => 'nullable|max:255'],
                    ['name' => 'meta_description', 'label' => 'SEO: описание', 'type' => 'textarea', 'rules' => 'nullable|max:500'],
                ],
            ],

            'vacancies' => [
                'model' => Vacancy::class,
                'title' => 'Вакансии',
                'singular' => 'вакансию',
                'hint' => 'Карточки на странице «Вакансии».',
                'orderable' => true,
                'toggle_column' => 'is_published',
                'list_columns' => ['title', 'salary_from', 'is_published'],
                'fields' => [
                    ['name' => 'title', 'label' => 'Должность', 'type' => 'text', 'rules' => 'required|max:255'],
                    ['name' => 'description', 'label' => 'Описание', 'type' => 'textarea', 'rules' => 'required'],
                    ['name' => 'salary_from', 'label' => 'Оклад «от»', 'type' => 'text', 'rules' => 'required|max:64'],
                    ['name' => 'employment_type', 'label' => 'Занятость', 'type' => 'text', 'rules' => 'required|max:255'],
                    ['name' => 'is_published', 'label' => 'Опубликовано', 'type' => 'checkbox'],
                ],
            ],
        ];
    }

    public static function find(string $slug): ?array
    {
        return static::all()[$slug] ?? null;
    }
}
