<!DOCTYPE html>
<html lang="ru" data-theme="light">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="robots" content="noindex, nofollow">
<title>Вход в админку · Ремонтология</title>
<link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=Baloo+2:wght@700;800&family=Manrope:wght@400;500;600;700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="{{ asset('assets/css/style.css') }}?v={{ @filemtime(public_path('assets/css/style.css')) ?: time() }}">
<link rel="stylesheet" href="{{ asset('assets/css/admin.css') }}?v={{ @filemtime(public_path('assets/css/admin.css')) ?: time() }}">
</head>
<body>
<div class="admin-login">
  <div class="admin-login__card">
    <div class="admin-login__brand">
      @include('partials.logo')
      <span style="font-size:11px;color:var(--text-4)">Админ-панель</span>
    </div>
    <h1>Вход</h1>

    @if ($errors->any())
    <div class="admin-errors">{{ $errors->first() }}</div>
    @endif

    <form class="admin-form" method="POST" action="{{ route('admin.login') }}">
      @csrf
      <div class="field">
        <label for="email">Логин</label>
        <input type="text" id="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="username">
      </div>
      <div class="field">
        <label for="password">Пароль</label>
        <input type="password" id="password" name="password" required autocomplete="current-password">
      </div>
      <div class="field-check">
        <input type="checkbox" id="remember" name="remember">
        <label for="remember">Запомнить меня</label>
      </div>
      <button class="admin-btn admin-btn--primary" type="submit">Войти</button>
    </form>
  </div>
</div>
</body>
</html>
