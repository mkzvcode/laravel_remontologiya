{{-- Хлебные крошки: видимая навигация + структурированные данные для поиска. --}}
<nav class="crumbs" aria-label="Хлебные крошки">
  <a href="{{ route('home') }}">Главная</a> <span aria-hidden="true">/</span> <span>{{ $label }}</span>
</nav>

@push('jsonld')
<script type="application/ld+json">
{!! json_encode([
    '@context' => 'https://schema.org',
    '@type' => 'BreadcrumbList',
    'itemListElement' => [
        ['@type' => 'ListItem', 'position' => 1, 'name' => 'Главная', 'item' => route('home')],
        ['@type' => 'ListItem', 'position' => 2, 'name' => $label, 'item' => url()->current()],
    ],
], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) !!}
</script>
@endpush
