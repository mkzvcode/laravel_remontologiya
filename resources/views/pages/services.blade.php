@extends('layouts.app')

@section('title', $page->meta_title)
@section('description', $page->meta_description)
@php($ogImage = $page->og_image)

@section('content')
<main class="page" id="main">

  <section class="page-hero">
    <div class="wrap">
      <div class="page-hero__inner">
        @include('partials.crumbs', ['label' => 'Услуги'])
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

  @php($first = $services->first())
  @if ($first)
  <section class="section wrap">
    <article class="split" data-reveal>
      @if ($first->image)
      <figure class="split__media">
        <img src="{{ $first->image }}" alt="{{ $first->image_alt ?: $first->title }}" loading="lazy">
      </figure>
      @endif
      <div>
        <div class="eyebrow">{{ $first->number }} — {{ $first->price_label }}</div>
        <h2 class="h3" style="margin-top:18px">{{ $first->title }}</h2>
        <p class="body-text" style="margin-top:18px">{{ $first->description }}</p>
      </div>
    </article>
  </section>
  @endif

  @php($threeCol = $services->slice(1, 3))
  @if ($threeCol->isNotEmpty())
  <section class="section wrap">
    <div class="grid grid--3" style="gap:18px">
      @foreach ($threeCol as $service)
      <article class="post" data-reveal style="cursor:default">
        @if ($service->image)
        <figure><img src="{{ $service->image }}" alt="{{ $service->image_alt ?: $service->title }}" loading="lazy"></figure>
        @endif
        <div class="post__body">
          <div class="post__meta">{{ $service->number }} — {{ $service->price_label }}</div>
          <h2 class="post__title">{{ $service->title }}</h2>
          <p class="post__excerpt">{{ $service->description }}</p>
        </div>
      </article>
      @endforeach
    </div>
  </section>
  @endif

  @php($rest = $services->slice(4))
  @if ($rest->isNotEmpty())
  <section class="section wrap">
    <div class="grid grid--4" style="gap:16px;align-items:start">
      @foreach ($rest as $i => $service)
      <article class="card @if($i === $rest->count()-1) card--ink @endif" data-reveal>
        <div class="card__num">{{ $service->number }} — {{ $service->price_label }}</div>
        <h2 class="h4 card__title">{{ $service->title }}</h2>
        <p class="card__text">{{ $service->description }}</p>
      </article>
      @endforeach
    </div>
  </section>
  @endif

  @php($sPerks = $page->section('perks'))
  <section class="section--dark">
    <div class="wrap on-dark">
      <div style="max-width:720px" data-reveal>
        <div class="eyebrow">{{ $sPerks['eyebrow'] }}</div>
        <h2 class="h2" style="margin-top:18px">{!! $sPerks['title_html'] !!}</h2>
      </div>

      <div class="grid grid--3" style="margin-top:38px">
        @foreach ($perks as $perk)
        <article class="card card--ink" data-reveal style="background:rgba(246,242,236,.04);border-color:rgba(246,242,236,.13)">
          <h3 class="h4">{{ $perk->title }}</h3>
          <p class="card__text">{{ $perk->text }}</p>
        </article>
        @endforeach
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
