@extends('layouts.app')

@section('title', 'طلبات اشتراك باقات التوثيق')

@section('content')
    <link rel="stylesheet" href="{{ asset('css/user_verification_packages/index.css') }}">

    <!-- Header -->
    <div class="page-header">
        <div>
            <h1>طلبات اشتراك الباقات</h1>
            <p>إدارة طلبات المستخدمين للاشتراك في باقات التوثيق</p>
        </div>
    </div>

    <!-- Stats -->
    <div class="stats-grid">
        <div class="stat-card">
            <h3>إجمالي الطلبات</h3>
            <span>{{ $userPackages->count() }}</span>
        </div>

        <div class="stat-card">
            <h3>قيد الانتظار</h3>
            <span>{{ $userPackages->where('status', \App\constant\BondStatus::PENDING)->count() }}</span>
        </div>
    </div>

    <!-- Table -->
    @if ($userPackages->count())
        <div class="table-container">
            <table class="custom-table">
                <thead>
                    <tr>
                        <th>المستخدم</th>
                        <th>الباقة</th>
                        <th>رقم السند</th>
                        <th>الحالة</th>
                        <th>تاريخ الطلب</th>
                        <th>الإجراء</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($userPackages as $request)
                        <tr>
                            <td>
                                <strong>{{ $request->user->name ?? 'مستخدم محذوف' }}</strong><br>
                                <small style="color:#6b7280">{{ $request->user->email ?? '' }}</small>
                            </td>
                            <td>{{ $request->verificationPackage->name ?? 'باقة محذوفة' }}</td>
                            <td>{{ $request->number_bond }}</td>
                            <td>
                                @if($request->status === \App\constant\BondStatus::PENDING)
                                    <span class="badge badge-pending">قيد الانتظار</span>
                                @elseif($request->status === \App\constant\BondStatus::APPROVED)
                                    <span class="badge badge-approved">مقبول</span>
                                @elseif($request->status === \App\constant\BondStatus::REJECTED)
                                    <span class="badge badge-rejected">مرفوض</span>
                                @else
                                    <span class="badge">{{ $request->status }}</span>
                                @endif
                            </td>
                            <td>{{ $request->created_at->format('Y-m-d') }}</td>
                            <td>
                                <a href="{{ route('user-verification-packages.show', $request->id) }}" class="btn-view">
                                    عرض التفاصيل
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @else
        <div class="empty-state">
            لا توجد طلبات اشتراك في الباقات حتى الآن
        </div>
    @endif
@endsection
