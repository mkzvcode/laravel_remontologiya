@extends('layouts.app')

@section('title', $page->meta_title)
@section('description', $page->meta_description)
@php($ogImage = $page->og_image)
@php($footerCtaTitle = $page->section('footer_cta')['title_html'] ?: null)

@section('snake')
<svg class="snake" aria-hidden="true" focusable="false">
  <defs>
    <linearGradient id="snakeFill" x1="0" y1="0" x2="0" y2="1">
      <stop offset="0"   stop-color="#b6f52e" stop-opacity=".52"></stop>
      <stop offset=".55" stop-color="#b6f52e" stop-opacity=".32"></stop>
      <stop offset="1"   stop-color="#b6f52e" stop-opacity=".07"></stop>
    </linearGradient>
    <clipPath id="snakeReveal" clipPathUnits="userSpaceOnUse">
      <rect data-snake-clip x="0" y="0" width="0" height="0"></rect>
    </clipPath>
  </defs>
  <g clip-path="url(#snakeReveal)">
    <path data-snake-ribbon fill="url(#snakeFill)"></path>
  </g>
  <circle class="snake__head" data-snake-head r="6" fill="#b6f52e" opacity="0"></circle>
</svg>
@endsection

@section('content')
<main class="page" id="main">

  {{-- ================= Первый экран ================= --}}
  <section class="hero" id="top">
    <div class="hero__inner">
      <div class="hero__copy">
        @if ($page->hero_eyebrow)
        <div class="pill" data-reveal>
          <span class="pip" aria-hidden="true"></span>
          {{ $page->hero_eyebrow }}
        </div>
        @endif

        <h1 class="h1" data-reveal>{!! $page->hero_title_html !!}</h1>

        <p class="lead hero__lead" data-reveal>{{ $page->hero_lead }}</p>

        <div class="hero__actions" data-reveal>
          @if ($page->hero_cta1_label)
          <a class="btn btn--primary" href="{{ $page->hero_cta1_href }}">{{ $page->hero_cta1_label }}</a>
          @endif
          @if ($page->hero_cta2_label)
          <a class="btn btn--ghost-light" href="{{ $page->hero_cta2_href }}">{{ $page->hero_cta2_label }}</a>
          @endif
        </div>

        @if (!empty($page->hero_stats))
        <ul class="hero__stats" data-reveal>
          @foreach ($page->hero_stats as $stat)
          <li>
            <div class="hero__stat-num">{{ $stat['num'] }}</div>
            <div class="hero__stat-label">{!! nl2br(e($stat['label'])) !!}</div>
          </li>
          @endforeach
        </ul>
        @endif
      </div>

      <div class="hero__media">
        @if ($page->hero_image)
        <div class="hero__shot" data-reveal>
          <img src="{{ $page->hero_image }}" alt="{{ $page->hero_image_alt }}" fetchpriority="high" data-hero-img>
          <div class="hero__caption">
            <div>
              <div class="hero__caption-meta">{{ $page->hero_caption_meta }}</div>
              <div class="hero__caption-title">{{ $page->hero_caption_title }}</div>
            </div>
            <div style="text-align:right;flex-shrink:0">
              <div class="hero__caption-term">{{ $page->hero_caption_term }}</div>
              <div style="font-size:12px;color:#bdb3a7">{{ $page->hero_caption_note }}</div>
            </div>
          </div>
        </div>

        @if ($page->hero_badge_sum)
        <div class="hero__badge" data-reveal>
          <div class="label">{{ $page->hero_badge_label }}</div>
          <div class="hero__badge-sum">{{ $page->hero_badge_sum }}</div>
          <div class="hero__badge-note">{{ $page->hero_badge_note }}</div>
        </div>
        @endif
        @endif
      </div>
    </div>

    @if (!empty($page->marquee_items))
    <ul class="tags" aria-label="Специализации">
      @foreach ($page->marquee_items as $item)
      <li>{{ $item }}</li>
      @endforeach
    </ul>
    @endif
  </section>

  {{-- ================= 01 — Обещания ================= --}}
  @php($sPromises = $page->section('promises'))
  <section class="section wrap" id="promises">
    <div class="grid grid--2" style="gap:56px;align-items:start">
      <div data-reveal>
        <div class="eyebrow">{{ $sPromises['eyebrow'] }}</div>
        <h2 class="h2" style="margin-top:18px">{!! $sPromises['title_html'] !!}</h2>
        <p class="body-text" style="margin-top:20px">{{ $sPromises['lead'] }}</p>
        <a class="link-arrow" style="margin-top:24px" href="#guarantees">Разобрать по пунктам <span class="mono">→</span></a>
      </div>

      <div class="grid grid--2">
        @foreach ($promises as $promise)
        <article class="card @if($promise->is_dark) card--ink @endif" data-reveal>
          <div class="card__num">{{ $promise->number }}</div>
          <h3 class="h4 card__title">{{ $promise->title }}</h3>
          <p class="card__text">{{ $promise->text }}</p>
        </article>
        @endforeach
      </div>
    </div>
  </section>

  {{-- ================= Услуги ================= --}}
  @php($sServices = $page->section('services'))
  <section class="section--dark" id="services">
    <div class="wrap on-dark">
      <div class="section-head" data-reveal>
        <div class="section-head__text">
          <div class="eyebrow">{{ $sServices['eyebrow'] }}</div>
          <h2 class="h2" style="margin-top:18px">{!! $sServices['title_html'] !!}</h2>
        </div>
        <a class="btn btn--ghost-light btn--sm" href="{{ route('services') }}">Все услуги <span class="mono">→</span></a>
      </div>

      <div class="grid grid--cards" style="margin-top:38px">
        @foreach ($featuredServices as $service)
        <a class="svc-card" href="{{ route('services') }}">
          @if ($service->image)
          <figure><img src="{{ $service->image }}" alt="{{ $service->image_alt ?: $service->title }}" loading="lazy"></figure>
          @endif
          <div class="svc-card__body">
            <div class="svc-card__price">{{ $service->price_label }}</div>
            <div class="svc-card__title">{{ $service->title }}</div>
            <p class="svc-card__text">{{ \Illuminate\Support\Str::limit($service->description, 110) }}</p>
          </div>
        </a>
        @endforeach

        <a class="svc-card svc-card--cta" href="{{ route('prices') }}">
          <div>
            <div class="label" style="color:#e2d8cb">Прайс на работы</div>
            <div class="svc-card__title">46 позиций по восьми разделам</div>
            <p>Цены за работу без наценки на материалы. И пример реальной сметы на двушку 52 м².</p>
          </div>
          <span class="link-arrow" style="color:var(--on-deep)">Открыть прайс <span class="mono">→</span></span>
        </a>
      </div>
    </div>
  </section>

  {{-- ================= 02 — Калькулятор ================= --}}
  @php($sCalc = $page->section('calc'))
  <section class="section wrap" id="calc">
    <div style="text-align:center;max-width:720px;margin:0 auto" data-reveal>
      <div class="eyebrow">{{ $sCalc['eyebrow'] }}</div>
      <h2 class="h2" style="margin-top:18px">{!! $sCalc['title_html'] !!}</h2>
      <p class="body-text" style="margin-top:18px">{{ $sCalc['lead'] }}</p>
    </div>

    <div class="calc" data-calc data-reveal>
      <div class="calc__panel">
        <div class="calc__area-head">
          <div>
            <div class="label">Площадь квартиры</div>
            <div class="calc__area-value"><span data-out="area">{{ $calc->area_default }}</span> м²</div>
          </div>
          <div class="calc__area-range">{{ $calc->area_min }} — {{ $calc->area_max }} м²</div>
        </div>
        <input class="calc__slider" type="range" min="{{ $calc->area_min }}" max="{{ $calc->area_max }}" step="1" value="{{ $calc->area_default }}"
               data-calc-area aria-label="Площадь квартиры в квадратных метрах">

        <div class="label calc__group-label" id="calc-type-label">Тип ремонта</div>
        <div class="calc__types" role="group" aria-labelledby="calc-type-label">
          <button class="type-btn" type="button" data-calc-type="cos" aria-pressed="{{ $calc->default_type === 'cos' ? 'true' : 'false' }}">
            <b>{{ $calc->type_cos_label }}</b><span>от {{ number_format($calc->base_cos, 0, '', ' ') }} ₽/м²</span>
          </button>
          <button class="type-btn" type="button" data-calc-type="kap" aria-pressed="{{ $calc->default_type === 'kap' ? 'true' : 'false' }}">
            <b>{{ $calc->type_kap_label }}</b><span>от {{ number_format($calc->base_kap, 0, '', ' ') }} ₽/м²</span>
          </button>
          <button class="type-btn" type="button" data-calc-type="diz" aria-pressed="{{ $calc->default_type === 'diz' ? 'true' : 'false' }}">
            <b>{{ $calc->type_diz_label }}</b><span>от {{ number_format($calc->base_diz, 0, '', ' ') }} ₽/м²</span>
          </button>
        </div>

        <div class="label calc__group-label" id="calc-opt-label">Что ещё нужно</div>
        <div class="calc__options" role="group" aria-labelledby="calc-opt-label">
          @foreach (['demo','elec','plumb','plan','design','furn'] as $optKey)
          <button class="opt-btn" type="button" data-calc-opt="{{ $optKey }}" aria-pressed="{{ $calc->{"opt_{$optKey}_default"} ? 'true' : 'false' }}">
            <span class="opt-btn__dot" aria-hidden="true"></span>
            <span class="opt-btn__name">{{ $calc->{"opt_{$optKey}_label"} }}</span>
            <span class="opt-btn__price">+{{ number_format($calc->{"opt_{$optKey}_price"}, 0, '', ' ') }} ₽</span>
          </button>
          @endforeach
        </div>
      </div>

      <div class="calc__result">
        <div class="label">Предварительная стоимость</div>
        <div class="calc__total" data-out="total" aria-live="polite">—</div>
        <ul class="calc__rows">
          <li><span>Цена за м²</span><span data-out="perM2">—</span></li>
          <li><span>Срок работ</span><span data-out="days">—</span></li>
          <li><span>Опций выбрано</span><span data-out="opts">—</span></li>
          <li><span>Оплата</span><span>по этапам</span></li>
        </ul>
        <p class="calc__note">Расчёт учитывает работы и выбранные опции. Чистовые материалы — плитка, обои, полы, сантехника — считаются отдельно по вашему выбору.</p>

        <form class="form" data-form="calc-done" data-lead-source="calc">
          @csrf
          <input type="tel" name="phone" required placeholder="+7 (___) ___-__-__" aria-label="Телефон">
          <button type="submit">Получить точную смету</button>
          <span class="form__consent">Нажимая кнопку, вы соглашаетесь с политикой обработки персональных данных</span>
        </form>
        <div class="form-done" id="calc-done" hidden>
          <div class="form-done__title">Заявка принята</div>
          <p>Прораб перезвонит в течение 15 минут и согласует время бесплатного замера.</p>
        </div>
      </div>
    </div>
  </section>

  {{-- ================= 03 — Тарифы ================= --}}
  @php($sPricing = $page->section('pricing'))
  <section class="section wrap" id="pricing">
    <div class="section-head" data-reveal>
      <div class="section-head__text">
        <div class="eyebrow">{{ $sPricing['eyebrow'] }}</div>
        <h2 class="h2" style="margin-top:18px">{!! $sPricing['title_html'] !!}</h2>
      </div>
      <p class="section-head__aside">{{ $sPricing['lead'] }}</p>
    </div>

    <div class="grid grid--4" style="margin-top:40px;align-items:start">
      @foreach ($plans as $plan)
      <article class="plan @if($plan->bg_variant==='ink') plan--featured @elseif($plan->bg_variant==='sand') plan--sand @endif" data-reveal>
        @if ($plan->badge_text)
        <span class="plan__badge">{{ $plan->badge_text }}</span>
        @endif
        <h3 class="plan__name">{{ $plan->name }}</h3>
        <p class="plan__desc">{{ $plan->description }}</p>
        <div class="plan__price"><span>от</span><b>{{ $plan->price_from }}</b><span>{{ $plan->price_unit }}</span></div>
        <ul class="plan__list">
          @foreach ($plan->items as $item)
          <li>{{ $item }}</li>
          @endforeach
        </ul>
        <a class="btn @if($plan->is_featured) btn--primary @else btn--ghost @endif btn--block" href="#calc">{{ $plan->cta_label }}</a>
      </article>
      @endforeach
    </div>
  </section>

  {{-- ================= 04 — Работы ================= --}}
  @php($sWorks = $page->section('works'))
  <section class="section wrap" id="works">
    <div class="section-head" data-reveal>
      <div class="section-head__text">
        <div class="eyebrow">{{ $sWorks['eyebrow'] }}</div>
        <h2 class="h2" style="margin-top:18px">{!! $sWorks['title_html'] !!}</h2>
      </div>
      <a class="btn btn--ghost btn--sm" href="{{ route('portfolio') }}">Все объекты <span class="mono">→</span></a>
    </div>

    <div class="grid grid--3" style="margin-top:38px;gap:18px">
      @foreach ($homeCases as $case)
      <figure class="ba" data-reveal>
        <div class="ba__frame" data-ba tabindex="0" role="slider"
             aria-label="{{ $case->title }}: сравнение до и после"
             aria-valuemin="0" aria-valuemax="100" aria-valuenow="50">
          <img src="{{ $case->image }}" alt="{{ $case->image_alt }} — после ремонта" loading="lazy">
          <div class="ba__clip"><img src="{{ $case->image_before ?: $case->image }}" alt="{{ $case->image_alt }} — до ремонта" loading="lazy"></div>
          <div class="ba__handle"><span aria-hidden="true">↔</span></div>
          <span class="ba__tag ba__tag--before">До</span>
          <span class="ba__tag ba__tag--after">После</span>
        </div>
        <figcaption>
          <h3 class="ba__title">{{ $case->title }}</h3>
          <div class="ba__meta"><span>{{ $case->area }} · {{ ['cos'=>'косметический','kap'=>'капитальный','diz'=>'дизайнерский'][$case->kind] ?? '' }} · {{ $case->days }}</span><b>{{ $case->budget }}</b></div>
        </figcaption>
      </figure>
      @endforeach
    </div>
  </section>

  {{-- ================= 05 — Этапы ================= --}}
  @php($sProcess = $page->section('process'))
  <section class="section--dark" id="process">
    <div class="wrap on-dark">
      <div style="max-width:720px" data-reveal>
        <div class="eyebrow">{{ $sProcess['eyebrow'] }}</div>
        <h2 class="h2" style="margin-top:18px">{!! $sProcess['title_html'] !!}</h2>
        <p class="body-text" style="margin-top:18px">{{ $sProcess['lead'] }}</p>
      </div>

      <ol class="steps">
        @foreach ($steps as $step)
        <li class="step" data-reveal>
          <div class="step__num">{{ $step->number }}</div>
          <div>
            <div class="step__meta">{{ $step->meta }}</div>
            <h3 class="step__title">{{ $step->title }}</h3>
            <p class="step__text">{{ $step->text_body }}</p>
          </div>
          @if ($step->image)
          <img src="{{ $step->image }}" alt="{{ $step->image_alt }}" loading="lazy">
          @endif
        </li>
        @endforeach
      </ol>

      <div class="callout" data-reveal>
        <div class="callout__title">Готовы начать с первого этапа?</div>
        <a class="btn btn--primary btn--sm" href="#contacts">Записаться на бесплатный замер</a>
      </div>
    </div>
  </section>

  {{-- ================= 06 — Гарантии ================= --}}
  @php($sGuarantees = $page->section('guarantees'))
  <section class="section wrap" id="guarantees">
    <div style="max-width:760px" data-reveal>
      <div class="eyebrow">{{ $sGuarantees['eyebrow'] }}</div>
      <h2 class="h2" style="margin-top:18px">{!! $sGuarantees['title_html'] !!}</h2>
    </div>

    <div class="grid grid--2" style="margin-top:40px">
      @foreach ($guaranteeItems as $item)
      <article class="card card--flat" data-reveal>
        <h3 class="fear__title">{{ $item->text }}</h3>
        <div class="chip">Пункт гарантии</div>
      </article>
      @endforeach
    </div>
  </section>

  {{-- ================= 07 — Команда ================= --}}
  @php($sTeam = $page->section('team'))
  <section class="section wrap" id="team">
    <div class="split">
      <figure class="split__media" data-reveal>
        <img src="/img/master-1000.webp" alt="Прораб и мастер обсуждают объект" loading="lazy">
      </figure>
      <div data-reveal>
        <div class="eyebrow">{{ $sTeam['eyebrow'] }}</div>
        <h2 class="h3" style="margin-top:18px">{!! $sTeam['title_html'] !!}</h2>
        <p class="body-text" style="margin-top:18px">{{ $sTeam['lead'] }}</p>
        <ul class="people">
          @foreach ($team as $member)
          <li>
            <span class="people__avatar" aria-hidden="true">{{ $member->avatar_letter }}</span>
            <span class="people__body"><b>{{ $member->name }}</b> <span class="people__role">— {{ $member->role }}</span><br><span class="people__note">{{ $member->note }}</span></span>
          </li>
          @endforeach
        </ul>
      </div>
    </div>
  </section>

  {{-- ================= 08 — Отзывы ================= --}}
  @php($sReviews = $page->section('reviews'))
  <section class="section wrap" id="reviews">
    <div style="max-width:720px" data-reveal>
      <div class="eyebrow">{{ $sReviews['eyebrow'] }}</div>
      <h2 class="h2" style="margin-top:18px">{!! $sReviews['title_html'] !!}</h2>
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

  {{-- ================= 09 — Вопросы ================= --}}
  @php($sFaq = $page->section('faq'))
  <section class="section wrap" id="faq">
    <div class="faq">
      <div class="faq__aside" data-reveal>
        <div class="eyebrow">{{ $sFaq['eyebrow'] }}</div>
        <h2 class="h3" style="margin-top:18px">{!! $sFaq['title_html'] !!}</h2>
        <p class="body-text" style="margin-top:18px">{{ $sFaq['lead'] }}</p>
        <a class="btn btn--ink btn--sm btn--phone" style="margin-top:22px" href="tel:{{ \App\Models\Setting::current()->phone_e164 }}">{{ \App\Models\Setting::current()->phone_display }}</a>
      </div>

      <ul class="faq__list" data-faq data-reveal>
        @foreach ($faqs as $faq)
        <li class="faq__item">
          <button class="faq__q" type="button" aria-expanded="false">
            <span>{{ $faq->question }}</span>
            <span class="faq__icon" aria-hidden="true">+</span>
          </button>
          <div class="faq__a"><p>{{ $faq->answer }}</p></div>
        </li>
        @endforeach
      </ul>
    </div>
  </section>

  {{-- ================= 10 — Контакты ================= --}}
  @php($sContacts = $page->section('contacts'))
  <section class="section wrap" id="contacts">
    <div class="contacts" data-reveal>
      <div>
        <div class="eyebrow">{{ $sContacts['eyebrow'] }}</div>
        <h2 class="h3" style="margin-top:18px">{!! $sContacts['title_html'] !!}</h2>
        <p class="body-text" style="margin-top:18px;max-width:520px">{{ $sContacts['lead'] }}</p>
        @php($s = \App\Models\Setting::current())
        <ul class="contacts__list">
          <li><span>01</span> {{ $s->address_line }}</li>
          <li><span>02</span> {{ $s->work_hours }}</li>
          <li><span>03</span> <a href="tel:{{ $s->phone_e164 }}"><b>{{ $s->phone_display }}</b></a></li>
          @if ($s->email)
          <li><span>04</span> <a href="mailto:{{ $s->email }}">{{ $s->email }}</a></li>
          @endif
        </ul>
        <div class="contacts__messengers">
          @if ($s->whatsapp_url)
          <a class="btn btn--ghost btn--xs" href="{{ $s->whatsapp_url }}" rel="noopener">WhatsApp</a>
          @endif
          @if ($s->telegram_url)
          <a class="btn btn--ghost btn--xs" href="{{ $s->telegram_url }}" rel="noopener">Telegram</a>
          @endif
        </div>
      </div>

      <div class="contacts__form">
        <h3>Записаться на замер</h3>
        <p>Перезвоним в течение 15 минут</p>
        <form class="form" style="margin-top:22px" data-form="visit-done" data-lead-source="contacts">
          @csrf
          <input type="text" name="name" required placeholder="Ваше имя" aria-label="Ваше имя">
          <input type="tel" name="phone" required placeholder="+7 (___) ___-__-__" aria-label="Телефон">
          <input type="text" name="area" placeholder="Площадь, м² (необязательно)" aria-label="Площадь в квадратных метрах">
          <button type="submit">Записаться на бесплатный замер</button>
          <span class="form__consent">Нажимая кнопку, вы соглашаетесь с политикой обработки персональных данных</span>
        </form>
        <div class="form-done" id="visit-done" style="margin-top:22px" hidden>
          <div class="form-done__title">Спасибо, записали</div>
          <p>Прораб перезвонит в ближайшие 15 минут и согласует удобное время.</p>
        </div>
      </div>
    </div>
  </section>

</main>
@endsection

@push('jsonld')
<script type="application/ld+json">
{!! json_encode([
    '@context' => 'https://schema.org',
    '@type' => 'FAQPage',
    'mainEntity' => $faqs->map(fn ($f) => [
        '@type' => 'Question',
        'name' => $f->question,
        'acceptedAnswer' => ['@type' => 'Answer', 'text' => $f->answer],
    ])->values(),
], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) !!}
</script>
@endpush
