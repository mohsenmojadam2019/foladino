@extends('admin.layout')
@section('title','سفارش‌های آنلاین')
@section('heading','سفارش‌های آنلاین')
@section('subheading','پیگیری سفارش‌ها و وضعیت پرداخت')
@section('content')
<section class="admin-card">
<div class="admin-card-head">
  <div><h3>فهرست سفارش‌ها</h3><p>{{ fa_digits($orders->count()) }} سفارش ثبت‌شده</p></div>
</div>
<div class="admin-list quote-list">
@forelse($orders as $o)
<div>
  <span>
    <b>#{{ fa_digits($o->id) }} · {{ $o->customer_name }}</b>
    <small>{{ $o->product?->name }} · {{ $o->mobile }} · {{ $o->city }}</small>
  </span>
  <strong>{{ money_fa($o->total_toman) }} تومان</strong>
  <em class="status-badge {{ $o->status==='paid' ? 'won' : ($o->status==='failed' ? 'lost' : 'new') }}">
    {{ ['pending'=>'در انتظار','payment_started'=>'ورود به درگاه','paid'=>'پرداخت‌شده','failed'=>'ناموفق','cancelled'=>'لغوشده'][$o->status] ?? $o->status }}
  </em>
  <small>{{ jdate_fa($o->created_at,'Y/m/d H:i') }}</small>
</div>
@empty
<div><span><b>هنوز سفارشی ثبت نشده است.</b></span></div>
@endforelse
</div>
</section>
@endsection
