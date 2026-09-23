@extends('admin.layout')
@section('title','گزارش‌ها')
@section('heading','گزارش‌های مدیریتی')
@section('subheading','تحلیل فروش، سفارش‌ها، قیمت و عملکرد عملیاتی')
@section('content')
@php($paid=$orders->where('status','paid'))
@section('actions')<a class="btn btn-primary" href="{{ route('admin.reports.export','orders') }}">خروجی سفارش‌ها</a><a class="btn btn-light" href="{{ route('admin.reports.export','products') }}">خروجی محصولات</a>@endsection
<div class="admin-page-kpis"><article><span>₮</span><div><small>درآمد پرداخت‌شده</small><b>{{ money_fa($paid->sum('total_toman')) }}</b></div></article><article><span>↗</span><div><small>تعداد سفارش</small><b>{{ fa_digits($orders->count()) }}</b></div></article><article><span>▤</span><div><small>محصول فعال</small><b>{{ fa_digits($products->count()) }}</b></div></article><article><span>☏</span><div><small>استعلام‌ها</small><b>{{ fa_digits($quotes->count()) }}</b></div></article></div>
<div class="admin-order-summary"><section class="admin-card"><div class="admin-card-head"><div><h3>عملکرد سفارش‌ها</h3><p>تفکیک وضعیت سفارش‌های ثبت‌شده</p></div></div><div class="order-status-bars">@foreach(['paid'=>'پرداخت‌شده','pending'=>'در انتظار','processing'=>'در حال آماده‌سازی','delivered'=>'تحویل‌شده','cancelled'=>'لغوشده'] as $key=>$label)<div><span>{{ $label }} <b>{{ fa_digits($orders->where('status',$key)->count()) }}</b></span><i><em style="width:{{ $orders->count()?round($orders->where('status',$key)->count()/$orders->count()*100):0 }}%"></em></i></div>@endforeach</div></section><section class="admin-card"><div class="admin-card-head"><div><h3>محصولات پرفروش</h3><p>بر اساس سفارش‌های ثبت‌شده</p></div></div><div class="admin-list">@foreach($products->take(6) as $p)<div><img src="{{ site_asset($p->image) }}" alt=""><span><b>{{ $p->name }}</b><small>{{ $p->factory?->name }}</small></span><strong>{{ money_fa($p->price) }}</strong></div>@endforeach</div></section></div>
@endsection
