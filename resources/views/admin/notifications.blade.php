@extends('admin.layout')
@section('title','اعلان‌ها')
@section('heading','اعلان‌های مدیریتی')
@section('subheading','هشدارهای سفارش، پرداخت، موجودی و فعالیت‌های مهم')
@section('content')<section class="admin-card"><div class="admin-card-head"><div><h3>مرکز اعلان‌ها</h3><p>{{ fa_digits($notifications->whereNull('read_at')->count()) }} اعلان خوانده‌نشده</p></div></div><div class="notification-list">@forelse($notifications as $n)<article class="notification-item {{ $n->read_at?'read':'' }}"><span class="notification-icon {{ $n->type }}">{{ $n->type==='warning'?'!':($n->type==='success'?'✓':'i') }}</span><div><b>{{ $n->title }}</b><p>{{ $n->body }}</p><small>{{ jdate_fa($n->created_at,'Y/m/d H:i') }}</small></div>@if(!$n->read_at)<form method="post" action="{{ route('admin.notifications.read',$n) }}">@csrf @method('put')<button class="icon-btn">خوانده شد</button></form>@endif</article>@empty<div class="admin-empty">اعلانی وجود ندارد.</div>@endforelse</div></section>@endsection
