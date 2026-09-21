@extends('admin.layout')
@section('title','تنظیمات')
@section('heading','کاربران و تنظیمات')
@section('subheading','هویت برند، اطلاعات تماس و سطح دسترسی تیم')
@section('content')
<div class="settings-tabs">
  <button class="tab-btn active" data-tab="generalSettings">تنظیمات عمومی</button>
  <button class="tab-btn" data-tab="brandSettings">هویت بصری</button>
  <button class="tab-btn" data-tab="teamSettings">کاربران سازمانی</button>
</div>

<section class="admin-card tab-pane active" id="generalSettings">
  <div class="settings-section-head"><div><h3>اطلاعات عمومی سایت</h3><p>اطلاعات تماس و آمار اصلی نمایش‌داده‌شده در وب‌سایت</p></div></div>
  <form class="settings-form" method="post" action="{{ route('admin.settings.update') }}">@csrf @method('PUT')
    <div class="settings-grid-form">
      <label>نام سایت<input name="site_name" value="{{ $settings['site_name']??'فولادینو' }}"></label>
      <label>شماره اصلی<input name="phone" value="{{ $settings['phone']??'' }}"></label>
      <label>شماره پشتیبانی<input name="support_phone" value="{{ $settings['support_phone']??'' }}"></label>
      <label>ایمیل<input name="email" value="{{ $settings['email']??'' }}"></label>
      <label class="wide">آدرس<textarea name="address" rows="3">{{ $settings['address']??'' }}</textarea></label>
      <label>تعداد کارخانه‌ها<input name="factories_count" value="{{ $settings['factories_count']??'' }}"></label>
      <label>مشتریان فعال<input name="active_customers" value="{{ $settings['active_customers']??'' }}"></label>
      <label>تأمین سالانه<input name="annual_tons" value="{{ $settings['annual_tons']??'' }}"></label>
    </div>
    <button class="btn btn-primary">ذخیره تنظیمات عمومی</button>
  </form>
</section>

<section class="admin-card tab-pane" id="brandSettings">
  <div class="settings-section-head"><div><h3>هویت بصری و تصاویر</h3><p>متن Hero و مسیر assetهای اصلی وب‌سایت</p></div></div>
  <form class="settings-form" method="post" action="{{ route('admin.settings.update') }}">@csrf @method('PUT')
    <div class="settings-grid-form">
      <label class="wide">عنوان Hero<input name="hero_title" value="{{ $settings['hero_title']??'' }}"></label>
      <label class="wide">زیرعنوان Hero<textarea name="hero_subtitle" rows="3">{{ $settings['hero_subtitle']??'' }}</textarea></label>
      <label>مسیر لوگو<input name="logo_image" value="{{ $settings['logo_image']??'/images/logo-mark.svg' }}"></label>
      <label>تصویر Hero<input name="hero_image" value="{{ $settings['hero_image']??'/images/hero-steel.svg' }}"></label>
      <label>تصویر پروژه<input name="project_image" value="{{ $settings['project_image']??'/images/project.svg' }}"></label>
      <label>نقشه ارسال<input name="delivery_map_image" value="{{ $settings['delivery_map_image']??'/images/iran-map.svg' }}"></label>
      <label>تصویر CTA<input name="cta_image" value="{{ $settings['cta_image']??'/images/coil.svg' }}"></label>
    </div>
    <button class="btn btn-primary">ذخیره هویت بصری</button>
  </form>
</section>

<section class="admin-card tab-pane" id="teamSettings">
  <div class="settings-team-grid">
    <div>
      <div class="admin-card-head"><div><h3>کاربران سازمانی</h3><p>{{ fa_digits($users->count()) }} حساب کاربری</p></div></div>
      <div class="user-list user-list-v2">
        @foreach($users as $u)
        <div>
          <span class="avatar">{{ mb_substr($u->name,0,1) }}</span>
          <div><b>{{ $u->name }}</b><small>{{ $u->email }}</small><small>{{ ['super_admin'=>'مدیر ارشد','admin'=>'مدیر','pricing'=>'قیمت‌گذاری','content'=>'محتوا'][$u->role] ?? $u->role }} · آخرین ورود: {{ jdate_fa($u->last_login_at,'Y/m/d H:i') }}</small></div>
          <form method="post" action="{{ route('admin.users.toggle',$u) }}">@csrf @method('PUT')<button class="status-badge {{ $u->is_active?'won':'lost' }}">{{ $u->is_active?'فعال':'غیرفعال' }}</button></form>
        </div>
        @endforeach
      </div>
    </div>

    <form class="stack-form team-create-form" method="post" action="{{ route('admin.users.store') }}">@csrf
      <div><h3>افزودن عضو تیم</h3><p class="admin-form-help">حساب سازمانی جدید با سطح دسترسی مشخص ایجاد کنید.</p></div>
      <label>نام و نام خانوادگی<input name="name" required></label>
      <label>ایمیل سازمانی<input name="email" type="email" required></label>
      <label>رمز عبور<input name="password" type="password" required></label>
      <label>نقش<select name="role"><option value="admin">مدیر</option><option value="pricing">مدیر قیمت‌گذاری</option><option value="content">مدیر محتوا</option><option value="super_admin">مدیر ارشد</option></select></label>
      <button class="btn btn-primary">ایجاد کاربر</button>
    </form>
  </div>
</section>
@endsection