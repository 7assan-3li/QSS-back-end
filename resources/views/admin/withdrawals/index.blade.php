@extends('layouts.app')

@section('title', 'طلبات السحب')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/admin/user_points_packages.css') }}">
@endsection

@section('content')
    <div class="page-header">
        <div>
            <h1>💸 طلبات سحب الأرباح</h1>
            <p>مراجعة طلبات مزودي الخدمات لتحويل أرباحهم (نقاط مدفوعة) إلى مبالغ نقدية</p>
        </div>
    </div>

    <div class="requests-table-container">
        <table class="requests-table">
            <thead>
                <tr>
                    <th>المزود</th>
                    <th>المبلغ المطلوب</th>
                    <th>تاريخ الطلب</th>
                    <th>الحالة</th>
                    <th>الإجراءات</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($withdrawals as $w)
                    <tr>
                        <td>
                            <strong>{{ $w->user->name }}</strong><br>
                            <small>{{ $w->user->email }}</small>
                        </td>
                        <td>{{ number_format($w->amount, 2) }} ر.س</td>
                        <td>{{ $w->created_at->format('Y-m-d H:i') }}</td>
                        <td>
                            <span class="status-label status-{{ $w->status }}">
                                @if($w->status == 'pending') قيد الانتظار
                                @elseif($w->status == 'approved') تم التحويل
                                @else مرفوض @endif
                            </span>
                        </td>
                        <td>
                            <a href="{{ route('admin.withdrawals.show', $w->id) }}" class="btn-detail">
                                معالجة الطلب
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" style="text-align: center; padding: 50px; color: #6b7280;">لا توجد طلبات سحب حالياً</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <div style="margin-top: 20px;">
            {{ $withdrawals->links() }}
        </div>
    </div>
@endsection
