@extends('layouts.app')

@section('title', $page->meta_title)
@section('description', $page->meta_description)
@php($ogImage = $page->og_image)

@section('content')
<main class="page" id="main">

  <section class="page-hero">
    <div class="wrap">
      <div class="page-hero__inner" style="max-width:920px">
        @include('partials.crumbs', ['label' => 'Работы'])
        <div class="eyebrow" style="margin-top:20px">{{ $page->hero_eyebrow }}</div>
        <h1 class="h2" data-reveal>{!! $page->hero_title_html !!}</h1>
        <p class="page-hero__lead" data-reveal>{{ $page->hero_lead }}</p>

        <div class="filters" data-filter data-reveal>
          <button class="filter" type="button" data-filter-value="all" aria-pressed="true">Все объекты</button>
          <button class="filter" type="button" data-filter-value="cos" aria-pressed="false">Косметические</button>
          <button class="filter" type="button" data-filter-value="kap" aria-pressed="false">Капитальные</button>
          <button class="filter" type="button" data-filter-value="diz" aria-pressed="false">Дизайнерские</button>
        </div>
        <div class="filters__count" data-filter-count aria-live="polite"></div>
      </div>
    </div>
  </section>

  <section class="section wrap">
    <div class="cases" data-filter-list>
      @foreach ($cases as $case)
      <article class="case" data-kind="{{ $case->kind }}" data-reveal>
        <figure class="case__media">
          <img src="{{ $case->image }}" alt="{{ $case->image_alt }}" loading="lazy">
          <figcaption>{{ $case->tag_label }}</figcaption>
        </figure>
        <div class="case__body">
          <div class="case__code">{{ $case->code }}</div>
          <h2 class="case__title">{{ $case->title }}</h2>
          <p class="case__text">{{ $case->text_body }}</p>
          <dl class="case__specs">
            <div><dt>Площадь</dt><dd>{{ $case->area }}</dd></div>
            <div><dt>Срок</dt><dd>{{ $case->days }}</dd></div>
            <div><dt>Бюджет работ</dt><dd>{{ $case->budget }}</dd></div>
            <div><dt>Отклонение</dt><dd class="is-good">{{ $case->delta }}</dd></div>
          </dl>
          @if (!empty($case->chips))
          <ul class="case__chips">
            @foreach ($case->chips as $chip)
            <li>{{ $chip }}</li>
            @endforeach
          </ul>
          @endif
          <a class="link-arrow" href="{{ route('home') }}#calc">Хочу похожий ремонт <span class="mono">→</span></a>
        </div>
      </article>
      @endforeach
    </div>
  </section>

  @php($sDetails = $page->section('details'))
  <section class="section--dark">
    <div class="wrap on-dark">
      <div style="max-width:720px" data-reveal>
        <div class="eyebrow">{{ $sDetails['eyebrow'] }}</div>
        <h2 class="h2" style="margin-top:18px">{!! $sDetails['title_html'] !!}</h2>
        <p class="body-text" style="margin-top:18px">{{ $sDetails['lead'] }}</p>
      </div>

      <div class="grid grid--3" style="margin-top:38px;gap:18px">
        <figure class="shot" data-reveal>
          <img src="/img/master-1000.webp" alt="Штукатурка стен по маякам" loading="lazy">
          <figcaption>Штукатурка по маякам · отклонение до 1 мм на 2 м правила</figcaption>
        </figure>
        <figure class="shot" data-reveal>
          <img src="/img/bathroom-900.webp" alt="Санузел, гидроизоляция" loading="lazy">
          <figcaption>Мокрые зоны · гидроизоляция в два слоя с заходом на стены</figcaption>
        </figure>
        <figure class="shot" data-reveal>
          <img src="/img/site-1500.webp" alt="Кухонная зона после ремонта" loading="lazy">
          <figcaption>Чистовая сдача · приёмка по чек-листу из 68 пунктов</figcaption>
        </figure>
      </div>
    </div>
  </section>

  @php($sCta = $page->section('cta'))
  <section class="section wrap">
    <div class="callout" style="margin-top:0;padding:36px 40px" data-reveal>
      <div>
        <div class="callout__title">{{ $sCta['title_html'] }}</div>
        <p class="small" style="margin-top:10px;max-width:560px">{{ $sCta['lead'] }}</p>
      </div>
      <div style="display:flex;flex-wrap:wrap;gap:12px">
        <a class="btn btn--ghost btn--sm btn--phone" href="tel:{{ \App\Models\Setting::current()->phone_e164 }}">{{ \App\Models\Setting::current()->phone_display }}</a>
        <a class="btn btn--primary btn--sm" href="{{ route('home') }}#contacts">Записаться на замер</a>
      </div>
    </div>
  </section>

</main>
@endsection
