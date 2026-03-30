@extends('layouts.app')

@section('title', 'تفاصيل طلب الاشتراك')

@section('content')
    <link rel="stylesheet" href="{{ asset('css/user_verification_packages/show.css') }}">

    <!-- Header -->
    <div class="page-header">
        <div>
            <h1>تفاصيل طلب اشتراك المستخدم</h1>
            <p>مراجعة المرفقات ورقم السند والموافقة على الطلب أو رفضه</p>
        </div>

        <div class="header-actions">
            <a href="{{ route('user-verification-packages.index') }}" class="btn-back">رجوع</a>
            
            @if($userPackage->status === \App\constant\BondStatus::PENDING)
                <form action="{{ route('user-verification-packages.approve', $userPackage->id) }}" method="POST" class="form-inline" onsubmit="return confirm('هل أنت متأكد من الموافقة على هذا الطلب؟');">
                    @csrf
                    @method('PATCH')
                    <button type="submit" class="btn-approve">موافقة على الطلب</button>
                </form>

                <form action="{{ route('user-verification-packages.reject', $userPackage->id) }}" method="POST" class="form-inline" onsubmit="return confirm('هل أنت متأكد من رفض هذا الطلب؟');">
                    @csrf
                    @method('PATCH')
                    <button type="submit" class="btn-reject">رفض الطلب</button>
                </form>
            @endif
        </div>
    </div>

    <!-- Details -->
    <div class="details-card">

        <!-- User Info -->
        <div class="info-section">
            <h3>معلومات المستخدم</h3>
            <div class="info-grid">
                <div class="info-item">
                    <h4>الاسم</h4>
                    <p>{{ $userPackage->user->name ?? 'مستخدم محذوف' }}</p>
                </div>
                <div class="info-item">
                    <h4>البريد الإلكتروني</h4>
                    <p>{{ $userPackage->user->email ?? 'لا يوجد' }}</p>
                </div>
                <div class="info-item">
                    <h4>تاريخ تقديم الطلب</h4>
                    <p>{{ $userPackage->created_at->format('Y-m-d H:i') }}</p>
                </div>
            </div>
        </div>

        <!-- Package Info -->
        <div class="info-section">
            <h3>تفاصيل الباقة المطلوبة</h3>
            <div class="info-grid">
                <div class="info-item">
                    <h4>اسم الباقة</h4>
                    <p>{{ $userPackage->verificationPackage->name ?? 'باقة محذوفة' }}</p>
                </div>
                <div class="info-item">
                    <h4>السعر</h4>
                    <p>{{ $userPackage->verificationPackage ? number_format($userPackage->verificationPackage->price, 2) . ' ر.س' : 'غير متوفر' }}</p>
                </div>
                <div class="info-item">
                    <h4>المدة</h4>
                    <p>{{ $userPackage->verificationPackage->duration_days ?? 'غير متوفر' }} يوم</p>
                </div>
            </div>
        </div>

        <!-- Request Status and Payment -->
        <div class="info-section" style="border-bottom: none; padding-bottom: 0;">
            <h3>معلومات الطلب والدفع</h3>
            <div class="info-grid">
                <div class="info-item">
                    <h4>الحالة</h4>
                    @if($userPackage->status === \App\constant\BondStatus::PENDING)
                        <span class="badge badge-pending">قيد الانتظار</span>
                    @elseif($userPackage->status === \App\constant\BondStatus::APPROVED)
                        <span class="badge badge-approved">تمت الموافقة</span>
                    @elseif($userPackage->status === \App\constant\BondStatus::REJECTED)
                        <span class="badge badge-rejected">مرفوض</span>
                    @else
                        <span class="badge">{{ $userPackage->status }}</span>
                    @endif
                </div>

                @if($userPackage->admin)
                    <div class="info-item">
                        <h4>بواسطة أدمن</h4>
                        <p>{{ $userPackage->admin->name }}</p>
                    </div>
                @endif

                <div class="info-item">
                    <h4>رقم السند التحويلي</h4>
                    <p style="font-family: monospace; font-size: 18px; color: #2563eb;">{{ $userPackage->number_bond }}</p>
                </div>
            </div>

            @if($userPackage->image_bond)
                <div style="margin-top: 30px;">
                    <h4 style="font-size: 13px; color: #6b7280; margin-bottom: 8px;">صورة السند / المرفق</h4>
                    <div class="bond-container">
                        <a href="{{ asset('storage/' . $userPackage->image_bond) }}" target="_blank" title="اضغط لتكبير الصورة">
                            <img src="{{ asset('storage/' . $userPackage->image_bond) }}" class="bond-image" alt="صورة السند" style="max-height: 400px; border-radius: 8px; box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);">
                        </a>
                    </div>
                </div>
            @endif
        </div>

    </div>
@endsection
