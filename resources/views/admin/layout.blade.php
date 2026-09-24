<!DOCTYPE html>
<html lang="ru" data-theme="light">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="robots" content="noindex, nofollow">
<title>@yield('title', 'Админка') · Ремонтология</title>
<meta name="csrf-token" content="{{ csrf_token() }}">
<link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=Baloo+2:wght@700;800&family=Manrope:wght@400;500;600;700&family=JetBrains+Mono:wght@400;500&display=swap" rel="stylesheet">
<link rel="stylesheet" href="{{ asset('assets/css/style.css') }}?v={{ @filemtime(public_path('assets/css/style.css')) ?: time() }}">
<link rel="stylesheet" href="{{ asset('assets/css/admin.css') }}?v={{ @filemtime(public_path('assets/css/admin.css')) ?: time() }}">
</head>
<body>
<?php
    $navItems = [
        'Обзор' => [
            ['label' => 'Дашборд', 'route' => 'admin.dashboard'],
        ],
        'Сайт' => [
            ['label' => 'Настройки и контакты', 'route' => 'admin.settings.edit'],
            ['label' => 'Калькулятор', 'route' => 'admin.calculator.edit'],
            ['label' => 'Пример сметы', 'route' => 'admin.estimate.edit'],
        ],
        'Страницы' => [
            ['label' => 'Главная', 'route' => 'admin.pages.edit', 'param' => 'home'],
            ['label' => 'Услуги', 'route' => 'admin.pages.edit', 'param' => 'services'],
            ['label' => 'Цены', 'route' => 'admin.pages.edit', 'param' => 'prices'],
            ['label' => 'Портфолио', 'route' => 'admin.pages.edit', 'param' => 'portfolio'],
            ['label' => 'Отзывы', 'route' => 'admin.pages.edit', 'param' => 'reviews'],
            ['label' => 'Гарантия', 'route' => 'admin.pages.edit', 'param' => 'guarantee'],
            ['label' => 'О компании', 'route' => 'admin.pages.edit', 'param' => 'about'],
            ['label' => 'Блог', 'route' => 'admin.pages.edit', 'param' => 'blog'],
            ['label' => 'Вакансии', 'route' => 'admin.pages.edit', 'param' => 'careers'],
        ],
        'Контент главной' => [
            ['label' => 'Обещания', 'resource' => 'promises'],
            ['label' => 'Тарифы', 'resource' => 'pricing-plans'],
            ['label' => 'Этапы ремонта', 'resource' => 'process-steps'],
        ],
        'Услуги и цены' => [
            ['label' => 'Услуги', 'resource' => 'services'],
            ['label' => 'Что входит всегда', 'resource' => 'service-perks'],
            ['label' => 'Прайс: разделы', 'resource' => 'price-categories'],
            ['label' => 'Прайс: позиции', 'resource' => 'price-items'],
        ],
        'Портфолио и отзывы' => [
            ['label' => 'Объекты портфолио', 'resource' => 'portfolio-cases'],
            ['label' => 'Отзывы', 'resource' => 'reviews'],
            ['label' => 'Кейсы в цифрах', 'resource' => 'review-cases'],
        ],
        'Гарантия и компания' => [
            ['label' => 'Пункты гарантии', 'resource' => 'guarantee-items'],
            ['label' => 'Документы', 'resource' => 'guarantee-docs'],
            ['label' => 'Команда', 'resource' => 'team-members'],
            ['label' => 'Принципы', 'resource' => 'principles'],
            ['label' => 'Хронология', 'resource' => 'timeline-events'],
        ],
        'Блог и вакансии' => [
            ['label' => 'Статьи блога', 'resource' => 'blog-posts'],
            ['label' => 'Вакансии', 'resource' => 'vacancies'],
            ['label' => 'Вопросы (FAQ)', 'resource' => 'faqs'],
        ],
    ];

    $unreadLeads = \App\Models\Lead::where('is_read', false)->count();
?>
<div class="admin-shell">
  <aside class="admin-sidebar">
    <a class="admin-brand" href="{{ route('admin.dashboard') }}">
      @include('partials.logo')
      <span class="admin-brand__text">
        <span class="admin-brand__meta">Админ-панель</span>
      </span>
    </a>

    <nav class="admin-nav">
      @foreach ($navItems as $group => $items)
        <div class="admin-nav-group">{{ $group }}</div>
        @foreach ($items as $item)
          @php
            $href = isset($item['resource'])
                ? route('admin.resource.index', $item['resource'])
                : (isset($item['param']) ? route($item['route'], $item['param']) : route($item['route']));
            $active = isset($item['resource'])
                ? (request()->route('resource') === $item['resource'])
                : (isset($item['param']) ? (request()->route('page')?->slug === $item['param']) : request()->routeIs($item['route']));
          @endphp
          <a href="{{ $href }}" class="{{ $active ? 'is-active' : '' }}">{{ $item['label'] }}</a>
        @endforeach
      @endforeach

      <div class="admin-nav-group">Обращения</div>
      <a href="{{ route('admin.leads.index') }}" class="{{ request()->routeIs('admin.leads.*') ? 'is-active' : '' }}">
        Заявки
        @if ($unreadLeads > 0)
        <span class="count">{{ $unreadLeads }}</span>
        @endif
      </a>
    </nav>

    <div class="admin-sidebar__foot">
      <a class="admin-sidebar__view" href="{{ route('home') }}" target="_blank" rel="noopener">Открыть сайт ↗</a>
      <form method="POST" action="{{ route('admin.logout') }}">
        @csrf
        <button type="submit">Выйти ({{ auth()->user()->name }})</button>
      </form>
    </div>
  </aside>

  <div class="admin-main">
    <header class="admin-topbar">
      <div>
        <h1>@yield('title', 'Админка')</h1>
        @hasSection('hint')
        <div class="admin-topbar__hint">@yield('hint')</div>
        @endif
      </div>
      @hasSection('topbar-actions')
      <div>@yield('topbar-actions')</div>
      @endif
    </header>

    <div class="admin-content">
      @if (session('status'))
      <div class="admin-flash">{{ session('status') }}</div>
      @endif

      @if ($errors->any())
      <div class="admin-errors">
        Проверьте форму — не всё сохранилось:
        <ul>
          @foreach ($errors->all() as $error)
          <li>{{ $error }}</li>
          @endforeach
        </ul>
      </div>
      @endif

      @yield('content')
    </div>
  </div>
</div>

<script src="{{ asset('assets/js/admin.js') }}?v={{ @filemtime(public_path('assets/js/admin.js')) ?: time() }}" defer></script>
@stack('scripts')
</body>
</html>
