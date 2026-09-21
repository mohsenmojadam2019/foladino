<!doctype html>
<html lang="fa" dir="rtl">
<head>
  <meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1">
  <title>ورود سازمانی | فولادینو</title>
  <link rel="icon" href="{{ $siteSettings['logo_image'] ?? '/images/logo-mark.svg' }}">
  <link rel="stylesheet" href="/css/app.css?v=14050701">
</head>
<body class="login-body">
<main class="login-shell">
  <section class="login-art">
    <img src="/images/home-ref/hero.png" alt="">
    <div>
      <span>پنل سازمانی فولادینو</span>
      <h1>مدیریت فروش، قیمت و سفارش‌ها<br>در یک فضای متمرکز</h1>
      <p>ورود ویژه مدیران و کاربران سازمانی فولادینو.</p>
      <div class="login-art-points"><b>✓ امنیت حساب</b><b>✓ مدیریت سفارش‌ها</b><b>✓ قیمت‌گذاری متمرکز</b></div>
    </div>
  </section>
  <section class="login-panel">
    <a class="brand" href="/">
      <img src="{{ $siteSettings['logo_image'] ?? '/images/logo-mark.svg' }}" alt="">
      <span><strong>فولادینو</strong><small>قدرت در اعتماد</small></span>
    </a>
    <div class="login-form-wrap">
      <small>خوش آمدید</small><h2>ورود به پنل سازمانی</h2><p>اطلاعات حساب کاربری خود را وارد کنید.</p>
      @if(session('error'))<div class="flash error">{{ session('error') }}</div>@endif
      <form method="post" action="{{ route('admin.login.submit') }}">
        @csrf
        <label>ایمیل سازمانی<input name="email" type="email" value="{{ old('email') }}" required placeholder="name@company.ir"></label>
        <label>رمز عبور<input name="password" type="password" required placeholder="••••••••"></label>
        <label class="remember"><input type="checkbox" name="remember"> مرا به خاطر بسپار</label>
        <button class="btn btn-primary btn-lg">ورود امن به پنل</button>
      </form>
      <a class="login-back" href="/">← بازگشت به وب‌سایت فولادینو</a>
      <div class="login-hint {{ app()->environment('local') ? '' : 'hidden' }}"><b>حساب دمو Seeder</b><span>admin@fooladino.ir</span><span>Fooladino@1405</span></div>
    </div>
  </section>
</main>
</body>
</html>