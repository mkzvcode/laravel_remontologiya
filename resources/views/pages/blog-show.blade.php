@extends('layouts.app')
@php($navKey = 'blog')

@section('title', ($post->meta_title ?: $post->title))
@section('description', ($post->meta_description ?: $post->excerpt))
@php($ogImage = $post->cover_image)

@section('content')
<main class="page" id="main">

  <section class="page-hero">
    <div class="wrap">
      <div class="page-hero__inner" style="max-width:760px">
        <nav class="crumbs" aria-label="Хлебные крошки">
          <a href="{{ route('home') }}">Главная</a> <span aria-hidden="true">/</span>
          <a href="{{ route('blog.index') }}">Блог</a> <span aria-hidden="true">/</span>
          <span>{{ $post->title }}</span>
        </nav>
        <div class="eyebrow" style="margin-top:20px">{{ $post->category_label }} · {{ $post->minutes_read }} мин чтения</div>
        <h1 class="h2" data-reveal>{{ $post->title }}</h1>
        <p class="page-hero__lead" data-reveal>{{ $post->excerpt }}</p>
      </div>
    </div>
  </section>

  <section class="section wrap">
    <article class="grid" style="max-width:760px;margin:0 auto;gap:22px" data-reveal>
      @if ($post->cover_image)
      <figure class="shot" style="aspect-ratio:16/9">
        <img src="{{ $post->cover_image }}" alt="{{ $post->cover_image_alt ?: $post->title }}">
      </figure>
      @endif

      <div class="body-text" style="font-size:17px;line-height:1.75;color:var(--text-2)">
        @foreach (preg_split("/\n\s*\n/", trim($post->body ?: $post->excerpt)) as $para)
        <p @if(!$loop->first) style="margin-top:20px" @endif>{{ $para }}</p>
        @endforeach
      </div>
    </article>

    <div class="callout" style="margin-top:56px;max-width:760px;margin-left:auto;margin-right:auto;padding:32px" data-reveal>
      <div>
        <div class="callout__title">Есть похожий вопрос по вашей квартире?</div>
        <p class="small" style="margin-top:10px;max-width:480px">Прораб ответит по делу за один звонок — без скриптов и «уточню и перезвоню».</p>
      </div>
      <a class="btn btn--primary btn--sm" href="tel:{{ \App\Models\Setting::current()->phone_e164 }}">{{ \App\Models\Setting::current()->phone_display }}</a>
    </div>
  </section>

  @if ($related->isNotEmpty())
  <section class="section wrap">
    <div style="max-width:720px" data-reveal>
      <div class="eyebrow">Читайте также</div>
      <h2 class="h3" style="margin-top:18px">Другие разборы</h2>
    </div>
    <div class="grid grid--3" style="margin-top:32px;gap:18px">
      @foreach ($related as $r)
      <a class="post" data-reveal href="{{ route('blog.show', $r) }}">
        @if ($r->cover_image)
        <figure><img src="{{ $r->cover_image }}" alt="{{ $r->cover_image_alt ?: $r->title }}" loading="lazy"></figure>
        @endif
        <div class="post__body">
          <div class="post__meta">{{ $r->category_label }} · {{ $r->minutes_read }} мин</div>
          <h2 class="post__title">{{ $r->title }}</h2>
          <p class="post__excerpt">{{ $r->excerpt }}</p>
          <span class="post__more">Читать →</span>
        </div>
      </a>
      @endforeach
    </div>
  </section>
  @endif

</main>
@endsection

@push('jsonld')
<script type="application/ld+json">
{!! json_encode([
    '@context' => 'https://schema.org',
    '@type' => 'Article',
    'headline' => $post->title,
    'description' => $post->excerpt,
    'image' => $post->cover_image ? url($post->cover_image) : null,
    'datePublished' => optional($post->published_at)->toAtomString(),
    'dateModified' => $post->updated_at->toAtomString(),
    'author' => ['@type' => 'Organization', 'name' => \App\Models\Setting::current()->brand_name],
], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) !!}
</script>
@endpush
