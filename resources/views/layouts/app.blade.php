<?php
    $settings = \App\Models\Setting::current();
    $navKey = $navKey ?? ($page->nav_key ?? null);
    $calcJs = \App\Models\CalculatorSetting::current()->toJsSettings();
?><!DOCTYPE html>
<html lang="ru">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<script>
  // Применяем ручной выбор темы ДО отрисовки CSS — иначе на долю секунды
  // мелькнёт системная тема, а потом сменится на сохранённую.
  try {
    var t = localStorage.getItem('theme');
    if (t === 'dark' || t === 'light') document.documentElement.setAttribute('data-theme', t);
  } catch (e) {}
</script>
<title>@yield('title', $settings->brand_name)</title>
<meta name="description" content="@yield('description', $settings->footer_about)">
<link rel="canonical" href="{{ url()->current() }}">
<meta name="theme-color" content="#12140c">
<meta property="og:type" content="website">
<meta property="og:site_name" content="{{ $settings->brand_name }}">
<meta property="og:title" content="@yield('title', $settings->brand_name)">
<meta property="og:description" content="@yield('description', $settings->footer_about)">
<meta property="og:image" content="{{ url(trim(($ogImage ?? $settings->og_image) ?: '/img/hero-living-1200.webp')) }}">
<meta property="og:url" content="{{ url()->current() }}">
<meta name="twitter:card" content="summary_large_image">
<meta name="csrf-token" content="{{ csrf_token() }}">
<meta name="lead-action" content="{{ route('leads.store') }}">
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=Baloo+2:wght@700;800&family=Manrope:wght@400;500;600;700&family=JetBrains+Mono:wght@400;500&display=swap" rel="stylesheet">
<link rel="stylesheet" href="{{ asset('assets/css/style.css') }}?v={{ @filemtime(public_path('assets/css/style.css')) ?: time() }}">
<script type="application/ld+json">
{!! json_encode([
    '@context' => 'https://schema.org',
    '@type' => 'HomeAndConstructionBusiness',
    'name' => $settings->brand_name,
    'image' => url(($settings->og_image) ?: '/img/hero-living-1200.webp'),
    'telephone' => $settings->phone_e164,
    'email' => $settings->email,
    'url' => url('/'),
    'areaServed' => 'Челябинск',
    'address' => [
        '@type' => 'PostalAddress',
        'addressLocality' => 'Челябинск',
        'addressCountry' => 'RU',
    ],
], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) !!}
</script>
@stack('jsonld')
@if ($settings->metrika_id)
<script>
    (function(m,e,t,r,i,k,a){m[i]=m[i]||function(){(m[i].a=m[i].a||[]).push(arguments)};
    m[i].l=1*new Date();k=e.createElement(t),a=e.getElementsByTagName(t)[0],k.async=1,k.src=r,a.parentNode.insertBefore(k,a)})
    (window, document, "script", "https://mc.yandex.ru/metrika/tag.js", "ym");
    ym({{ (int) $settings->metrika_id }}, "init", { clickmap:true, trackLinks:true, accurateTrackBounce:true });
</script>
@endif
@if ($settings->ga_id)
<script async src="https://www.googletagmanager.com/gtag/js?id={{ $settings->ga_id }}"></script>
<script>
    window.dataLayer = window.dataLayer || [];
    function gtag(){ dataLayer.push(arguments); }
    gtag('js', new Date());
    gtag('config', '{{ $settings->ga_id }}');
</script>
@endif
</head>
<body>

<a class="skip-link" href="#main">К основному содержимому</a>
<div class="progress-bar" aria-hidden="true"></div>

@hasSection('snake')
    @yield('snake')
@endif

<header class="site-header">
  <div class="site-header__inner">
    <a class="brand" href="{{ route('home') }}">
      @include('partials.logo')
      <span class="brand__text"><span class="brand__meta">{{ $settings->brand_meta }}</span></span>
    </a>

    <nav class="site-nav" aria-label="Основное меню">
      <a href="{{ route('services') }}" {!! $navKey === 'services' ? 'aria-current="page"' : '' !!}>Услуги</a>
      <a href="{{ route('prices') }}" {!! $navKey === 'prices' ? 'aria-current="page"' : '' !!}>Цены</a>
      <a href="{{ route('portfolio') }}" {!! $navKey === 'portfolio' ? 'aria-current="page"' : '' !!}>Работы</a>
      <a href="{{ route('reviews') }}" {!! $navKey === 'reviews' ? 'aria-current="page"' : '' !!}>Отзывы</a>
      <a href="{{ route('guarantee') }}" {!! $navKey === 'guarantee' ? 'aria-current="page"' : '' !!}>Гарантия</a>
      <a href="{{ route('blog.index') }}" {!! $navKey === 'blog' ? 'aria-current="page"' : '' !!}>Блог</a>
      <a href="{{ route('about') }}" {!! $navKey === 'about' ? 'aria-current="page"' : '' !!}>О компании</a>
    </nav>

    <div class="site-header__actions">
      <button class="theme-toggle" type="button" aria-label="Переключить тему" aria-pressed="false">
        <svg class="i-sun" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" aria-hidden="true"><circle cx="12" cy="12" r="4.2"/><path d="M12 2.5v2.6M12 18.9v2.6M4.6 4.6l1.8 1.8M17.6 17.6l1.8 1.8M2.5 12h2.6M18.9 12h2.6M4.6 19.4l1.8-1.8M17.6 6.4l1.8-1.8"/></svg>
        <svg class="i-moon" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M20.4 14.7A8.5 8.5 0 019.3 3.6a.7.7 0 00-.9-.9A9.9 9.9 0 1021.3 15.6a.7.7 0 00-.9-.9z"/></svg>
      </button>
      <a class="site-header__phone" href="tel:{{ $settings->phone_e164 }}">{{ $settings->phone_display }}</a>
      <a class="btn btn--ink site-header__cta" href="{{ $navKey === null ? '#calc' : route('home').'#calc' }}">Рассчитать ремонт</a>
      <button class="burger" type="button" aria-label="Меню" aria-expanded="false" aria-controls="mobile-nav">☰</button>
    </div>

    <nav class="mobile-nav" id="mobile-nav" aria-label="Меню (мобильное)">
      <a href="{{ route('services') }}">Услуги</a>
      <a href="{{ route('prices') }}">Цены и сметы</a>
      <a href="{{ route('portfolio') }}">Работы</a>
      <a href="{{ route('reviews') }}">Отзывы и кейсы</a>
      <a href="{{ route('guarantee') }}">Гарантия и документы</a>
      <a href="{{ route('blog.index') }}">Блог</a>
      <a href="{{ route('about') }}">О компании</a>
      <a href="{{ route('careers') }}" {!! $navKey === 'careers' ? 'aria-current="page"' : '' !!}>Вакансии</a>
    </nav>
  </div>
</header>

@yield('content')

<footer class="site-footer">
  <div class="wrap">
    <div class="site-footer__cta" data-reveal>
      <h2>{!! $footerCtaTitle ?? 'Обсудим ваш ремонт? <span class="dim">Замер и смета бесплатно</span>' !!}</h2>
      <div>
        <a class="btn btn--ghost-light btn--phone" href="tel:{{ $settings->phone_e164 }}">{{ $settings->phone_display }}</a>
        <a class="btn btn--primary" href="{{ $navKey === null ? '#calc' : route('home').'#calc' }}">Рассчитать стоимость</a>
      </div>
    </div>

    <div class="site-footer__cols">
      <div>
        <div class="site-footer__brand">@include('partials.logo')</div>
        <p class="site-footer__about">{{ $settings->footer_about }}</p>
      </div>
      <div>
        <div class="site-footer__col-title">Разделы</div>
        <ul>
          <li><a href="{{ route('services') }}">Услуги</a></li>
          <li><a href="{{ route('prices') }}">Цены и сметы</a></li>
          <li><a href="{{ route('portfolio') }}">Работы</a></li>
          <li><a href="{{ route('home') }}#calc">Калькулятор</a></li>
          <li><a href="{{ route('home') }}#process">Этапы работ</a></li>
        </ul>
      </div>
      <div>
        <div class="site-footer__col-title">Компания</div>
        <ul>
          <li><a href="{{ route('about') }}">О компании</a></li>
          <li><a href="{{ route('guarantee') }}">Гарантия и документы</a></li>
          <li><a href="{{ route('reviews') }}">Отзывы и кейсы</a></li>
          <li><a href="{{ route('blog.index') }}">Блог</a></li>
          <li><a href="{{ route('careers') }}">Вакансии для мастеров</a></li>
        </ul>
      </div>
      <div>
        <div class="site-footer__col-title">Контакты</div>
        <ul>
          <li><a href="tel:{{ $settings->phone_e164 }}">{{ $settings->phone_display }}</a></li>
          @if ($settings->email)
          <li><a href="mailto:{{ $settings->email }}">{{ $settings->email }}</a></li>
          @endif
          @if ($settings->address_line)
          <li class="is-plain">{{ $settings->address_line }}</li>
          @endif
          @if ($settings->work_hours)
          <li class="is-plain">{{ $settings->work_hours }}</li>
          @endif
        </ul>
      </div>
    </div>

    <div class="site-footer__legal">
      <span>{{ $settings->footer_legal }}</span>
      <a href="{{ route('guarantee') }}">Политика обработки персональных данных</a>
    </div>
  </div>
</footer>

<script>window.CALC_SETTINGS = @json($calcJs ?? null);</script>
<script src="{{ asset('assets/js/app.js') }}?v={{ @filemtime(public_path('assets/js/app.js')) ?: time() }}" defer></script>
@stack('scripts')
</body>
</html>
