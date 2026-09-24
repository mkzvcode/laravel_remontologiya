@extends('layouts.app')

@section('title', $page->meta_title)
@section('description', $page->meta_description)
@php($ogImage = $page->og_image)

@section('content')
<main class="page" id="main">

  <section class="page-hero">
    <div class="wrap">
      <div class="page-hero__inner">
        @include('partials.crumbs', ['label' => 'Цены и сметы'])
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

  @php($sCatalog = $page->section('catalog'))
  <section class="section wrap">
    <div style="max-width:760px" data-reveal>
      <div class="eyebrow">{{ $sCatalog['eyebrow'] }}</div>
      <h2 class="h2" style="margin-top:18px">{!! $sCatalog['title_html'] !!}</h2>
      <p class="body-text" style="margin-top:18px">{{ $sCatalog['lead'] }}</p>
    </div>

    <div class="grid grid--2" style="margin-top:38px;align-items:start">
      @foreach ($categories as $category)
      <section class="price-table" data-reveal>
        <div class="price-table__head"><h3><span class="mono accent">{{ $category->number }}</span> {{ $category->title }}</h3><span>{{ $category->subtitle }}</span></div>
        <div class="price-table__scroll"><table>
          <thead><tr><th scope="col">Работа</th><th scope="col">Ед.</th><th scope="col">Цена</th></tr></thead>
          <tbody>
            @foreach ($category->items as $item)
            <tr><td>{{ $item->name }}</td><td>{{ $item->unit }}</td><td>{{ $item->price_text }}</td></tr>
            @endforeach
          </tbody>
        </table></div>
      </section>
      @endforeach
    </div>
  </section>

  {{-- Пример сметы --}}
  <section class="section wrap" id="example">
    <div class="split" style="align-items:start" data-reveal>
      <div>
        <div class="eyebrow">Пример сметы</div>
        <h2 class="h3" style="margin-top:18px">{{ $example->title }}</h2>
        <p class="body-text" style="margin-top:18px">{{ $example->subtitle }}</p>
        @if (!empty($example->checklist))
        <ul class="facts" style="margin-top:26px">
          @foreach ($example->checklist as $line)
          <li><span>✓</span>{{ $line }}</li>
          @endforeach
        </ul>
        @endif
      </div>

      <div class="estimate">
        <div class="estimate__head">
          <span>{{ $example->code_label }}</span>
          <span>{{ $example->area_label }}</span>
        </div>
        <ul class="estimate__rows">
          @foreach ($example->rows as $row)
          <li><span>{{ $row['name'] }}</span><b>{{ $row['price'] }}</b></li>
          @endforeach
        </ul>
        <div class="estimate__total"><span>{{ $example->total_label }}</span><b>{{ $example->total_value }}</b></div>
        @if ($example->materials_value)
        <div class="estimate__aux"><span>{{ $example->materials_label }}</span><b>{{ $example->materials_value }}</b></div>
        @endif
        @if ($example->days_value)
        <div class="estimate__aux"><span>{{ $example->days_label }}</span><b>{{ $example->days_value }}</b></div>
        @endif
        <a class="btn btn--primary btn--block" style="margin-top:24px" href="{{ route('home') }}#contacts">{{ $example->cta_label }}</a>
      </div>
    </div>
  </section>

  <section class="section wrap">
    <div class="grid grid--3" style="align-items:start">
      <article class="card card--flat" data-reveal>
        <h2 class="h4">Что входит в цену работ</h2>
        <ul class="facts" style="margin-top:18px;gap:0">
          <li style="background:none;border:0;padding:8px 0"><span>+</span>Расходники: крепёж, смеси на подготовку, малярная лента, плёнка</li>
          <li style="background:none;border:0;padding:8px 0"><span>+</span>Инструмент и оборудование бригады, включая аренду</li>
          <li style="background:none;border:0;padding:8px 0"><span>+</span>Защита площадки, подъезда и лифта</li>
          <li style="background:none;border:0;padding:8px 0"><span>+</span>Ежедневный фотоотчёт и ведение чата по объекту</li>
          <li style="background:none;border:0;padding:8px 0"><span>+</span>Строительная и финальная уборка</li>
          <li style="background:none;border:0;padding:8px 0"><span>+</span>Гарантия 24 месяца письменно</li>
        </ul>
      </article>

      <article class="card card--flat" data-reveal>
        <h2 class="h4">Что считается отдельно</h2>
        <ul class="facts" style="margin-top:18px;gap:0">
          <li style="background:none;border:0;padding:8px 0"><span>—</span>Чистовые материалы: плитка, обои, краска, полы, двери</li>
          <li style="background:none;border:0;padding:8px 0"><span>—</span>Сантехника, смесители, инсталляции и радиаторы</li>
          <li style="background:none;border:0;padding:8px 0"><span>—</span>Мебель, техника и светильники</li>
          <li style="background:none;border:0;padding:8px 0"><span>—</span>Дизайн-проект, если он нужен</li>
          <li style="background:none;border:0;padding:8px 0"><span>—</span>Согласование перепланировки в администрации</li>
        </ul>
        <p class="small" style="margin-top:16px">Мы помогаем посчитать количество чистовых материалов и даём доступ к нашим скидкам у поставщиков — покупаете вы на себя, наценки нет.</p>
      </article>

      <article class="card card--flat card--ink" data-reveal>
        <h2 class="h4">Как платите</h2>
        <ul class="facts" style="margin-top:18px;gap:0">
          <li style="background:none;border:0;padding:8px 0;color:var(--d-text-2)"><span class="mono accent" style="min-width:78px">30%</span>аванс при подписании договора — на закупку черновых материалов</li>
          <li style="background:none;border:0;padding:8px 0;color:var(--d-text-2)"><span class="mono accent" style="min-width:78px">по этапам</span>оплата по факту закрытия каждого из пяти этапов</li>
          <li style="background:none;border:0;padding:8px 0;color:var(--d-text-2)"><span class="mono accent" style="min-width:78px">0 ₽</span>если этап не принят — не платите и работы не идут дальше</li>
        </ul>
        <p class="small" style="margin-top:16px">Наличными, переводом или по счёту на юрлицо. Все платежи фиксируются в акте по этапу.</p>
      </article>
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
