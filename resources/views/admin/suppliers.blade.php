@extends('admin.layout')
@section('title','تأمین‌کنندگان')
@section('heading','تأمین‌کنندگان و کارخانه‌ها')
@section('subheading','مدیریت کارخانه‌ها، ظرفیت تأمین و محصولات قابل عرضه')
@section('content')<section class="admin-card"><div class="admin-card-head"><div><h3>شبکه تأمین فولادینو</h3><p>کارخانه‌ها و تأمین‌کنندگان فعال</p></div></div><div class="factory-admin-grid">@forelse($factories as $f)<div><img src="{{ site_asset($f->logo) }}" alt=""><b>{{ $f->name }}</b><small>{{ $f->province ?: '—' }} · {{ fa_digits($f->products_count) }} محصول</small><span class="status-badge won">فعال</span></div>@empty<div class="admin-empty">تأمین‌کننده‌ای ثبت نشده است.</div>@endforelse</div></section>@endsection
