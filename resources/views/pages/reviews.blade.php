@extends('layouts.app')

@section('title', $page->meta_title)
@section('description', $page->meta_description)
@php($ogImage = $page->og_image)

@section('content')
<main class="page" id="main">

  <section class="page-hero">
    <div class="wrap">
      <div class="page-hero__inner" style="max-width:920px">
        @include('partials.crumbs', ['label' => 'Отзывы и кейсы'])
        <div class="eyebrow" style="margin-top:20px">{{ $page->hero_eyebrow }}</div>
        <h1 class="h2" data-reveal>{!! $page->hero_title_html !!}</h1>
        <p class="page-hero__lead" data-reveal>{{ $page->hero_lead }}</p>
        <div class="page-hero__actions" data-reveal>
          <a class="btn btn--primary" href="{{ $page->hero_cta1_href }}">{{ $page->hero_cta1_label }}</a>
          <a class="btn btn--ghost-light" href="{{ $page->hero_cta2_href }}">{{ $page->hero_cta2_label }}</a>
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

  @php($sList = $page->section('list'))
  <section class="section wrap">
    <div style="max-width:720px" data-reveal>
      <div class="eyebrow">{{ $sList['eyebrow'] }}</div>
      <h2 class="h2" style="margin-top:18px">{!! $sList['title_html'] !!}</h2>
    </div>

    <div class="grid grid--3" style="margin-top:40px">
      @foreach ($reviews as $review)
      <blockquote class="quote @if($review->is_dark) quote--ink @endif" data-reveal>
        <div class="quote__mark" aria-hidden="true">“</div>
        <p class="quote__text">{{ $review->text_body }}</p>
        <footer>
          <span class="quote__avatar" aria-hidden="true">{{ $review->avatar_letter }}</span>
          <span><b class="quote__name">{{ $review->name }}</b><br><span class="quote__meta">{{ $review->meta }}</span></span>
        </footer>
      </blockquote>
      @endforeach
    </div>
  </section>

  @php($sCases = $page->section('cases'))
  <section class="section--dark">
    <div class="wrap on-dark">
      <div style="max-width:720px" data-reveal>
        <div class="eyebrow">{{ $sCases['eyebrow'] }}</div>
        <h2 class="h2" style="margin-top:18px">{!! $sCases['title_html'] !!}</h2>
      </div>

      <div class="grid grid--3" style="margin-top:38px;gap:18px">
        @foreach ($cases as $case)
        <article class="svc-card" data-reveal style="cursor:default">
          @if ($case->image)
          <figure><img src="{{ $case->image }}" alt="{{ $case->image_alt ?: $case->title }}" loading="lazy"></figure>
          @endif
          <div class="svc-card__body">
            <div class="svc-card__price">{{ $case->code }}</div>
            <h3 class="svc-card__title">{{ $case->title }}</h3>
            <p class="svc-card__text">{{ $case->text_body }}</p>
            <div class="case-figures"><b>{{ $case->budget }}</b><span>{{ $case->note }}</span></div>
          </div>
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
