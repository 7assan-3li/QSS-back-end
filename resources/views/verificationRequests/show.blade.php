@extends('layouts.app')

@section('content')

    <link rel="stylesheet" href="{{ asset('css/verificationRequests/show.css') }}">

    <div class="page-container">

        <h2 class="page-title">تفاصيل مزود الخدمة</h2>

        {{-- معلومات المزود --}}
        <div class="card">
            <h3>المعلومات الأساسية</h3>
            <p><strong>الاسم:</strong> {{ $provider->name }}</p>
            <p><strong>البريد:</strong> {{ $provider->email }}</p>
            <p><strong>رسالة الطلب:</strong> {{ $verificationRequest->content }}</p>
            <p><strong>التقييم:</strong> ⭐ {{ $provider->rating_avg }}</p>
            <p>
                <strong>حالة التوثيق:</strong>
                @if($provider->verification_provider)
                    <span class="badge success">موثق</span>
                @else
                    <span class="badge warning">غير موثق</span>
                @endif
            </p>
        </div>

        {{-- الإحصائيات --}}
        <div class="stats-grid">

            <div class="stat-box">
                <h4>عدد الخدمات</h4>
                <span>{{ $servicesCount }}</span>
            </div>

            <div class="stat-box">
                <h4>إجمالي الطلبات</h4>
                <span>{{ $totalRequests }}</span>
            </div>

            <div class="stat-box">
                <h4>الطلبات المكتملة</h4>
                <span>{{ $completedRequests }}</span>
            </div>

            <div class="stat-box {{ $complaintsCount > 0 ? 'danger' : 'success' }}">
                <h4>الشكاوى</h4>
                <span>{{ $complaintsCount }}</span>
            </div>

        </div>

        {{-- العمولة --}}
        <div class="card">
            <h3>العمولات</h3>
            <p>
                <strong>إعفاء من العمولة:</strong>
                {{ $provider->no_commission ? 'نعم' : 'لا' }}
            </p>
            <p><strong>طلبات غير مدفوعة:</strong> {{ $unpaidCommissionRequests }}</p>
            <p><strong>قيمة العمولة:</strong> {{ number_format($totalCommission, 2) }} $</p>
        </div>

        {{-- أزرار التحكم --}}
        @if(!$provider->verification_provider)
        <div class="actions">

            <form method="POST" action="{{ route('verification-requests.accept', $verificationRequest->id) }}">
                @csrf
                <button class="btn success">قبول التوثيق</button>
            </form>

            <form method="POST" action="{{ route('verification-requests.reject', $verificationRequest->id) }}">
                @csrf
                <button class="btn danger">رفض التوثيق</button>
            </form>

        </div>
        @endif
    </div>

@endsection