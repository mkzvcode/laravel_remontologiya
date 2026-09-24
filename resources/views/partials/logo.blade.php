{{--
  Логотип «ремонтология.» — воспроизведён в SVG по референсу (неоновый леттеринг).
  Цвет наследуется через currentColor — управляется через CSS-класс .brand__logo
  ( --accent на тёмных поверхностях / --accent-2 на светлых, как у остальных акцентов сайта).

  Параметры:
    $class — дополнительный CSS-класс (необязательно)
--}}
<svg class="brand__logo {{ $class ?? '' }}" viewBox="0 0 314 60" xmlns="http://www.w3.org/2000/svg" role="img" aria-label="{{ isset($settings) ? $settings->brand_name : 'Ремонтология' }}">
  <path d="M16.5 14.8c-2.7 0-4.6-1.9-4.3-4.6.3-2.9 2.8-5.4 5.7-5.7 2.7-.3 4.6 1.6 4.3 4.3-.1.6-.2 1.1-.4 1.6-.6-.5-1.3-.8-2.1-.7-1.8.2-3.4 1.8-3.6 3.6 0 .5 0 1 .2 1.4-.1 0-.2 0-.4.1z" fill="currentColor"/>
  <text x="0" y="47" font-family="'Baloo 2','Manrope',sans-serif" font-weight="800" font-size="40" letter-spacing="-.5" fill="currentColor">ремонтология<tspan dx="1">.</tspan></text>
</svg>
