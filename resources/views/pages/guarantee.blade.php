@extends('layouts.app')

@section('title', $page->meta_title)
@section('description', $page->meta_description)
@php($ogImage = $page->og_image)

@section('content')
<main class="page" id="main">

  <section class="page-hero">
    <div class="wrap">
      <div class="page-hero__inner" style="max-width:920px">
        @include('partials.crumbs', ['label' => 'Гарантия и документы'])
        <div class="eyebrow" style="margin-top:20px">{{ $page->hero_eyebrow }}</div>
        <h1 class="h2" data-reveal>{!! $page->hero_title_html !!}</h1>
        <p class="page-hero__lead" data-reveal>{{ $page->hero_lead }}</p>
        <div class="page-hero__actions" data-reveal>
          <a class="btn btn--primary" href="{{ $page->hero_cta1_href }}">{{ $page->hero_cta1_label }}</a>
          <a class="btn btn--ghost-light" href="{{ $page->hero_cta2_href }}">{{ $page->hero_cta2_label }}</a>
        </div>
      </div>
    </div>
  </section>

  <section class="section wrap">
    <div class="grid grid--3" style="align-items:start">
      <article class="card card--flat" data-reveal>
        <div class="eyebrow">Покрывает</div>
        <h2 class="h4" style="margin-top:14px">Что переделаем бесплатно</h2>
        <ul class="facts" style="margin-top:18px;gap:0">
          @foreach ($covers as $item)
          <li style="background:none;border:0;padding:8px 0"><span>+</span>{{ $item->text }}</li>
          @endforeach
        </ul>
      </article>

      <article class="card card--flat" data-reveal>
        <div class="eyebrow">Не покрывает</div>
        <h2 class="h4" style="margin-top:14px">Честно о границах</h2>
        <ul class="facts" style="margin-top:18px;gap:0">
          @foreach ($excludes as $item)
          <li style="background:none;border:0;padding:8px 0"><span>—</span>{{ $item->text }}</li>
          @endforeach
        </ul>
        <p class="small" style="margin-top:16px">Даже в этих случаях приезжаем на осмотр бесплатно и говорим, что произошло и сколько будет стоить ремонт.</p>
      </article>

      <article class="card card--flat card--ink" data-reveal>
        <div class="eyebrow">Как заявить</div>
        <h2 class="h4" style="margin-top:14px">Три шага и без экспертиз</h2>
        <ol class="facts" style="margin-top:18px;gap:0">
          @foreach ($howto as $i => $item)
          <li style="background:none;border:0;padding:10px 0;color:var(--d-text-2)"><span>{{ str_pad($i + 1, 2, '0', STR_PAD_LEFT) }}</span>{{ $item->text }}</li>
          @endforeach
        </ol>
        <a class="btn btn--primary btn--block" style="margin-top:22px" href="tel:{{ \App\Models\Setting::current()->phone_e164 }}">Заявка по гарантии</a>
      </article>
    </div>
  </section>

  @php($sDocs = $page->section('docs'))
  <section class="section--dark">
    <div class="wrap on-dark">
      <div style="max-width:760px" data-reveal>
        <div class="eyebrow">{{ $sDocs['eyebrow'] }}</div>
        <h2 class="h2" style="margin-top:18px">{!! $sDocs['title_html'] !!}</h2>
        <p class="body-text" style="margin-top:18px">{{ $sDocs['lead'] }}</p>
      </div>

      <div class="docs" style="margin-top:38px">
        @foreach ($docs as $doc)
        <article class="doc" data-reveal style="{{ $doc->is_featured ? 'background:rgba(var(--accent-rgb),.16);border-color:rgba(var(--accent-rgb),.4)' : 'background:rgba(246,242,236,.04);border-color:rgba(246,242,236,.13)' }};color:var(--d-text)">
          <div class="doc__num">{{ $doc->number }}</div>
          <h3 class="doc__title">{{ $doc->title }}</h3>
          <p class="doc__text" style="color:{{ $doc->is_featured ? 'var(--d-text-2)' : 'var(--d-text-4)' }}">{{ $doc->text_body }}</p>
        </article>
        @endforeach
      </div>
    </div>
  </section>

  @php($sChecklist = $page->section('checklist'))
  <section class="section wrap">
    <div class="split" data-reveal>
      <figure class="split__media">
        <img src="/img/step-5-1040.webp" alt="Приёмка работ по чек-листу" loading="lazy">
      </figure>
      <div>
        <div class="eyebrow">{{ $sChecklist['eyebrow'] }}</div>
        <h2 class="h3" style="margin-top:18px">{!! $sChecklist['title_html'] !!}</h2>
        <p class="body-text" style="margin-top:18px">{{ $sChecklist['lead'] }}</p>
        @if (!empty($sChecklist['stats']))
        <ul class="mini-stats">
          @foreach ($sChecklist['stats'] as $stat)
          <li><b>{{ $stat['num'] }}</b><span>{{ $stat['label'] }}</span></li>
          @endforeach
        </ul>
        @endif
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
        <a class="btn btn--primary btn--sm" href="{{ route('home') }}#contacts">Запросить документы</a>
      </div>
    </div>
  </section>

</main>
@endsection
