@extends('layouts.app')

@section('title', $page->meta_title)
@section('description', $page->meta_description)
@php($ogImage = $page->og_image)

@section('content')
<main class="page" id="main">

  <section class="page-hero">
    <div class="wrap">
      <div class="page-hero__inner" style="max-width:920px">
        @include('partials.crumbs', ['label' => 'Блог'])
        <div class="eyebrow" style="margin-top:20px">{{ $page->hero_eyebrow }}</div>
        <h1 class="h2" data-reveal>{!! $page->hero_title_html !!}</h1>
        <p class="page-hero__lead" data-reveal>{{ $page->hero_lead }}</p>
        <div class="page-hero__actions" data-reveal>
          <a class="btn btn--primary btn--phone" href="{{ $page->hero_cta1_href }}">{{ $page->hero_cta1_label }}</a>
          <a class="btn btn--ghost-light" href="{{ $page->hero_cta2_href }}">{{ $page->hero_cta2_label }}</a>
        </div>
      </div>
    </div>
  </section>

  @if ($featured)
  <section class="section wrap">
    <article class="case" data-reveal>
      <figure class="case__media">
        @if ($featured->cover_image)
        <img src="{{ $featured->cover_image }}" alt="{{ $featured->cover_image_alt ?: $featured->title }}" loading="lazy">
        @endif
        <figcaption>Главное</figcaption>
      </figure>
      <div class="case__body">
        <div class="case__code">{{ $featured->category_label }} · {{ $featured->minutes_read }} мин чтения</div>
        <h2 class="case__title"><a href="{{ route('blog.show', $featured) }}" style="color:inherit">{{ $featured->title }}</a></h2>
        <p class="case__text">{{ $featured->excerpt }}</p>
        <a class="link-arrow" href="{{ route('blog.show', $featured) }}">Читать разбор <span class="mono">→</span></a>
      </div>
    </article>
  </section>
  @endif

  @if ($posts->isNotEmpty())
  <section class="section wrap">
    <div class="grid grid--3" style="gap:18px">
      @foreach ($posts as $post)
      <a class="post" data-reveal href="{{ route('blog.show', $post) }}">
        @if ($post->cover_image)
        <figure><img src="{{ $post->cover_image }}" alt="{{ $post->cover_image_alt ?: $post->title }}" loading="lazy"></figure>
        @endif
        <div class="post__body">
          <div class="post__meta">{{ $post->category_label }} · {{ $post->minutes_read }} мин</div>
          <h2 class="post__title">{{ $post->title }}</h2>
          <p class="post__excerpt">{{ $post->excerpt }}</p>
          <span class="post__more">Читать →</span>
        </div>
      </a>
      @endforeach
    </div>
  </section>
  @endif

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
