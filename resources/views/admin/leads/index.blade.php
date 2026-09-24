@extends('admin.layout')

@section('title', 'Заявки с сайта')
@section('hint', 'Калькулятор и форма контактов на главной')

@section('content')

@if ($leads->isEmpty())
<div class="admin-table-wrap">
  <div class="admin-empty">Заявок пока нет.</div>
</div>
@else
<div class="admin-table-wrap">
  <table class="admin-table">
    <thead>
      <tr>
        <th>Когда</th>
        <th>Источник</th>
        <th>Имя</th>
        <th>Телефон</th>
        <th>Площадь</th>
        <th></th>
        <th style="width:1%"></th>
      </tr>
    </thead>
    <tbody>
      @foreach ($leads as $lead)
      <tr style="{{ $lead->is_read ? '' : 'background:rgba(201,113,74,.05)' }}">
        <td>{{ $lead->created_at->format('d.m.Y H:i') }}</td>
        <td>{{ $lead->source === 'calc' ? 'Калькулятор' : 'Форма контактов' }}</td>
        <td>{{ $lead->name ?: '—' }}</td>
        <td><a href="tel:{{ $lead->phone }}">{{ $lead->phone }}</a></td>
        <td>{{ $lead->area ?: '—' }}</td>
        <td>
          @unless ($lead->is_read)
          <span class="badge badge--on">Новая</span>
          @endunless
        </td>
        <td class="is-actions">
          @unless ($lead->is_read)
          <form method="POST" action="{{ route('admin.leads.read', $lead) }}" style="display:inline">
            @csrf @method('PATCH')
            <button type="submit" class="admin-btn admin-btn--ghost admin-btn--sm">Прочитано</button>
          </form>
          @endunless
          <form method="POST" action="{{ route('admin.leads.destroy', $lead) }}" style="display:inline" data-confirm="Удалить заявку?">
            @csrf @method('DELETE')
            <button type="submit" class="admin-btn admin-btn--danger admin-btn--sm">Удалить</button>
          </form>
        </td>
      </tr>
      @endforeach
    </tbody>
  </table>
</div>

<div style="margin-top:20px">{{ $leads->links() }}</div>
@endif

@endsection
