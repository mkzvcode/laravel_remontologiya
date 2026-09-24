@extends('layouts.app')

@section('title', $page->meta_title)
@section('description', $page->meta_description)
@php($ogImage = $page->og_image)

@section('content')
<main class="page" id="main">

  <section class="page-hero">
    <div class="wrap">
      <div class="page-hero__inner" style="max-width:920px">
        @include('partials.crumbs', ['label' => 'О компании'])
        <div class="eyebrow" style="margin-top:20px">{{ $page->hero_eyebrow }}</div>
        <h1 class="h2" data-reveal>{!! $page->hero_title_html !!}</h1>
      </div>
    </div>
  </section>

  @php($sIntro = $page->section('intro'))
  <section class="section wrap">
    <div class="split" style="align-items:start" data-reveal>
      <div>
        @foreach (explode("\n\n", $sIntro['lead']) as $para)
        <p class="body-text" @if(!$loop->first) style="margin-top:18px" @endif>{{ $para }}</p>
        @endforeach
        @if (!empty($sIntro['stats']))
        <ul class="mini-stats">
          @foreach ($sIntro['stats'] as $stat)
          <li><b>{{ $stat['num'] }}</b><span>{{ $stat['label'] }}</span></li>
          @endforeach
        </ul>
        @endif
      </div>
      <figure class="split__media">
        <img src="/img/master-1000.webp" alt="Прораб и мастер на объекте" loading="lazy">
      </figure>
    </div>
  </section>

  @php($sPrinciples = $page->section('principles'))
  <section class="section--dark">
    <div class="wrap on-dark">
      <div style="max-width:720px" data-reveal>
        <div class="eyebrow">{{ $sPrinciples['eyebrow'] }}</div>
        <h2 class="h2" style="margin-top:18px">{!! $sPrinciples['title_html'] !!}</h2>
      </div>

      <div class="grid grid--3" style="margin-top:38px">
        @foreach ($principles as $p)
        <article class="card card--ink" data-reveal style="background:rgba(246,242,236,.04);border-color:rgba(246,242,236,.13)">
          <div class="card__num">{{ $p->number }}</div>
          <h3 class="h4 card__title">{{ $p->title }}</h3>
          <p class="card__text">{{ $p->text_body }}</p>
        </article>
        @endforeach

        <article class="card card--ink" data-reveal style="background:rgba(var(--accent-rgb),.16);border-color:rgba(var(--accent-rgb),.4);display:flex;flex-direction:column;justify-content:space-between;gap:20px">
          <h3 class="h4" style="font-size:20px;line-height:1.2">Хотите проверить нас на практике?</h3>
          <a class="link-arrow" style="color:var(--on-deep)" href="{{ route('home') }}#contacts">Записаться на бесплатный замер <span class="mono">→</span></a>
        </article>
      </div>
    </div>
  </section>

  @php($sTimeline = $page->section('timeline'))
  <section class="section wrap">
    <div style="max-width:720px" data-reveal>
      <div class="eyebrow">{{ $sTimeline['eyebrow'] }}</div>
      <h2 class="h2" style="margin-top:18px">{!! $sTimeline['title_html'] !!}</h2>
    </div>

    <ol class="timeline" style="margin-top:38px">
      @foreach ($timeline as $event)
      <li data-reveal>
        <div class="timeline__year">{{ $event->year }}</div>
        <div>
          <h3 class="timeline__title">{{ $event->title }}</h3>
          <p class="timeline__text">{{ $event->text_body }}</p>
        </div>
      </li>
      @endforeach
    </ol>
  </section>

  @php($sTeam = $page->section('team'))
  <section class="section wrap">
    <div style="max-width:720px" data-reveal>
      <div class="eyebrow">{{ $sTeam['eyebrow'] }}</div>
      <h2 class="h2" style="margin-top:18px">{!! $sTeam['title_html'] !!}</h2>
      <p class="body-text" style="margin-top:18px">{{ $sTeam['lead'] }}</p>
    </div>

    <div class="grid grid--4" style="margin-top:38px;align-items:start">
      @foreach ($team as $member)
      <article class="card" data-reveal>
        <span class="people__avatar" aria-hidden="true">{{ $member->avatar_letter }}</span>
        <h3 class="h4" style="margin-top:18px">{{ $member->name }}</h3>
        <div class="people__role">{{ $member->role }}</div>
        <p class="card__text">{{ $member->note }}</p>
      </article>
      @endforeach
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
        <a class="btn btn--primary btn--sm" href="{{ route('home') }}#calc">Рассчитать стоимость</a>
      </div>
    </div>
  </section>

</main>
@endsection
