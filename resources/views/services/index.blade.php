@extends('layouts.app')

@section('content')
<link rel="stylesheet" href="{{ asset('css/services/index.css') }}">

<div class="services-container">

    <!-- ===== Reports ===== -->
    <div class="stats-grid">

        <div class="stat-card">
            <h4>إجمالي الخدمات</h4>
            <span>{{ $stats['total'] }}</span>
        </div>

        <div class="stat-card success">
            <h4>المتاحة</h4>
            <span>{{ $stats['available'] }}</span>
        </div>

        <div class="stat-card danger">
            <h4>غير المتاحة</h4>
            <span>{{ $stats['unavailable'] }}</span>
        </div>

        <div class="stat-card info">
            <h4>النشطة</h4>
            <span>{{ $stats['active'] }}</span>
        </div>

        <div class="stat-card primary">
            <h4>خدمات الاجتماعات</h4>
            <span>{{ $stats['meeting_service'] }}</span>
        </div>

        <div class="stat-card primary">
            <h4>خدمات مخصصة</h4>
            <span>{{ $stats['custom_service'] }}</span>
        </div>

    </div>

    <!-- ===== Table ===== -->
    <div class="table-card">
        <h2>إدارة الخدمات</h2>

        <table>
            <thead>
                <tr>
                    <th>الخدمة</th>
                    <th>المقدم</th>
                    <th>التصنيف</th>
                    <th>السعر</th>
                    <th>متاحة</th>
                    <th>الحالة</th>
                    <th>التحكم</th>
                </tr>
            </thead>

            <tbody>
                @forelse ($services as $service)
                    <tr>
                        <td data-label="الخدمة">{{ $service->name }}</td>
                        <td data-label="المقدم">{{ $service->provider->name ?? '-' }}</td>
                        <td data-label="التصنيف">{{ $service->category->name ?? '-' }}</td>
                        <td data-label="السعر">{{ $service->price }}$</td>

                        <td data-label="متاحة">
                            <span class="badge {{ $service->is_available ? 'success' : 'danger' }}">
                                {{ $service->is_available ? 'نعم' : 'لا' }}
                            </span>
                        </td>

                        <td data-label="الحالة">
                            <span class="badge {{ $service->is_active ? 'info' : 'dark' }}">
                                {{ $service->is_active ? 'نشطة' : 'موقوفة' }}
                            </span>
                        </td>

                        <td data-label="التحكم" class="actions">
                            <a href="{{ route('services.show', $service->id) }}">عرض</a>
                            <a href="{{ route('services.edit', $service->id) }}">تعديل</a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="empty">لا توجد خدمات</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

</div>
@endsection
