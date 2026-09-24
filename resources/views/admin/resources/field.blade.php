@php
    $name = $field['name'];
    $type = $field['type'];
    $label = $field['label'];
    $current = old($name, $item->{$name} ?? null);
@endphp

@if ($type === 'text' || $type === 'number')
  <div class="field">
    <label for="f-{{ $name }}">{{ $label }}</label>
    <input type="{{ $type === 'number' ? 'number' : 'text' }}" id="f-{{ $name }}" name="{{ $name }}" value="{{ $current }}">
    @if (!empty($field['hint']))<div class="hint">{{ $field['hint'] }}</div>@endif
  </div>

@elseif ($type === 'textarea')
  <div class="field">
    <label for="f-{{ $name }}">{{ $label }}</label>
    <textarea id="f-{{ $name }}" name="{{ $name }}">{{ $current }}</textarea>
    @if (!empty($field['hint']))<div class="hint">{{ $field['hint'] }}</div>@endif
  </div>

@elseif ($type === 'richtext')
  <div class="field">
    <label for="f-{{ $name }}">{{ $label }}</label>
    <textarea id="f-{{ $name }}" name="{{ $name }}" class="is-tall">{{ $current }}</textarea>
    @if (!empty($field['hint']))<div class="hint">{{ $field['hint'] }}</div>@endif
  </div>

@elseif ($type === 'checkbox')
  <div class="field-check">
    <input type="checkbox" id="f-{{ $name }}" name="{{ $name }}" value="1" {{ $current ? 'checked' : '' }}>
    <label for="f-{{ $name }}">{{ $label }}</label>
  </div>

@elseif ($type === 'select')
  <div class="field">
    <label for="f-{{ $name }}">{{ $label }}</label>
    <select id="f-{{ $name }}" name="{{ $name }}">
      @foreach ($field['options'] as $value => $optionLabel)
      <option value="{{ $value }}" {{ (string) $current === (string) $value ? 'selected' : '' }}>{{ $optionLabel }}</option>
      @endforeach
    </select>
  </div>

@elseif ($type === 'select_model')
  <div class="field">
    <label for="f-{{ $name }}">{{ $label }}</label>
    <select id="f-{{ $name }}" name="{{ $name }}">
      @foreach (($selectOptions[$name] ?? []) as $value => $optionLabel)
      <option value="{{ $value }}" {{ (string) $current === (string) $value ? 'selected' : '' }}>{{ $optionLabel }}</option>
      @endforeach
    </select>
  </div>

@elseif ($type === 'image')
  <div class="field">
    <label>{{ $label }}</label>
    <div class="image-field">
      <img class="image-field__preview" src="{{ $item->{$name} ?: 'https://placehold.co/84x84/ece5db/8a8177?text=%20' }}" alt="">
      <div class="image-field__controls">
        <input type="file" name="{{ $name }}" accept="image/*">
        @if ($item->{$name})
        <label class="image-field__remove">
          <input type="checkbox" name="{{ $name }}_remove" value="1"> Удалить текущее фото
        </label>
        @endif
      </div>
    </div>
    @if (!empty($field['hint']))<div class="hint">{{ $field['hint'] }}</div>@endif
  </div>

@elseif ($type === 'repeater')
  @php($values = is_array($current) ? $current : [])
  <div class="field" data-repeater>
    <label>{{ $label }}</label>
    <div class="repeater" data-repeater-list>
      @forelse ($values as $value)
      <div class="repeater__row">
        <input type="text" name="{{ $name }}[]" value="{{ $value }}">
        <button type="button" class="repeater__remove" aria-label="Удалить строку">×</button>
      </div>
      @empty
      <div class="repeater__row">
        <input type="text" name="{{ $name }}[]" value="">
        <button type="button" class="repeater__remove" aria-label="Удалить строку">×</button>
      </div>
      @endforelse
    </div>
    <button type="button" class="repeater__add" data-repeater-add>+ Добавить строку</button>
    <template>
      <div class="repeater__row">
        <input type="text" name="{{ $name }}[]" value="">
        <button type="button" class="repeater__remove" aria-label="Удалить строку">×</button>
      </div>
    </template>
  </div>
@endif
