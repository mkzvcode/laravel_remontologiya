@extends('admin.layout')

@php($isEdit = $item->exists)
@section('title', ($isEdit ? 'Изменить' : 'Добавить').' — '.$def['title'])

@section('content')

<form class="admin-form" method="POST"
      action="{{ $isEdit ? route('admin.resource.update', [$slug, $item->id]) : route('admin.resource.store', $slug) }}"
      enctype="multipart/form-data">
  @csrf
  @if ($isEdit) @method('PUT') @endif

  <div class="admin-card">
    @foreach ($def['fields'] as $field)
      @include('admin.resources.field', ['field' => $field, 'item' => $item, 'selectOptions' => $selectOptions])
    @endforeach
  </div>

  <div style="display:flex;gap:10px">
    <button type="submit" class="admin-btn admin-btn--primary">{{ $isEdit ? 'Сохранить' : 'Создать' }}</button>
    <a class="admin-btn admin-btn--ghost" href="{{ route('admin.resource.index', $slug) }}">Отмена</a>
  </div>
</form>

@if ($isEdit)
<form method="POST" action="{{ route('admin.resource.destroy', [$slug, $item->id]) }}" style="margin-top:20px" data-confirm="Удалить запись без возможности восстановить?">
  @csrf @method('DELETE')
  <button type="submit" class="admin-btn admin-btn--danger admin-btn--sm">Удалить эту запись</button>
</form>
@endif

@endsection
