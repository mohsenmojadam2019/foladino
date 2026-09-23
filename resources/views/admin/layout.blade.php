<!doctype html>
<html lang="fa" dir="rtl">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>@yield('title','پنل مدیریت') | فولادینو</title>
  <link rel="icon" href="{{ site_asset($siteSettings['logo_image'] ?? '/images/logo-mark.svg') }}">
  <link rel="stylesheet" href="{{ asset('css/app.css?v=14050702') }}">
</head>
<body class="admin-body">
@php($role = auth()->user()->role)
<div class="admin-shell admin-v2">
  <aside class="admin-sidebar" id="adminSidebar">
    <a class="admin-brand" href="{{ route('admin.dashboard') }}">
      <span class="admin-brand-mark"><img src="{{ site_asset($siteSettings['logo_image'] ?? '/images/logo-mark.svg') }}" alt=""></span>
      <span><strong>فولادینو</strong><small>پنل مدیریت</small></span>
    </a>

    <div class="admin-user-card">
      <div class="avatar">{{ mb_substr(auth()->user()->name,0,1) }}</div>
      <div><b>{{ auth()->user()->name }}</b><small>{{ ['super_admin'=>'مدیر سیستم','admin'=>'مدیر','pricing'=>'مدیر قیمت‌گذاری','content'=>'مدیر محتوا'][$role] ?? $role }}</small></div>
      <span>⌄</span>
    </div>

    <nav class="admin-nav">
      <a class="{{ request()->routeIs('admin.dashboard')?'active':'' }}" href="{{ route('admin.dashboard') }}"><i>⌂</i><span>داشبورد</span></a>
      @if(in_array($role,['super_admin','admin']))
      <a class="{{ request()->routeIs('admin.catalog*')?'active':'' }}" href="{{ route('admin.catalog') }}"><i>▦</i><span>مدیریت محصولات</span></a>
      @endif
      @if(in_array($role,['super_admin','admin','pricing']))
      <a class="{{ request()->routeIs('admin.pricing*')?'active':'' }}" href="{{ route('admin.pricing') }}"><i>⌁</i><span>مدیریت قیمت‌ها</span></a>
      @endif
      @if(in_array($role,['super_admin','admin']))
      <a class="{{ request()->routeIs('admin.orders*')?'active':'' }}" href="{{ route('admin.orders') }}"><i>🛒</i><span>سفارش‌ها</span></a>
      <a class="{{ request()->routeIs('admin.quotes*')?'active':'' }}" href="{{ route('admin.quotes') }}"><i>☏</i><span>استعلام‌ها و CRM</span></a>
      @endif
      @if(in_array($role,['super_admin','admin','content']))
      <a class="{{ request()->routeIs('admin.content*')?'active':'' }}" href="{{ route('admin.content') }}"><i>✎</i><span>محتوا و مقالات</span></a>
      @endif
      @if($role==='super_admin')
      <a class="{{ request()->routeIs('admin.settings*')?'active':'' }}" href="{{ route('admin.settings') }}"><i>⚙</i><span>کاربران و تنظیمات</span></a>
      @endif
      <a href="/" target="_blank"><i>↗</i><span>مشاهده سایت</span></a>
    </nav>

    <div class="admin-support-card">
      <span>🎧</span><b>پشتیبانی مدیران</b><small>برای مسائل فنی پنل با تیم پشتیبانی در تماس باشید.</small><a href="{{ route('contact') }}">تماس با پشتیبانی</a>
    </div>

    <form class="admin-logout" method="post" action="{{ route('admin.logout') }}">@csrf<button>↪ خروج از حساب</button></form>
  </aside>

  <section class="admin-main">
    <header class="admin-top">
      <button class="admin-menu" id="adminMenu">☰</button>
      <div class="admin-search"><span>⌕</span><input placeholder="جستجو در محصولات، سفارش‌ها، مشتریان..."><kbd>Ctrl + K</kbd></div>
      <div class="admin-top-spacer"></div>
      <div class="admin-date"><span>▣</span><div><small>امروز</small><b>{{ jdate_fa(now(),'l j F Y') }}</b></div></div>
      <button class="admin-icon-btn">♧</button>
      <button class="admin-icon-btn">◫</button>
    </header>

    <div class="admin-page-head">
      <div><h1>@yield('heading','داشبورد')</h1><p>@yield('subheading','مدیریت یکپارچه فولادینو')</p></div>
      <div class="admin-page-actions">@yield('actions')</div>
    </div>

    @if(session('success'))<div class="flash success admin-flash">{{ session('success') }}</div>@endif
    @if(session('error'))<div class="flash error admin-flash">{{ session('error') }}</div>@endif
    @if(isset($errors) && $errors->any())<div class="flash error admin-flash">{{ $errors->first() }}</div>@endif

    <div class="admin-content">@yield('content')</div>
  </section>
</div>
<script src="{{ asset('js/app.js?v=14050702') }}"></script>
</body>
</html>
