@extends('layouts.app')

@section('title', 'باقات النقاط')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/admin/points_packages.css') }}">
@endsection

@section('content')
    <div class="page-header">
        <div>
            <h1>💎 باقات النقاط</h1>
            <p>إدارة الباقات المتاحة للمستخدمين للشراء</p>
        </div>

        <a href="{{ route('admin.points-packages.create') }}" class="btn-add">
            ➕ إضافة باقة جديدة
        </a>
    </div>

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

    @if ($packages->count())
        <div class="packages-grid">
            @foreach ($packages as $package)
                <div class="package-card {{ !$package->is_active ? 'inactive' : '' }}">
                    <span class="status-badge {{ $package->is_active ? 'status-active' : 'status-inactive' }}">
                        {{ $package->is_active ? 'نشطة' : 'معطلة' }}
                    </span>

                    <div class="package-icon">💎</div>
                    <h3>{{ $package->name }}</h3>
                    
                    <div class="package-points">
                        {{ number_format($package->points) }} نقطه
                    </div>

                    @if ($package->bonus_points > 0)
                        <div class="package-bonus">
                            + {{ number_format($package->bonus_points) }} نقاط إضافية 🎁
                        </div>
                    @endif

                    <div class="package-price">
                        السعر: {{ number_format($package->price, 2) }} ر.س
                    </div>

                    <div class="card-actions">
                        <a href="{{ route('admin.points-packages.edit', $package->id) }}" class="btn-edit">
                            تعديل
                        </a>

                        <form action="{{ route('admin.points-packages.destroy', $package->id) }}" method="POST" onsubmit="return confirm('هل أنت متأكد من حذف هذه الباقة؟')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn-delete">حذف</button>
                        </form>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <div class="empty-state" style="text-align: center; padding: 100px; background: white; border-radius: 20px; color: #6b7280;">
            <div style="font-size: 50px; margin-bottom: 20px;">📦</div>
            <h3>لا توجد باقات نقاط حالياً</h3>
            <p>ابدأ بإضافة أول باقة ليتمكن المستخدمون من شرائها</p>
        </div>
    @endif
@endsection
