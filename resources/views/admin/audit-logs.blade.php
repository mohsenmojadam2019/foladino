@extends('admin.layout')
@section('title','لاگ فعالیت‌ها')
@section('heading','لاگ فعالیت‌های مدیریتی')
@section('subheading','ردیابی تغییرات مهم در پنل و امور مالی')
@section('content')<section class="admin-card"><div class="admin-card-head"><div><h3>تاریخچه فعالیت‌ها</h3><p>این گزارش برای امنیت و پاسخ‌گویی حذف‌پذیر نیست.</p></div></div><div class="admin-table-wrap"><table class="admin-table"><thead><tr><th>کاربر</th><th>عملیات</th><th>موجودیت</th><th>IP</th><th>زمان</th></tr></thead><tbody>@forelse($logs as $log)<tr><td>{{ $log->user?->name ?: 'سیستم' }}</td><td><span class="status-badge contacted">{{ $log->action }}</span></td><td>{{ $log->entity_type ?: '—' }} {{ $log->entity_id ? '#'.fa_digits($log->entity_id) : '' }}</td><td>{{ $log->ip_address ?: '—' }}</td><td>{{ jdate_fa($log->created_at,'Y/m/d H:i') }}</td></tr>@empty<tr><td colspan="5" class="admin-empty">هنوز فعالیتی ثبت نشده است.</td></tr>@endforelse</tbody></table></div></section>@endsection
