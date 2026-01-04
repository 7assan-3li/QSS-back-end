@extends('layouts.app')

@section('content')
    <link rel="stylesheet" href="{{ asset('css/services/show.css') }}">

    <div class="service-show">

        <!-- Header -->
        <div class="service-header">
            <div>
                <h1>{{ $service->name }}</h1>
                <p>{{ $service->category->name ?? 'بدون تصنيف' }}</p>
            </div>

            <a href="{{ route('services.index') }}" class="back-btn">رجوع</a>
        </div>

        <!-- Main Info -->
        <div class="info-grid">

            <div class="info-card">
                <span>مقدم الخدمة</span>
                <strong>{{ $service->provider->name ?? '-' }}</strong>
            </div>

            <div class="info-card">
                <span>السعر</span>
                <strong>{{ $service->price }} $</strong>
            </div>

            <div class="info-card">
                <span>الحالة</span>
                <strong>{{ ucfirst($service->status) }}</strong>
            </div>

            <div class="info-card">
                <span>متاحة</span>
                <strong class="{{ $service->is_available ? 'success' : 'danger' }}">
                    {{ $service->is_available ? 'نعم' : 'لا' }}
                </strong>
            </div>

            <div class="info-card">
                <span>نشطة</span>
                <strong class="{{ $service->is_active ? 'info' : 'dark' }}">
                    {{ $service->is_active ? 'نعم' : 'لا' }}
                </strong>
            </div>

            <div class="info-card">
                <span>التقييم</span>
                <strong>{{ $service->average_rating }}/5</strong>
            </div>

            <div class="info-card">
                <span>الخدمة الأب</span>
                <strong>{{ $service->parent->name ?? '—' }}</strong>
            </div>

            <div class="info-card">
                <span>تسعير حسب المسافة</span>
                <strong>
                    {{ $service->distance_based_price ? 'نعم' : 'لا' }}
                </strong>
            </div>

            @if ($service->distance_based_price)
                <div class="info-card">
                    <span>السعر لكل كم</span>
                    <strong>{{ $service->price_per_km }} $</strong>
                </div>
            @endif

        </div>

        <!-- Description -->
        <div class="description-card">
            <h3>وصف الخدمة</h3>
            <p>{{ $service->description ?? 'لا يوجد وصف' }}</p>
        </div>

        <!-- Children Services -->
        @if ($service->children->isNotEmpty())
            <div class="children-card">
                <h3>الخدمات الفرعية</h3>

                <div class="children-grid">
                    @foreach ($service->children as $child)
                        <div class="child-item">
                            <h4>{{ $child->name }}</h4>
                            <span>{{ $child->price }} $</span>
                            <a href="{{ route('services.show', $child->id) }}">عرض</a>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif

    </div>
@endsection
