@extends('layouts.app')

@section('title', 'تفاصيل باقة التوثيق')

@section('content')
    <link rel="stylesheet" href="{{ asset('css/verification_packages/show.css') }}">

    <!-- Header -->
    <div class="page-header">
        <div>
            <h1>{{ $package->name }}</h1>
            <p>تفاصيل الباقة وتعديل بياناتها</p>
        </div>

        <div class="header-actions">
            <a href="{{ route('verification-packages.index') }}" class="btn-back">رجوع</a>
            <a href="{{ route('verification-packages.edit', $package->id) }}" class="btn-edit">تعديل</a>
            
            <form action="{{ route('verification-packages.destroy', $package->id) }}" method="POST" class="delete-form" onsubmit="return confirm('هل أنت متأكد من حذف هذه الباقة؟');">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn-delete">حذف</button>
            </form>
        </div>
    </div>

    <!-- Details -->
    <div class="details-card">

        <div class="info-row">
            <div class="info-item">
                <h4>اسم الباقة</h4>
                <p>{{ $package->name }}</p>
            </div>

            <div class="info-item">
                <h4>السعر</h4>
                <p>{{ number_format($package->price, 2) }} ر.س</p>
            </div>

            <div class="info-item">
                <h4>المدة</h4>
                <p>{{ $package->duration_days }} يوم</p>
            </div>

            <div class="info-item">
                <h4>الحالة</h4>
                @if($package->is_active)
                    <span class="badge badge-active">نشط (متاحة للمستخدمين)</span>
                @else
                    <span class="badge badge-inactive">غير نشط (غير متاحة)</span>
                @endif
            </div>

            <div class="info-item">
                <h4>تاريخ الإنشاء</h4>
                <p>{{ $package->created_at->format('Y-m-d') }}</p>
            </div>
        </div>

        <div class="description-section">
            <h4>الوصف والمميزات</h4>
            @if ($package->description)
                <div class="description-content">
                    {!! nl2br(e($package->description)) !!}
                </div>
            @else
                <div class="description-content" style="color:#9ca3af; font-style:italic;">
                    لا يوجد وصف لهذه الباقة
                </div>
            @endif
        </div>
    </div>
@endsection
