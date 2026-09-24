@extends('admin.layout')

@section('title', 'Калькулятор стоимости')
@section('hint', 'Цены за м², сроки и опции блока «02 — калькулятор» на главной')

@section('content')
<form class="admin-form" method="POST" action="{{ route('admin.calculator.update') }}">
  @csrf
  @method('PUT')

  <fieldset>
    <legend>Площадь</legend>
    <div class="field-grid">
      <div class="field">
        <label for="area_min">Минимум, м²</label>
        <input type="number" id="area_min" name="area_min" value="{{ old('area_min', $calc->area_min) }}">
      </div>
      <div class="field">
        <label for="area_max">Максимум, м²</label>
        <input type="number" id="area_max" name="area_max" value="{{ old('area_max', $calc->area_max) }}">
      </div>
      <div class="field">
        <label for="area_default">Значение по умолчанию, м²</label>
        <input type="number" id="area_default" name="area_default" value="{{ old('area_default', $calc->area_default) }}">
      </div>
      <div class="field">
        <label for="default_type">Тип ремонта по умолчанию</label>
        <select id="default_type" name="default_type">
          <option value="cos" {{ $calc->default_type === 'cos' ? 'selected' : '' }}>Косметический</option>
          <option value="kap" {{ $calc->default_type === 'kap' ? 'selected' : '' }}>Капитальный</option>
          <option value="diz" {{ $calc->default_type === 'diz' ? 'selected' : '' }}>Дизайнерский</option>
        </select>
      </div>
    </div>
  </fieldset>

  @foreach ([
      'cos' => 'Косметический',
      'kap' => 'Капитальный',
      'diz' => 'Дизайнерский',
  ] as $key => $defaultLabel)
  <fieldset>
    <legend>Тип: {{ $defaultLabel }}</legend>
    <div class="field-grid">
      <div class="field">
        <label for="type_{{ $key }}_label">Название</label>
        <input type="text" id="type_{{ $key }}_label" name="type_{{ $key }}_label" value="{{ old("type_{$key}_label", $calc->{"type_{$key}_label"}) }}">
      </div>
      <div class="field">
        <label for="base_{{ $key }}">Цена за м², ₽</label>
        <input type="number" id="base_{{ $key }}" name="base_{{ $key }}" value="{{ old("base_{$key}", $calc->{"base_{$key}"}) }}">
      </div>
      <div class="field">
        <label for="factor_{{ $key }}">Дней на 1 м² (коэффициент срока)</label>
        <input type="number" step="0.01" id="factor_{{ $key }}" name="factor_{{ $key }}" value="{{ old("factor_{$key}", $calc->{"factor_{$key}"}) }}">
      </div>
    </div>
  </fieldset>
  @endforeach

  <fieldset>
    <legend>Дополнительные опции</legend>
    <div class="field-grid">
      @foreach ([
          'demo' => 'Демонтаж старой отделки',
          'elec' => 'Полная замена электрики',
          'plumb' => 'Замена труб и сантехники',
          'plan' => 'Перепланировка с проектом',
          'design' => 'Дизайн-проект',
          'furn' => 'Сборка и монтаж мебели',
      ] as $key => $defaultLabel)
      <div class="admin-card" style="padding:16px">
        <div class="field">
          <label for="opt_{{ $key }}_label">Название</label>
          <input type="text" id="opt_{{ $key }}_label" name="opt_{{ $key }}_label" value="{{ old("opt_{$key}_label", $calc->{"opt_{$key}_label"}) }}">
        </div>
        <div class="field">
          <label for="opt_{{ $key }}_price">Наценка, ₽/м²</label>
          <input type="number" id="opt_{{ $key }}_price" name="opt_{{ $key }}_price" value="{{ old("opt_{$key}_price", $calc->{"opt_{$key}_price"}) }}">
        </div>
        <div class="field-check">
          <input type="checkbox" id="opt_{{ $key }}_default" name="opt_{{ $key }}_default" value="1" {{ old("opt_{$key}_default", $calc->{"opt_{$key}_default"}) ? 'checked' : '' }}>
          <label for="opt_{{ $key }}_default">Включена по умолчанию</label>
        </div>
      </div>
      @endforeach
    </div>
  </fieldset>

  <button type="submit" class="admin-btn admin-btn--primary">Сохранить</button>
</form>
@endsection
