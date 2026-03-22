@extends('layouts.app')

@section('title', 'باقات التوثيق')

@section('content')
    <link rel="stylesheet" href="{{ asset('css/verification_packages/index.css') }}">

    <!-- Header -->
    <div class="page-header">
        <div>
            <h1>باقات التوثيق</h1>
            <p>إدارة الباقات الخاصة بتوثيق الحسابات في النظام</p>
        </div>

        <a href="{{ route('verification-packages.create') }}" class="btn-add">
            ➕ إضافة باقة جديدة
        </a>
    </div>

    <!-- Stats -->
    <div class="stats-grid">
        <div class="stat-card">
            <h3>إجمالي الباقات</h3>
            <span>{{ $packages->count() }}</span>
        </div>

        <div class="stat-card">
            <h3>الباقات النشطة</h3>
            <span>{{ $packages->where('is_active', true)->count() }}</span>
        </div>
    </div>

    <!-- Grid -->
    @if ($packages->count())
        <div class="packages-grid">
            @foreach ($packages as $package)
                <div class="package-card">

                    <h3>
                        {{ $package->name }}
                        @if($package->is_active)
                            <span class="badge badge-active">نشط</span>
                        @else
                            <span class="badge badge-inactive">غير نشط</span>
                        @endif
                    </h3>
                    
                    <div class="package-price">
                        {{ number_format($package->price, 2) }} ر.س
                    </div>

                    <p>
                        {{ Str::limit($package->description, 100) ?? 'لا يوجد وصف' }}
                    </p>

                    <div class="package-details">
                        <div>
                            <strong>المدة: </strong> {{ $package->duration_days }} يوم
                        </div>
                    </div>

                    <div class="card-actions">
                        <a href="{{ route('verification-packages.show', $package->id) }}" class="btn-view">
                            عرض التفاصيل
                        </a>

                        <a href="{{ route('verification-packages.edit', $package->id) }}" class="btn-edit">
                            تعديل
                        </a>
                    </div>

                </div>
            @endforeach
        </div>
    @else
        <div class="empty-state">
            لا توجد باقات توثيق مضافة حتى الآن
        </div>
    @endif
@endsection
