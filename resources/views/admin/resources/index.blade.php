@extends('admin.layout')

@section('title', $def['title'])
@section('hint', $def['hint'] ?? '')

@section('topbar-actions')
<a class="admin-btn admin-btn--primary" href="{{ route('admin.resource.create', $slug) }}">+ Добавить</a>
@endsection

@section('content')

@if ($items->isEmpty())
<div class="admin-table-wrap">
  <div class="admin-empty">Пока пусто. <a href="{{ route('admin.resource.create', $slug) }}">Добавить первую запись</a>.</div>
</div>
@else
<div class="admin-table-wrap">
  <table class="admin-table">
    <thead>
      <tr>
        @if ($def['orderable'] ?? false)
        <th style="width:70px">Порядок</th>
        @endif
        @foreach ($def['list_columns'] as $col)
        <th>{{ collect($def['fields'])->firstWhere('name', $col)['label'] ?? $col }}</th>
        @endforeach
        <th style="width:1%"></th>
      </tr>
    </thead>
    <tbody>
      @foreach ($items as $item)
      <tr>
        @if ($def['orderable'] ?? false)
        <td>
          <div class="admin-order-controls">
            <form method="POST" action="{{ route('admin.resource.move', [$slug, $item->id, 'up']) }}">
              @csrf @method('PATCH')
              <button type="submit" title="Выше">↑</button>
            </form>
            <form method="POST" action="{{ route('admin.resource.move', [$slug, $item->id, 'down']) }}">
              @csrf @method('PATCH')
              <button type="submit" title="Ниже">↓</button>
            </form>
          </div>
        </td>
        @endif

        @foreach ($def['list_columns'] as $col)
        @php($fieldDef = collect($def['fields'])->firstWhere('name', $col))
        <td>
          @if (($fieldDef['type'] ?? null) === 'image')
            @if ($item->{$col})
            <img class="thumb" src="{{ $item->{$col} }}" alt="">
            @else
            <span class="text-muted">—</span>
            @endif
          @elseif (($fieldDef['type'] ?? null) === 'checkbox')
            <span class="badge {{ $item->{$col} ? 'badge--on' : 'badge--off' }}">{{ $item->{$col} ? 'Да' : 'Нет' }}</span>
          @elseif (($fieldDef['type'] ?? null) === 'select')
            {{ $fieldDef['options'][$item->{$col}] ?? $item->{$col} }}
          @elseif (($fieldDef['type'] ?? null) === 'select_model')
            {{ optional($fieldDef['model']::find($item->{$col}))->{$fieldDef['option_label']} }}
          @else
            {{ \Illuminate\Support\Str::limit(strip_tags((string) $item->{$col}), 60) }}
          @endif
        </td>
        @endforeach

        <td class="is-actions">
          @if (isset($def['toggle_column']))
          <form method="POST" action="{{ route('admin.resource.toggle', [$slug, $item->id]) }}" style="display:inline">
            @csrf @method('PATCH')
            <button type="submit" class="admin-btn admin-btn--ghost admin-btn--sm">
              {{ $item->{$def['toggle_column']} ? 'Снять с публикации' : 'Опубликовать' }}
            </button>
          </form>
          @endif
          <a class="admin-btn admin-btn--ghost admin-btn--sm" href="{{ route('admin.resource.edit', [$slug, $item->id]) }}">Изменить</a>
          <form method="POST" action="{{ route('admin.resource.destroy', [$slug, $item->id]) }}" style="display:inline" data-confirm="Удалить запись без возможности восстановить?">
            @csrf @method('DELETE')
            <button type="submit" class="admin-btn admin-btn--danger admin-btn--sm">Удалить</button>
          </form>
        </td>
      </tr>
      @endforeach
    </tbody>
  </table>
</div>
@endif

@endsection
