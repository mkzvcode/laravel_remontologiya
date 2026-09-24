@extends('admin.layout')

@section('title', 'Дашборд')
@section('hint', 'Быстрый обзор сайта и последние заявки')

@section('content')

<div class="admin-stats">
  @foreach ($stats as $stat)
  <a class="admin-stat" href="{{ $stat['href'] }}">
    <div class="admin-stat__num">{{ $stat['value'] }}</div>
    <div class="admin-stat__label">{{ $stat['label'] }}</div>
  </a>
  @endforeach
</div>

<div class="field-grid" style="align-items:start">
  <div class="admin-card">
    <h2 style="margin:0 0 14px;font-family:var(--f-display);font-size:16px;font-weight:600">Страницы сайта</h2>
    <div style="display:grid;gap:6px">
      @foreach ($pages as $p)
      <a class="admin-btn admin-btn--ghost admin-btn--sm" style="justify-content:space-between" href="{{ route('admin.pages.edit', $p->slug) }}">
        {{ $p->meta_title }}
      </a>
      @endforeach
    </div>
  </div>

  <div class="admin-card">
    <h2 style="margin:0 0 14px;font-family:var(--f-display);font-size:16px;font-weight:600">Последние заявки</h2>
    @if ($recentLeads->isEmpty())
    <p class="text-muted" style="font-size:14px">Пока пусто — заявки с сайта появятся здесь.</p>
    @else
    <div style="display:grid;gap:10px">
      @foreach ($recentLeads as $lead)
      <div style="padding:12px 14px;border-radius:10px;border:1px solid var(--admin-border);{{ $lead->is_read ? '' : 'background:rgba(201,113,74,.05)' }}">
        <div style="display:flex;justify-content:space-between;gap:10px;font-size:13.5px">
          <b>{{ $lead->name ?: 'Без имени' }}</b>
          <span class="text-muted">{{ $lead->created_at->diffForHumans() }}</span>
        </div>
        <div style="margin-top:4px;font-size:13px;color:var(--text-3)">{{ $lead->phone }} · {{ $lead->source === 'calc' ? 'калькулятор' : 'форма контактов' }}</div>
      </div>
      @endforeach
    </div>
    <a class="admin-btn admin-btn--ghost admin-btn--sm" style="margin-top:14px" href="{{ route('admin.leads.index') }}">Все заявки →</a>
    @endif
  </div>
</div>

@endsection
