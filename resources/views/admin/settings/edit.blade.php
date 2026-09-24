@extends('admin.layout')

@section('title', 'Настройки и контакты')
@section('hint', 'Телефон, соцсети, подвал сайта и SEO по умолчанию — используются на всех страницах')

@section('content')
<form class="admin-form" method="POST" action="{{ route('admin.settings.update') }}">
  @csrf
  @method('PUT')

  <fieldset>
    <legend>Бренд</legend>
    <div class="field-grid">
      <div class="field">
        <label for="brand_name">Название компании</label>
        <input type="text" id="brand_name" name="brand_name" value="{{ old('brand_name', $setting->brand_name) }}">
      </div>
      <div class="field">
        <label for="brand_meta">Подпись под названием</label>
        <input type="text" id="brand_meta" name="brand_meta" value="{{ old('brand_meta', $setting->brand_meta) }}">
      </div>
    </div>
  </fieldset>

  <fieldset>
    <legend>Контакты</legend>
    <div class="field-grid">
      <div class="field">
        <label for="phone_e164">Телефон для ссылок tel:</label>
        <input type="text" id="phone_e164" name="phone_e164" value="{{ old('phone_e164', $setting->phone_e164) }}">
        <div class="hint">В формате +7XXXXXXXXXX, без пробелов</div>
      </div>
      <div class="field">
        <label for="phone_display">Телефон для показа</label>
        <input type="text" id="phone_display" name="phone_display" value="{{ old('phone_display', $setting->phone_display) }}">
      </div>
      <div class="field">
        <label for="email">E-mail</label>
        <input type="email" id="email" name="email" value="{{ old('email', $setting->email) }}">
      </div>
      <div class="field">
        <label for="whatsapp_url">Ссылка WhatsApp</label>
        <input type="url" id="whatsapp_url" name="whatsapp_url" value="{{ old('whatsapp_url', $setting->whatsapp_url) }}">
      </div>
      <div class="field">
        <label for="telegram_url">Ссылка Telegram</label>
        <input type="url" id="telegram_url" name="telegram_url" value="{{ old('telegram_url', $setting->telegram_url) }}">
      </div>
      <div class="field">
        <label for="address_line">Адрес / зона обслуживания</label>
        <input type="text" id="address_line" name="address_line" value="{{ old('address_line', $setting->address_line) }}">
      </div>
      <div class="field">
        <label for="work_hours">Часы работы</label>
        <input type="text" id="work_hours" name="work_hours" value="{{ old('work_hours', $setting->work_hours) }}">
      </div>
      <div class="field">
        <label for="inn">ИНН</label>
        <input type="text" id="inn" name="inn" value="{{ old('inn', $setting->inn) }}">
      </div>
    </div>
  </fieldset>

  <fieldset>
    <legend>Подвал сайта</legend>
    <div class="field">
      <label for="footer_about">Текст «о компании» в подвале</label>
      <textarea id="footer_about" name="footer_about">{{ old('footer_about', $setting->footer_about) }}</textarea>
    </div>
    <div class="field">
      <label for="footer_legal">Копирайт-строка</label>
      <input type="text" id="footer_legal" name="footer_legal" value="{{ old('footer_legal', $setting->footer_legal) }}">
    </div>
  </fieldset>

  <fieldset>
    <legend>SEO и аналитика</legend>
    <div class="field">
      <label for="seo_suffix">Суффикс заголовка страниц</label>
      <input type="text" id="seo_suffix" name="seo_suffix" value="{{ old('seo_suffix', $setting->seo_suffix) }}">
    </div>
    <div class="field-grid">
      <div class="field">
        <label for="ga_id">Google Analytics ID</label>
        <input type="text" id="ga_id" name="ga_id" value="{{ old('ga_id', $setting->ga_id) }}" placeholder="G-XXXXXXX">
      </div>
      <div class="field">
        <label for="metrika_id">Яндекс.Метрика ID</label>
        <input type="text" id="metrika_id" name="metrika_id" value="{{ old('metrika_id', $setting->metrika_id) }}" placeholder="12345678">
      </div>
    </div>
  </fieldset>

  <button type="submit" class="admin-btn admin-btn--primary">Сохранить</button>
</form>
@endsection
