@extends('admin.layout')

@section('title', 'Пример сметы')
@section('hint', 'Блок «Пример сметы» на странице «Цены»')

@section('content')
<form class="admin-form" method="POST" action="{{ route('admin.estimate.update') }}">
  @csrf
  @method('PUT')

  <fieldset>
    <legend>Заголовок блока</legend>
    <div class="field">
      <label for="title">Заголовок</label>
      <input type="text" id="title" name="title" value="{{ old('title', $estimate->title) }}">
    </div>
    <div class="field">
      <label for="subtitle">Описание</label>
      <textarea id="subtitle" name="subtitle">{{ old('subtitle', $estimate->subtitle) }}</textarea>
    </div>
    <div class="field" data-repeater>
      <label>Пункты «объёмы посчитаны по факту...»</label>
      <div class="repeater" data-repeater-list>
        @foreach (old('checklist', $estimate->checklist ?: ['']) as $line)
        <div class="repeater__row">
          <input type="text" name="checklist[]" value="{{ $line }}">
          <button type="button" class="repeater__remove">×</button>
        </div>
        @endforeach
      </div>
      <button type="button" class="repeater__add" data-repeater-add>+ Добавить пункт</button>
      <template><div class="repeater__row"><input type="text" name="checklist[]" value=""><button type="button" class="repeater__remove">×</button></div></template>
    </div>
  </fieldset>

  <fieldset>
    <legend>Карточка сметы</legend>
    <div class="field-grid">
      <div class="field">
        <label for="code_label">Номер сметы</label>
        <input type="text" id="code_label" name="code_label" value="{{ old('code_label', $estimate->code_label) }}">
      </div>
      <div class="field">
        <label for="area_label">Площадь и тип</label>
        <input type="text" id="area_label" name="area_label" value="{{ old('area_label', $estimate->area_label) }}">
      </div>
    </div>

    <div class="field" data-repeater>
      <label>Строки сметы (название — сумма)</label>
      <div class="repeater" data-repeater-list>
        @foreach (old('rows', $estimate->rows ?: [['name' => '', 'price' => '']]) as $row)
        <div class="repeater__row is-pair">
          <input type="text" name="rows[][name]" placeholder="Название раздела" value="{{ $row['name'] ?? '' }}">
          <input type="text" name="rows[][price]" placeholder="Сумма" value="{{ $row['price'] ?? '' }}" style="max-width:160px">
          <button type="button" class="repeater__remove">×</button>
        </div>
        @endforeach
      </div>
      <button type="button" class="repeater__add" data-repeater-add>+ Добавить строку</button>
      <template>
        <div class="repeater__row is-pair">
          <input type="text" name="rows[][name]" placeholder="Название раздела" value="">
          <input type="text" name="rows[][price]" placeholder="Сумма" value="" style="max-width:160px">
          <button type="button" class="repeater__remove">×</button>
        </div>
      </template>
    </div>

    <div class="field-grid">
      <div class="field">
        <label for="total_label">Подпись итога</label>
        <input type="text" id="total_label" name="total_label" value="{{ old('total_label', $estimate->total_label) }}">
      </div>
      <div class="field">
        <label for="total_value">Итоговая сумма</label>
        <input type="text" id="total_value" name="total_value" value="{{ old('total_value', $estimate->total_value) }}">
      </div>
      <div class="field">
        <label for="materials_label">Подпись «материалы»</label>
        <input type="text" id="materials_label" name="materials_label" value="{{ old('materials_label', $estimate->materials_label) }}">
      </div>
      <div class="field">
        <label for="materials_value">Сумма материалов</label>
        <input type="text" id="materials_value" name="materials_value" value="{{ old('materials_value', $estimate->materials_value) }}">
      </div>
      <div class="field">
        <label for="days_label">Подпись «срок»</label>
        <input type="text" id="days_label" name="days_label" value="{{ old('days_label', $estimate->days_label) }}">
      </div>
      <div class="field">
        <label for="days_value">Срок</label>
        <input type="text" id="days_value" name="days_value" value="{{ old('days_value', $estimate->days_value) }}">
      </div>
      <div class="field">
        <label for="cta_label">Текст кнопки</label>
        <input type="text" id="cta_label" name="cta_label" value="{{ old('cta_label', $estimate->cta_label) }}">
      </div>
    </div>
  </fieldset>

  <button type="submit" class="admin-btn admin-btn--primary">Сохранить</button>
</form>
@endsection
