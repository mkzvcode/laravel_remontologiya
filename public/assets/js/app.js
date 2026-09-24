/* ==========================================================================
   Ремонтология — клиентские скрипты
   Ванильный JS, без зависимостей. Каждый модуль молча выходит,
   если своей разметки на странице нет.
   ========================================================================== */

(function () {
  'use strict';

  document.documentElement.classList.remove('no-js');

  var reduceMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
  var $ = function (sel, root) { return (root || document).querySelector(sel); };
  var $$ = function (sel, root) { return Array.prototype.slice.call((root || document).querySelectorAll(sel)); };

  /* Русские склонения: 1 кейс, 2 кейса, 5 кейсов */
  function plural(n, one, few, many) {
    var a = Math.abs(n) % 100;
    var b = a % 10;
    if (a > 10 && a < 20) return many;
    if (b > 1 && b < 5) return few;
    if (b === 1) return one;
    return many;
  }

  /* --- Шапка: бургер --------------------------------------------------- */

  function initHeader() {
    var header = $('.site-header');
    var burger = $('.burger');
    if (!header || !burger) return;

    burger.addEventListener('click', function () {
      var open = header.classList.toggle('is-open');
      burger.setAttribute('aria-expanded', String(open));
    });

    // Закрываем меню, когда окно снова стало широким
    window.addEventListener('resize', function () {
      if (window.innerWidth >= 1180 && header.classList.contains('is-open')) {
        header.classList.remove('is-open');
        burger.setAttribute('aria-expanded', 'false');
      }
    });

    // И по клику на любой пункт
    $$('.mobile-nav a').forEach(function (a) {
      a.addEventListener('click', function () {
        header.classList.remove('is-open');
        burger.setAttribute('aria-expanded', 'false');
      });
    });
  }

  /* --- Тема: светлая / тёмная -------------------------------------------
     По умолчанию сайт следует системной настройке (никакого атрибута —
     работает чистый CSS @media (prefers-color-scheme)). Ручной выбор
     сохраняется в localStorage и ставит data-theme на <html>; та же логика
     уже отработала синхронно в inline-скрипте в <head> (см. layout), чтобы
     тема не «моргала» до применения CSS — здесь только сама кнопка. */

  function initThemeToggle() {
    var btn = $('.theme-toggle');
    if (!btn) return;

    var root = document.documentElement;
    var media = window.matchMedia('(prefers-color-scheme: dark)');

    function systemIsDark() { return media.matches; }
    function currentIsDark() {
      var explicit = root.getAttribute('data-theme');
      if (explicit === 'dark') return true;
      if (explicit === 'light') return false;
      return systemIsDark();
    }

    function apply(theme) {
      if (theme) {
        root.setAttribute('data-theme', theme);
        try { localStorage.setItem('theme', theme); } catch (e) {}
      } else {
        root.removeAttribute('data-theme');
        try { localStorage.removeItem('theme'); } catch (e) {}
      }
      btn.setAttribute('aria-pressed', String(currentIsDark()));
    }

    btn.setAttribute('aria-pressed', String(currentIsDark()));

    btn.addEventListener('click', function () {
      // Один клик — переключить относительно того, что видно СЕЙЧАС
      // (а не относительно системной темы), так интуитивнее.
      apply(currentIsDark() ? 'light' : 'dark');
    });
  }

  /* --- Полоса прогресса чтения ----------------------------------------- */

  function initProgress() {
    var bar = $('.progress-bar');
    if (!bar) return;

    var update = function () {
      var doc = document.documentElement;
      var max = doc.scrollHeight - doc.clientHeight;
      bar.style.width = (max > 0 ? (doc.scrollTop / max) * 100 : 0) + '%';
    };
    window.addEventListener('scroll', update, { passive: true });
    window.addEventListener('resize', update);
    update();
  }

  /* --- Появление блоков при скролле ------------------------------------ */

  function initReveal() {
    var nodes = $$('[data-reveal]');
    if (!nodes.length) return;

    if (reduceMotion || !('IntersectionObserver' in window)) {
      nodes.forEach(function (el) { el.classList.add('is-visible'); });
      return;
    }

    var io = new IntersectionObserver(function (entries) {
      entries.forEach(function (e) {
        if (!e.isIntersecting) return;
        e.target.classList.add('is-visible');
        io.unobserve(e.target);
      });
    }, { threshold: 0.12, rootMargin: '0px 0px -8% 0px' });

    nodes.forEach(function (el, i) {
      el.style.transitionDelay = (i % 4) * 70 + 'ms';
      io.observe(el);
    });

    // Страховка: если что-то пошло не так, показываем всё через 1.6 с
    var forceAll = function () { nodes.forEach(function (el) { el.classList.add('is-visible'); }); };
    setTimeout(forceAll, 1600);
    document.addEventListener('visibilitychange', forceAll);
    window.addEventListener('beforeprint', forceAll);
  }

  /* --- Счётчики --------------------------------------------------------- */

  function initCounters() {
    var nodes = $$('[data-count]');
    if (!nodes.length) return;

    if (reduceMotion || !('IntersectionObserver' in window)) {
      nodes.forEach(function (el) { el.textContent = el.dataset.count; });
      return;
    }

    var io = new IntersectionObserver(function (entries) {
      entries.forEach(function (e) {
        if (!e.isIntersecting) return;
        io.unobserve(e.target);
        var el = e.target;
        var target = parseInt(el.dataset.count, 10) || 0;
        var t0 = performance.now();
        var dur = 1500;
        var tick = function (t) {
          var p = Math.min(1, (t - t0) / dur);
          el.textContent = String(Math.round(target * (1 - Math.pow(1 - p, 3))));
          if (p < 1) requestAnimationFrame(tick);
        };
        requestAnimationFrame(tick);
      });
    }, { threshold: 0.5 });

    nodes.forEach(function (el) { io.observe(el); });
  }

  /* --- Параллакс фото на первом экране --------------------------------- */

  function initHeroParallax() {
    var img = $('[data-hero-img]');
    if (!img || reduceMotion) return;

    var ticking = false;
    var apply = function () {
      var y = Math.min(window.scrollY, 700);
      img.style.transform = 'translate3d(0,' + (y * 0.07) + 'px,0) scale(1.04)';
      ticking = false;
    };
    window.addEventListener('scroll', function () {
      if (!ticking) { ticking = true; requestAnimationFrame(apply); }
    }, { passive: true });
    apply();
  }

  /* --- Калькулятор ------------------------------------------------------ */

  function initCalculator() {
    var root = $('[data-calc]');
    if (!root) return;

    // Настройки приходят из БД (админка → «Калькулятор») через window.CALC_SETTINGS,
    // отрисованное сервером в layout. На автономной статике этой переменной нет —
    // тогда используются исходные значения демо-сайта.
    var settings = window.CALC_SETTINGS || {
      areaMin: 20, areaMax: 150, areaDefault: 50, defaultType: 'kap',
      types: {
        cos: { base: 4500, factor: 0.5 },
        kap: { base: 8900, factor: 1.12 },
        diz: { base: 15900, factor: 1.6 }
      },
      options: {
        demo: { price: 700, default: true }, elec: { price: 900, default: true },
        plumb: { price: 750, default: false }, plan: { price: 1100, default: false },
        design: { price: 1200, default: false }, furn: { price: 500, default: false }
      }
    };
    var optKeys = Object.keys(settings.options);

    var slider = $('[data-calc-area]', root);
    var areaOut = $('[data-out="area"]', root);
    var typeButtons = $$('[data-calc-type]', root);
    var optButtons = $$('[data-calc-opt]', root);

    var out = {
      total: $('[data-out="total"]', root),
      perM2: $('[data-out="perM2"]', root),
      days: $('[data-out="days"]', root),
      opts: $('[data-out="opts"]', root)
    };

    var state = {
      area: parseInt(slider.value, 10) || settings.areaDefault,
      type: settings.defaultType,
      opts: {}
    };
    optKeys.forEach(function (k) { state.opts[k] = !!settings.options[k].default; });

    var fmt = function (n) {
      return Math.round(n).toString().replace(/\B(?=(\d{3})+(?!\d))/g, ' ');
    };

    function render() {
      var extraSum = 0;
      var extraCount = 0;
      optKeys.forEach(function (k) {
        if (state.opts[k]) { extraSum += settings.options[k].price; extraCount++; }
      });

      var typeCfg = settings.types[state.type];
      var perM2 = typeCfg.base + extraSum;
      var total = perM2 * state.area;
      var days = Math.round(state.area * typeCfg.factor);

      if (areaOut) areaOut.textContent = state.area;
      if (out.total) out.total.textContent = fmt(total * 0.95) + ' – ' + fmt(total * 1.05) + ' ₽';
      if (out.perM2) out.perM2.textContent = fmt(perM2) + ' ₽';
      if (out.days) out.days.textContent = '≈ ' + days + ' дней';
      if (out.opts) out.opts.textContent = extraCount + ' из ' + optKeys.length;

      var pct = ((state.area - settings.areaMin) / (settings.areaMax - settings.areaMin)) * 100;
      slider.style.background =
        'linear-gradient(90deg, var(--accent) ' + pct + '%, rgba(18,16,14,.12) ' + pct + '%)';

      typeButtons.forEach(function (b) {
        b.setAttribute('aria-pressed', String(b.dataset.calcType === state.type));
      });
      optButtons.forEach(function (b) {
        b.setAttribute('aria-pressed', String(!!state.opts[b.dataset.calcOpt]));
      });
    }

    slider.addEventListener('input', function () {
      state.area = parseInt(slider.value, 10);
      render();
    });

    typeButtons.forEach(function (b) {
      b.addEventListener('click', function () {
        state.type = b.dataset.calcType;
        render();
      });
    });

    optButtons.forEach(function (b) {
      b.addEventListener('click', function () {
        var k = b.dataset.calcOpt;
        state.opts[k] = !state.opts[k];
        render();
      });
    });

    render();
  }

  /* --- Ползунки «было / стало» ----------------------------------------- */

  function initBeforeAfter() {
    $$('[data-ba]').forEach(function (frame) {
      var clip = $('.ba__clip', frame);
      var handle = $('.ba__handle', frame);
      if (!clip || !handle) return;

      var dragging = false;

      var setFromEvent = function (e) {
        var r = frame.getBoundingClientRect();
        var p = Math.max(2, Math.min(98, ((e.clientX - r.left) / r.width) * 100));
        set(p);
      };

      var set = function (p) {
        clip.style.width = p + '%';
        handle.style.left = p + '%';
        frame.setAttribute('aria-valuenow', Math.round(p));
      };

      frame.addEventListener('pointerdown', function (e) {
        dragging = true;
        frame.setPointerCapture && frame.setPointerCapture(e.pointerId);
        setFromEvent(e);
      });
      frame.addEventListener('pointermove', function (e) {
        if (dragging) setFromEvent(e);
      });
      window.addEventListener('pointerup', function () { dragging = false; });

      // Клавиатура: стрелками
      frame.addEventListener('keydown', function (e) {
        var cur = parseFloat(frame.getAttribute('aria-valuenow')) || 50;
        if (e.key === 'ArrowLeft') { set(Math.max(2, cur - 4)); e.preventDefault(); }
        if (e.key === 'ArrowRight') { set(Math.min(98, cur + 4)); e.preventDefault(); }
      });

      set(50);
    });
  }

  /* --- FAQ -------------------------------------------------------------- */

  function initFaq() {
    var list = $('[data-faq]');
    if (!list) return;

    var items = $$('.faq__item', list);

    items.forEach(function (item, i) {
      var btn = $('.faq__q', item);
      if (!btn) return;

      btn.addEventListener('click', function () {
        var willOpen = !item.classList.contains('is-open');
        items.forEach(function (other) {
          other.classList.remove('is-open');
          var b = $('.faq__q', other);
          if (b) b.setAttribute('aria-expanded', 'false');
        });
        if (willOpen) {
          item.classList.add('is-open');
          btn.setAttribute('aria-expanded', 'true');
        }
      });

      // Первый пункт открыт по умолчанию
      if (i === 0) {
        item.classList.add('is-open');
        btn.setAttribute('aria-expanded', 'true');
      }
    });
  }

  /* --- Фильтр портфолио ------------------------------------------------- */

  function initFilter() {
    var bar = $('[data-filter]');
    var list = $('[data-filter-list]');
    if (!bar || !list) return;

    var buttons = $$('[data-filter-value]', bar);
    var items = $$('[data-kind]', list);
    var counter = $('[data-filter-count]');

    function apply(value) {
      var shown = 0;
      items.forEach(function (item) {
        var match = value === 'all' || item.dataset.kind === value;
        item.hidden = !match;
        if (match) shown++;
      });
      buttons.forEach(function (b) {
        b.setAttribute('aria-pressed', String(b.dataset.filterValue === value));
      });
      if (counter) {
        counter.textContent = value === 'all'
          ? 'Показано: все ' + items.length + ' ' + plural(items.length, 'кейс', 'кейса', 'кейсов') + ' из 42 объектов'
          : 'Показано: ' + shown + ' из ' + items.length + ' ' + plural(items.length, 'кейса', 'кейсов', 'кейсов');
      }
    }

    buttons.forEach(function (b) {
      b.addEventListener('click', function () { apply(b.dataset.filterValue); });
    });

    apply('all');
  }

  /* --- Формы (демо: без бэкенда) --------------------------------------- */

  function initForms() {
    // Действие есть только на страницах, отданных Laravel (там же лежит
    // и CSRF-токен). На автономной статике формы просто показывают
    // «заявка принята», ничего никуда не отправляя.
    var actionUrl = $('meta[name="lead-action"]');
    var csrfToken = $('meta[name="csrf-token"]');

    $$('[data-form]').forEach(function (form) {
      var done = $('#' + form.dataset.form);
      var submitBtn = $('button[type="submit"]', form);

      form.addEventListener('submit', function (e) {
        e.preventDefault();
        if (submitBtn) submitBtn.disabled = true;

        var reveal = function () {
          if (submitBtn) submitBtn.disabled = false;
          if (!done) return;
          form.hidden = true;
          done.hidden = false;
          done.setAttribute('tabindex', '-1');
          done.focus({ preventScroll: true });
        };

        if (!actionUrl || !csrfToken || !window.fetch) {
          reveal();
          return;
        }

        var payload = {
          source: form.dataset.leadSource || 'contacts',
          phone: (form.querySelector('[name="phone"]') || {}).value || '',
          name: (form.querySelector('[name="name"]') || {}).value || '',
          area: (form.querySelector('[name="area"]') || {}).value || ''
        };

        fetch(actionUrl.content, {
          method: 'POST',
          headers: {
            'Content-Type': 'application/json',
            Accept: 'application/json',
            'X-CSRF-TOKEN': csrfToken.content
          },
          body: JSON.stringify(payload)
        })
          .then(reveal)
          .catch(reveal); // сеть недоступна — не блокируем UX демо-формы
      });
    });
  }

  /* --- Змейка: SVG-лента вдоль полей страницы -------------------------- */

  function initSnake() {
    var svg = $('.snake');
    if (!svg || reduceMotion) return;

    var SVGNS = 'http://www.w3.org/2000/svg';
    var ribbon = $('[data-snake-ribbon]', svg);
    var clipRect = $('[data-snake-clip]', svg);
    var head = $('[data-snake-head]', svg);
    // Невидимый путь: по нему меряем длину и снимаем точки осевой линии
    var helper = document.createElementNS(SVGNS, 'path');
    helper.setAttribute('fill', 'none');
    helper.setAttribute('stroke', 'none');
    svg.appendChild(helper);

    var len = 0;
    var enabled = false;
    var samples = [];   // предвычисленные точки вдоль ленты — на скролле только
                         // читаем из массива, ни одного обращения к SVG-геометрии

    /* Лёгкое органическое покачивание опорных точек. Без Math.random —
       детерминировано, чтобы при пересборке (resize) лента не прыгала. */
    function wobble(pts) {
      return pts.map(function (p, i) {
        var w = Math.sin(i * 1.7 + 0.6) * 11 + Math.sin(i * 0.55 + 2) * 6;
        return [p[0] + w, p[1]];
      });
    }

    /* Гладкая кривая через точки (Catmull-Rom → кубические Безье) */
    function smooth(pts) {
      var d = 'M ' + pts[0][0].toFixed(1) + ' ' + pts[0][1].toFixed(1);
      for (var i = 0; i < pts.length - 1; i++) {
        var p0 = pts[i - 1] || pts[i];
        var p1 = pts[i];
        var p2 = pts[i + 1];
        var p3 = pts[i + 2] || p2;
        var k = 0.9 / 6;
        var c1x = p1[0] + (p2[0] - p0[0]) * k;
        var c1y = p1[1] + (p2[1] - p0[1]) * k;
        var c2x = p2[0] - (p3[0] - p1[0]) * k;
        var c2y = p2[1] - (p3[1] - p1[1]) * k;
        d += ' C ' + c1x.toFixed(1) + ' ' + c1y.toFixed(1) +
             ', ' + c2x.toFixed(1) + ' ' + c2y.toFixed(1) +
             ', ' + p2[0].toFixed(1) + ' ' + p2[1].toFixed(1);
      }
      return d;
    }

    /* Полуширина ленты в точке t ∈ [0,1]: долго держит ширину,
       потом быстро сходит на нет */
    function halfWidth(t, w0) {
      return (w0 / 2) * Math.pow(Math.max(0, 1 - Math.pow(t, 2.4)), 0.75);
    }

    /* Из осевой линии делаем заливаемый контур с переменной шириной.
       Заодно, в этом же проходе, набираем samples[] — координаты вдоль
       ленты с равным шагом по длине. Дальше на каждый скролл-кадр берём
       из этого массива обычной интерполяцией, вместо повторных запросов
       к SVG-геометрии (getPointAtLength) — так дешевле для браузера. */
    function outline(centerline, w0) {
      helper.setAttribute('d', centerline);
      len = helper.getTotalLength();
      samples = [];
      if (!len) return '';

      var N = 160;
      var left = [];
      var right = [];

      for (var i = 0; i <= N; i++) {
        var t = i / N;
        var at = t * len;
        var p = helper.getPointAtLength(at);
        var a = helper.getPointAtLength(Math.max(0, at - 1.5));
        var b = helper.getPointAtLength(Math.min(len, at + 1.5));

        var dx = b.x - a.x;
        var dy = b.y - a.y;
        var m = Math.hypot(dx, dy) || 1;
        var nx = -dy / m;
        var ny = dx / m;
        var hw = halfWidth(t, w0);

        left.push([p.x + nx * hw, p.y + ny * hw]);
        right.push([p.x - nx * hw, p.y - ny * hw]);
        samples.push({ x: p.x, y: p.y });
      }

      var d = 'M ' + left[0][0].toFixed(1) + ' ' + left[0][1].toFixed(1);
      for (var j = 1; j < left.length; j++) {
        d += ' L ' + left[j][0].toFixed(1) + ' ' + left[j][1].toFixed(1);
      }
      for (var k = right.length - 1; k >= 0; k--) {
        d += ' L ' + right[k][0].toFixed(1) + ' ' + right[k][1].toFixed(1);
      }
      return d + ' Z';
    }

    /* Точка на ленте по доле пути p ∈ [0,1] — линейная интерполяция
       по кешу samples[], без обращений к SVG. */
    function sampleAt(p) {
      var idx = p * (samples.length - 1);
      var i0 = Math.max(0, Math.min(samples.length - 1, Math.floor(idx)));
      var i1 = Math.min(samples.length - 1, i0 + 1);
      var f = idx - i0;
      var a = samples[i0], b = samples[i1];
      return { x: a.x + (b.x - a.x) * f, y: a.y + (b.y - a.y) * f };
    }

    function topOf(sel) {
      var el = $(sel);
      if (!el) return null;
      var r = el.getBoundingClientRect();
      return { top: r.top + window.scrollY, height: r.height };
    }

    function build() {
      var W = document.documentElement.clientWidth;

      // На узких экранах полей нет — ленте негде идти
      if (W < 1100) {
        enabled = false;
        svg.classList.remove('is-ready');
        svg.style.height = '0px';
        return;
      }
      enabled = true;

      var hero = topOf('.hero');
      var promises = topOf('#promises');
      var services = topOf('#services');
      var calc = topOf('#calc');
      var pricing = topOf('#pricing');
      var works = topOf('#works');
      if (!hero || !promises || !services || !calc || !pricing || !works) {
        enabled = false;
        return;
      }

      var heroBottom = hero.top + hero.height;
      var yEnd = works.top + 260;

      // Поля страницы: где заканчивается фон и начинается текст колонки
      var content = Math.min(1360, W - 56);
      var gutter = (W - content) / 2;
      var inner = gutter + 28;                       // левый край текста

      var w0 = Math.max(16, Math.min(46, (inner - 14) * 0.62));

      var xEdge = Math.max(w0 * 0.62, gutter * 0.28); // ближе к краю, но не срезаясь об него
      var xInner = Math.max(28, inner - w0 / 2 - 4); // впритык к контенту, не заезжая на текст
      var xUnder = W - inner + w0 * 0.9;             // справа можно уйти под карточки: они непрозрачные

      var pts = [
        [xInner, heroBottom - 220],                                   // стартует под первым экраном
        [xEdge, heroBottom + 30],                                     // выходит к самому краю
        [xInner, promises.top + promises.height * 0.34],              // подходит вплотную к карточкам
        [xEdge + (xInner - xEdge) * 0.15, promises.top + promises.height * 0.76],
        [xInner, services.top - 20],
        [W * 0.5, services.top + services.height * 0.55],             // пересекает тёмный блок насквозь
        [W - xEdge, services.top + services.height + 30],             // выныривает справа
        [xUnder, calc.top + calc.height * 0.30],                      // ныряет под панель калькулятора
        [W - xEdge, calc.top + calc.height * 0.86],
        [xUnder, pricing.top + pricing.height * 0.52],                // обвивает карточки тарифов
        [W - xEdge * 0.6, yEnd]                                       // истончается и уходит за край
      ];

      var centerline = smooth(wobble(pts));

      var height = Math.ceil(yEnd + 120);
      svg.setAttribute('viewBox', '0 0 ' + W + ' ' + height);
      svg.setAttribute('width', W);
      svg.setAttribute('height', height);
      svg.style.height = height + 'px';

      helper.setAttribute('d', centerline);
      ribbon.setAttribute('d', outline(centerline, w0));

      // Отсечение прямоугольником — дёшево для браузера, в отличие от SVG-маски
      clipRect.setAttribute('width', String(W));
      clipRect.setAttribute('height', '0');

      svg.dataset.y0 = String(pts[0][1]);
      svg.dataset.y1 = String(yEnd);

      update();
      svg.classList.add('is-ready');
    }

    var ticking = false;

    function update() {
      if (!enabled || !len) return;

      var y0 = parseFloat(svg.dataset.y0);
      var y1 = parseFloat(svg.dataset.y1);
      var lead = window.scrollY + window.innerHeight * 0.62;
      var p = Math.max(0, Math.min(1, (lead - y0) / (y1 - y0)));

      // Голова ленты идёт по самой кривой, а срез — ровно по ней,
      // так что горизонтального «шва» не видно. Точка — из кеша (дёшево).
      var pt = sampleAt(p);
      clipRect.setAttribute('height', Math.max(0, pt.y + 1).toFixed(1));

      if (head) {
        if (p > 0.02 && p < 0.96) {
          head.setAttribute('cx', pt.x.toFixed(1));
          head.setAttribute('cy', pt.y.toFixed(1));
          head.setAttribute('r', String(4 + 5 * (1 - p)));
          head.style.opacity = '1';
        } else {
          head.style.opacity = '0';
        }
      }

      ticking = false;
    }

    window.addEventListener('scroll', function () {
      if (!ticking) { ticking = true; requestAnimationFrame(update); }
    }, { passive: true });

    var resizeTimer;
    window.addEventListener('resize', function () {
      clearTimeout(resizeTimer);
      resizeTimer = setTimeout(build, 180);
    });

    build();
    // Пересобираем после подгрузки картинок — от них зависит высота секций
    window.addEventListener('load', build);
  }

  /* --- Запуск ----------------------------------------------------------- */

  function boot() {
    initHeader();
    initThemeToggle();
    initProgress();
    initReveal();
    initCounters();
    initHeroParallax();
    initCalculator();
    initBeforeAfter();
    initFaq();
    initFilter();
    initForms();
    initSnake();
  }

  if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', boot);
  } else {
    boot();
  }
})();
