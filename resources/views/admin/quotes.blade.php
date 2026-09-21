@extends('admin.layout')
@section('title','استعلام‌ها و CRM')
@section('heading','استعلام‌ها و CRM')
@section('subheading','مدیریت سرنخ‌های فروش و پیگیری مذاکرات سازمانی')
@section('content')
@php
  $statusMap=['new'=>'جدید','contacted'=>'تماس گرفته','quoted'=>'قیمت داده شد','won'=>'موفق','lost'=>'ناموفق'];
@endphp

<div class="admin-page-kpis">
  <article><span>☏</span><div><small>کل استعلام‌ها</small><b>{{ fa_digits($quotes->count()) }}</b></div></article>
  <article><span>+</span><div><small>جدید</small><b>{{ fa_digits($quotes->where('status','new')->count()) }}</b></div></article>
  <article><span>⌁</span><div><small>در مذاکره</small><b>{{ fa_digits($quotes->whereIn('status',['contacted','quoted'])->count()) }}</b></div></article>
  <article><span>✓</span><div><small>موفق</small><b>{{ fa_digits($quotes->where('status','won')->count()) }}</b></div></article>
</div>

<div class="crm-toolbar">
  <div class="admin-table-search"><span>⌕</span><input data-crm-search placeholder="جستجوی مشتری، محصول یا موبایل..."></div>
  <span class="crm-help">وضعیت هر سرنخ را از داخل کارت تغییر دهید.</span>
</div>

<div class="crm-board crm-board-v2" data-crm-board>
  @foreach($statusMap as $status=>$label)
  <section class="crm-column" data-crm-column="{{ $status }}">
    <header>
      <div><span class="crm-dot {{ $status }}"></span><b>{{ $label }}</b></div>
      <strong>{{ fa_digits($quotes->where('status',$status)->count()) }}</strong>
    </header>

    <div class="crm-cards">
      @foreach($quotes->where('status',$status) as $q)
      <article class="crm-card" data-crm-text="{{ $q->name }} {{ $q->mobile }} {{ $q->product_name }} {{ $q->city }}">
        <div class="crm-card-head">
          <div class="mini-avatar">{{ mb_substr($q->name,0,1) }}</div>
          <div><b>{{ $q->name }}</b><small>{{ $q->mobile }}</small></div>
          <time>{{ jdate_fa($q->created_at,'m/d H:i') }}</time>
        </div>
        <div class="crm-card-product">
          <span>محصول</span><b>{{ $q->product_name ?: 'مشخص نشده' }}</b>
          <span>مقدار</span><b>{{ $q->amount ? fa_digits($q->amount).' تن' : '—' }}</b>
          <span>شهر</span><b>{{ $q->city ?: '—' }}</b>
        </div>
        @if($q->note)<p class="crm-note">{{ $q->note }}</p>@endif
        <form method="post" action="{{ route('admin.quotes.update',$q) }}">
          @csrf @method('PUT')
          <select name="status">
            @foreach($statusMap as $s=>$l)<option value="{{ $s }}" @selected($q->status===$s)>{{ $l }}</option>@endforeach
          </select>
          <textarea name="note" rows="2" placeholder="یادداشت پیگیری">{{ $q->note }}</textarea>
          <button class="btn btn-outline btn-sm">ذخیره پیگیری</button>
        </form>
      </article>
      @endforeach
    </div>
  </section>
  @endforeach
</div>
@endsection