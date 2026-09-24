@extends('admin.layout')

@section('title', 'Страница: '.$page->meta_title)
@section('hint', 'Шапка страницы, SEO и заголовки блоков. Наполнение карточек (услуги, отзывы и т.д.) редактируется в соответствующих разделах слева.')

@section('content')
<form class="admin-form" method="POST" action="{{ route('admin.pages.update', $page->slug) }}" enctype="multipart/form-data">
  @csrf
  @method('PUT')

  <fieldset>
    <legend>SEO</legend>
    <div class="field">
      <label for="meta_title">Заголовок страницы (title)</label>
      <input type="text" id="meta_title" name="meta_title" value="{{ old('meta_title', $page->meta_title) }}">
    </div>
    <div class="field">
      <label for="meta_description">Описание (meta description)</label>
      <textarea id="meta_description" name="meta_description">{{ old('meta_description', $page->meta_description) }}</textarea>
    </div>
    <div class="field">
      <label>Картинка для соцсетей (Open Graph)</label>
      <div class="image-field">
        <img class="image-field__preview" src="{{ $page->og_image ?: 'https://placehold.co/84x84/ece5db/8a8177?text=%20' }}" alt="">
        <div class="image-field__controls">
          <input type="file" name="og_image" accept="image/*">
        </div>
      </div>
    </div>
  </fieldset>

  <fieldset>
    <legend>Шапка страницы</legend>
    <div class="field">
      <label for="hero_eyebrow">Глазок (маленькая надпись над заголовком)</label>
      <input type="text" id="hero_eyebrow" name="hero_eyebrow" value="{{ old('hero_eyebrow', $page->hero_eyebrow) }}">
    </div>
    <div class="field">
      <label for="hero_title_html">Заголовок H1</label>
      <textarea id="hero_title_html" name="hero_title_html">{{ old('hero_title_html', $page->hero_title_html) }}</textarea>
      <div class="hint">Можно использовать &lt;br&gt; и &lt;span class="accent"&gt;/&lt;span class="dim"&gt; для акцентов — как на сайте.</div>
    </div>
    <div class="field">
      <label for="hero_lead">Подзаголовок (лид-абзац)</label>
      <textarea id="hero_lead" name="hero_lead">{{ old('hero_lead', $page->hero_lead) }}</textarea>
    </div>

    <div class="field-grid">
      <div class="field">
        <label for="hero_cta1_label">Кнопка 1: текст</label>
        <input type="text" id="hero_cta1_label" name="hero_cta1_label" value="{{ old('hero_cta1_label', $page->hero_cta1_label) }}">
      </div>
      <div class="field">
        <label for="hero_cta1_href">Кнопка 1: ссылка</label>
        <input type="text" id="hero_cta1_href" name="hero_cta1_href" value="{{ old('hero_cta1_href', $page->hero_cta1_href) }}">
      </div>
      <div class="field">
        <label for="hero_cta2_label">Кнопка 2: текст</label>
        <input type="text" id="hero_cta2_label" name="hero_cta2_label" value="{{ old('hero_cta2_label', $page->hero_cta2_label) }}">
      </div>
      <div class="field">
        <label for="hero_cta2_href">Кнопка 2: ссылка</label>
        <input type="text" id="hero_cta2_href" name="hero_cta2_href" value="{{ old('hero_cta2_href', $page->hero_cta2_href) }}">
      </div>
    </div>

    @if ($page->slug === 'home')
    <div class="field">
      <label>Фото первого экрана</label>
      <div class="image-field">
        <img class="image-field__preview" src="{{ $page->hero_image ?: 'https://placehold.co/84x84/ece5db/8a8177?text=%20' }}" alt="">
        <div class="image-field__controls">
          <input type="file" name="hero_image" accept="image/*">
        </div>
      </div>
    </div>
    <div class="field-grid">
      <div class="field"><label for="hero_image_alt">Alt-текст фото</label><input type="text" id="hero_image_alt" name="hero_image_alt" value="{{ old('hero_image_alt', $page->hero_image_alt) }}"></div>
      <div class="field"><label for="hero_caption_meta">Подпись на фото (мелкая)</label><input type="text" id="hero_caption_meta" name="hero_caption_meta" value="{{ old('hero_caption_meta', $page->hero_caption_meta) }}"></div>
      <div class="field"><label for="hero_caption_title">Подпись на фото (заголовок)</label><input type="text" id="hero_caption_title" name="hero_caption_title" value="{{ old('hero_caption_title', $page->hero_caption_title) }}"></div>
      <div class="field"><label for="hero_caption_term">Подпись на фото (срок)</label><input type="text" id="hero_caption_term" name="hero_caption_term" value="{{ old('hero_caption_term', $page->hero_caption_term) }}"></div>
      <div class="field"><label for="hero_caption_note">Подпись на фото (заметка)</label><input type="text" id="hero_caption_note" name="hero_caption_note" value="{{ old('hero_caption_note', $page->hero_caption_note) }}"></div>
      <div class="field"><label for="hero_badge_label">Плашка: заголовок</label><input type="text" id="hero_badge_label" name="hero_badge_label" value="{{ old('hero_badge_label', $page->hero_badge_label) }}"></div>
      <div class="field"><label for="hero_badge_sum">Плашка: сумма</label><input type="text" id="hero_badge_sum" name="hero_badge_sum" value="{{ old('hero_badge_sum', $page->hero_badge_sum) }}"></div>
      <div class="field"><label for="hero_badge_note">Плашка: заметка</label><input type="text" id="hero_badge_note" name="hero_badge_note" value="{{ old('hero_badge_note', $page->hero_badge_note) }}"></div>
    </div>

    <div class="field" data-repeater>
      <label>Бегущая строка (список услуг)</label>
      <div class="repeater" data-repeater-list>
        @foreach (old('marquee_items', $page->marquee_items ?: ['']) as $line)
        <div class="repeater__row"><input type="text" name="marquee_items[]" value="{{ $line }}"><button type="button" class="repeater__remove">×</button></div>
        @endforeach
      </div>
      <button type="button" class="repeater__add" data-repeater-add>+ Добавить пункт</button>
      <template><div class="repeater__row"><input type="text" name="marquee_items[]" value=""><button type="button" class="repeater__remove">×</button></div></template>
    </div>
    @endif

    @if (!empty($page->hero_stats) || in_array($page->slug, ['home', 'reviews', 'careers'], true))
    <div class="field" data-repeater>
      <label>Цифры в шапке (например: «42» / «объектов сдано»)</label>
      <div class="repeater" data-repeater-list>
        @foreach (old('hero_stats', $page->hero_stats ?: [['num' => '', 'label' => '']]) as $stat)
        <div class="repeater__row is-pair">
          <input type="text" name="hero_stats[][num]" placeholder="Число" value="{{ $stat['num'] ?? '' }}" style="max-width:140px">
          <input type="text" name="hero_stats[][label]" placeholder="Подпись" value="{{ $stat['label'] ?? '' }}">
          <button type="button" class="repeater__remove">×</button>
        </div>
        @endforeach
      </div>
      <button type="button" class="repeater__add" data-repeater-add>+ Добавить цифру</button>
      <template>
        <div class="repeater__row is-pair">
          <input type="text" name="hero_stats[][num]" placeholder="Число" value="" style="max-width:140px">
          <input type="text" name="hero_stats[][label]" placeholder="Подпись" value="">
          <button type="button" class="repeater__remove">×</button>
        </div>
      </template>
    </div>
    @endif
  </fieldset>

  @foreach ($sectionMap as $key => $meta)
  @php($section = $page->section($key))
  <fieldset>
    <legend>{{ $meta['label'] }}</legend>

    @if (empty($meta['no_eyebrow']))
    <div class="field">
      <label for="sections_{{ $key }}_eyebrow">Глазок</label>
      <input type="text" id="sections_{{ $key }}_eyebrow" name="sections[{{ $key }}][eyebrow]" value="{{ old("sections.$key.eyebrow", $section['eyebrow']) }}">
    </div>
    @endif

    @if (empty($meta['no_title']))
    <div class="field">
      <label for="sections_{{ $key }}_title">Заголовок</label>
      <input type="text" id="sections_{{ $key }}_title" name="sections[{{ $key }}][title_html]" value="{{ old("sections.$key.title_html", $section['title_html']) }}">
      <div class="hint">Можно использовать &lt;span class="dim"&gt; / &lt;span class="accent"&gt; для акцента части текста.</div>
    </div>
    @endif

    @if (empty($meta['no_lead']))
    <div class="field">
      <label for="sections_{{ $key }}_lead">Текст</label>
      <textarea id="sections_{{ $key }}_lead" name="sections[{{ $key }}][lead]">{{ old("sections.$key.lead", $section['lead']) }}</textarea>
    </div>
    @endif

    @if (!empty($meta['stats']))
    @php($statValues = old("sections.$key.stats", $section['stats'] ?? [['num' => '', 'label' => '']]))
    <div class="field" data-repeater>
      <label>Цифры блока</label>
      <div class="repeater" data-repeater-list>
        @foreach ($statValues as $stat)
        <div class="repeater__row is-pair">
          <input type="text" name="sections[{{ $key }}][stats][][num]" placeholder="Число" value="{{ $stat['num'] ?? '' }}" style="max-width:140px">
          <input type="text" name="sections[{{ $key }}][stats][][label]" placeholder="Подпись" value="{{ $stat['label'] ?? '' }}">
          <button type="button" class="repeater__remove">×</button>
        </div>
        @endforeach
      </div>
      <button type="button" class="repeater__add" data-repeater-add>+ Добавить цифру</button>
      <template>
        <div class="repeater__row is-pair">
          <input type="text" name="sections[{{ $key }}][stats][][num]" placeholder="Число" value="" style="max-width:140px">
          <input type="text" name="sections[{{ $key }}][stats][][label]" placeholder="Подпись" value="">
          <button type="button" class="repeater__remove">×</button>
        </div>
      </template>
    </div>
    @endif
  </fieldset>
  @endforeach

  <button type="submit" class="admin-btn admin-btn--primary">Сохранить</button>
</form>
@endsection
