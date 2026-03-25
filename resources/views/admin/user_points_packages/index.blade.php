@extends('layouts.app')

@section('title', 'طلبات شحن النقاط')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/admin/user_points_packages.css') }}">
@endsection

@section('content')
    <div class="page-header">
        <div>
            <h1>💰 طلبات شحن النقاط</h1>
            <p>مراجعة طلبات المستخدمين لشحن أرصدتهم عبر الباقات</p>
        </div>
    </div>

    <div class="requests-table-container">
        <table class="requests-table">
            <thead>
                <tr>
                    <th>المستخدم</th>
                    <th>الباقة</th>
                    <th>المبلغ</th>
                    <th>رقم السند</th>
                    <th>تاريخ الطلب</th>
                    <th>الحالة</th>
                    <th>الإجراءات</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($subscriptions as $sub)
                    <tr>
                        <td>
                            <strong>{{ $sub->user->name }}</strong><br>
                            <small>{{ $sub->user->email }}</small>
                        </td>
                        <td>{{ $sub->package->name }}</td>
                        <td>{{ number_format($sub->package->price, 2) }} ر.س</td>
                        <td><code>{{ $sub->bond_number }}</code></td>
                        <td>{{ $sub->created_at->format('Y-m-d H:i') }}</td>
                        <td>
                            <span class="status-label status-{{ $sub->status }}">
                                @if($sub->status == 'pending') قيد الانتظار
                                @elseif($sub->status == 'approved') مقبول
                                @else مرفوض @endif
                            </span>
                        </td>
                        <td>
                            <a href="{{ route('admin.user-points-packages.show', $sub->id) }}" class="btn-detail">
                                التفاصيل
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" style="text-align: center; padding: 50px; color: #6b7280;">لا توجد طلبات شحن حالياً</td>
                    </tr>
                @private @endif
            </tbody>
        </table>

        <div style="margin-top: 20px;">
            {{ $subscriptions->links() }}
        </div>
    </div>
@endsection
