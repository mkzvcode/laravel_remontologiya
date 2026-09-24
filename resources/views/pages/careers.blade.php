@extends('layouts.app')

@section('title', $page->meta_title)
@section('description', $page->meta_description)
@php($ogImage = $page->og_image)

@section('content')
<main class="page" id="main">

  <section class="page-hero">
    <div class="wrap">
      <div class="page-hero__inner" style="max-width:920px">
        @include('partials.crumbs', ['label' => 'Вакансии'])
        <div class="eyebrow" style="margin-top:20px">{{ $page->hero_eyebrow }}</div>
        <h1 class="h2" data-reveal>{!! $page->hero_title_html !!}</h1>
        <p class="page-hero__lead" data-reveal>{{ $page->hero_lead }}</p>
        <div class="page-hero__actions" data-reveal>
          <a class="btn btn--primary btn--phone" href="{{ $page->hero_cta1_href }}">{{ $page->hero_cta1_label }}</a>
          <a class="btn btn--ghost-light" href="{{ $page->hero_cta2_href }}" rel="noopener">{{ $page->hero_cta2_label }}</a>
        </div>

        @if (!empty($page->hero_stats))
        <ul class="stat-strip" data-reveal>
          @foreach ($page->hero_stats as $stat)
          <li><b>{{ $stat['num'] }}</b><span>{{ $stat['label'] }}</span></li>
          @endforeach
        </ul>
        @endif
      </div>
    </div>
  </section>

  @php($sOpenings = $page->section('openings'))
  <section class="section wrap">
    <div style="max-width:720px" data-reveal>
      <div class="eyebrow">{{ $sOpenings['eyebrow'] }}</div>
      <h2 class="h2" style="margin-top:18px">{!! $sOpenings['title_html'] !!}</h2>
    </div>

    <div class="grid" style="margin-top:38px;gap:14px">
      @foreach ($vacancies as $vacancy)
      <article class="vacancy" data-reveal>
        <div>
          <h3 class="vacancy__title">{{ $vacancy->title }}</h3>
          <p class="vacancy__text">{{ $vacancy->description }}</p>
        </div>
        <div class="vacancy__pay">{{ $vacancy->salary_from }}<span>{{ $vacancy->employment_type }}</span></div>
        <a class="btn @if($loop->last) btn--primary @else btn--ghost @endif btn--sm" href="tel:{{ \App\Models\Setting::current()->phone_e164 }}">Откликнуться</a>
      </article>
      @endforeach
    </div>
  </section>

  @php($sRules = $page->section('rules'))
  <section class="section--dark">
    <div class="wrap on-dark">
      <div class="split">
        <div data-reveal>
          <div class="eyebrow">{{ $sRules['eyebrow'] }}</div>
          <h2 class="h3" style="margin-top:18px">{!! $sRules['title_html'] !!}</h2>
          <ul class="facts" style="margin-top:26px">
            <li><span>01</span>Объём и цена этапа согласованы до начала — переделок «за спасибо» не бывает</li>
            <li><span>02</span>Материалы на объекте вовремя: закупкой занимается компания, а не вы</li>
            <li><span>03</span>С клиентом общается прораб — мастер занят работой, а не переговорами</li>
            <li><span>04</span>Поток объектов круглый год, без простоев на межсезонье</li>
          </ul>
        </div>
        <figure class="split__media" data-reveal>
          <img src="/img/master-1000.webp" alt="Бригада на объекте" loading="lazy">
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
        <a class="btn btn--primary btn--sm" href="{{ \App\Models\Setting::current()->whatsapp_url }}" rel="noopener">Написать в WhatsApp</a>
      </div>
    </div>
  </section>

</main>
@endsection
