<!doctype html>
<html lang="fa" dir="rtl">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>@yield('title','پنل سازمانی') | فولادینو</title>
  <link rel="icon" href="{{ $siteSettings['logo_image'] ?? '/images/logo-mark.svg' }}">
  <link rel="stylesheet" href="/css/app.css">
</head>
<body class="admin-body">
@php($role = auth()->user()->role)
<div class="admin-shell">
  <aside class="admin-sidebar">
    <a class="brand admin-brand" href="{{ route('admin.dashboard') }}">
      <img src="{{ $siteSettings['logo_image'] ?? '/images/logo-mark.svg' }}">
      <span><strong>فولادینو</strong><small>پنل سازمانی</small></span>
    </a>
    <div class="admin-profile">
      <div class="avatar">{{ mb_substr(auth()->user()->name,0,1) }}</div>
      <div>
        <b>{{ auth()->user()->name }}</b>
        <small>{{ ['super_admin'=>'مدیر ارشد','admin'=>'مدیر','pricing'=>'مدیر قیمت‌گذاری','content'=>'مدیر محتوا'][$role] ?? $role }}</small>
      </div>
    </div>
    <nav class="admin-nav">
      <a class="{{ request()->routeIs('admin.dashboard')?'active':'' }}" href="{{ route('admin.dashboard') }}">⌂ <span>داشبورد مدیریتی</span></a>
      @if(in_array($role,['super_admin','admin']))
        <a class="{{ request()->routeIs('admin.catalog*')?'active':'' }}" href="{{ route('admin.catalog') }}">▦ <span>کاتالوگ و محصولات</span></a>
      @endif
      @if(in_array($role,['super_admin','admin','pricing']))
        <a class="{{ request()->routeIs('admin.pricing*')?'active':'' }}" href="{{ route('admin.pricing') }}">⌁ <span>مدیریت قیمت‌ها</span></a>
      @endif
      @if(in_array($role,['super_admin','admin']))
        <a class="{{ request()->routeIs('admin.orders*')?'active':'' }}" href="{{ route('admin.orders') }}">▤ <span>سفارش‌های آنلاین</span></a>
        <a class="{{ request()->routeIs('admin.quotes*')?'active':'' }}" href="{{ route('admin.quotes') }}">☏ <span>استعلام‌ها و CRM</span></a>
      @endif
      @if(in_array($role,['super_admin','admin','content']))
        <a class="{{ request()->routeIs('admin.content*')?'active':'' }}" href="{{ route('admin.content') }}">✎ <span>محتوا و مقالات</span></a>
      @endif
      @if($role==='super_admin')
        <a class="{{ request()->routeIs('admin.settings*')?'active':'' }}" href="{{ route('admin.settings') }}">⚙ <span>تنظیمات سازمانی</span></a>
      @endif
    </nav>
    <div class="sidebar-bottom">
      <a href="/" target="_blank">↗ مشاهده وب‌سایت</a>
      <form method="post" action="{{ route('admin.logout') }}">@csrf<button>خروج از حساب</button></form>
    </div>
  </aside>
  <section class="admin-main">
    <header class="admin-top">
      <button class="admin-menu" id="adminMenu">☰</button>
      <div><h1>@yield('heading','داشبورد')</h1><p>@yield('subheading','مدیریت یکپارچه عملیات فولادینو')</p></div>
      <div class="admin-top-actions">
        <div class="jalali-clock"><small>امروز</small><b>{{ jdate_fa(now(),'Y/m/d') }}</b></div>
        <span class="role-pill">{{ ['super_admin'=>'مدیر ارشد','admin'=>'مدیر','pricing'=>'قیمت‌گذاری','content'=>'محتوا'][$role] ?? $role }}</span>
      </div>
    </header>
    @if(session('success'))<div class="flash success admin-flash">{{ session('success') }}</div>@endif
    @if(session('error'))<div class="flash error admin-flash">{{ session('error') }}</div>@endif
    @if(isset($errors) && $errors->any())<div class="flash error admin-flash">{{ $errors->first() }}</div>@endif
    <div class="admin-content">@yield('content')</div>
  </section>
</div>
<script src="/js/app.js"></script>
</body>
</html>
