@extends('layouts.app')

@section('content')
<link rel="stylesheet" href="{{ asset('css/requests/index.css') }}">

<div class="page-container">

    {{-- Breadcrumb --}}
    <div class="breadcrumb">
        <a href="{{ route('dashboard') }}">الرئيسية</a>
        <span>/</span>
        الطلبات
    </div>

    {{-- Stats --}}
    <div class="stats-grid">
        <a href="{{ route('requests.index') }}" class="stat-card">
            <h3>{{ $stats['total'] }}</h3>
            <p>كل الطلبات</p>
        </a>

        <a href="{{ route('requests.index', ['status' => 'pending']) }}" class="stat-card warning">
            <h3>{{ $stats['pending'] }}</h3>
            <p>قيد التنفيذ</p>
        </a>

        <a href="{{ route('requests.index', ['status' => 'completed']) }}" class="stat-card success">
            <h3>{{ $stats['completed'] }}</h3>
            <p>مكتملة</p>
        </a>

        <a href="{{ route('requests.index', ['commission' => 'unpaid']) }}" class="stat-card danger">
            <h3>{{ $stats['unpaid'] }}</h3>
            <p>عمولة غير مدفوعة</p>
        </a>
    </div>

    {{-- Cards --}}
    <div class="cards-grid">
        @forelse ($requests as $request)

            @php
                $commission = $request->total_price * 0.10;
            @endphp

            <div class="request-card">

                <div class="card-top">
                    <span class="status {{ $request->status }}">
                        {{ $request->status }}
                    </span>
                    <span class="id">#{{ $request->id }}</span>
                </div>

                <h4>{{ $request->user->name }}</h4>

                <div class="services">
                    @foreach ($request->services as $service)
                        <div class="service">
                            {{ $service->name }} × {{ $service->pivot->quantity }}
                            @if($service->pivot->is_main)
                                <span class="main">رئيسية</span>
                            @endif
                        </div>
                    @endforeach
                </div>

                <div class="prices">
                    <div>
                        <span>الإجمالي</span>
                        <strong>{{ number_format($request->total_price,2) }} ر.ي</strong>
                    </div>

                    <div>
                        <span>العمولة (10%)</span>
                        <strong>{{ number_format($commission,2) }} ر.ي</strong>
                    </div>
                </div>

                <div class="commission">
                    @if($request->commission_paid)
                        <span class="paid">✔ مدفوعة</span>
                    @else
                        <span class="unpaid">✖ غير مدفوعة</span>
                    @endif
                </div>

                <div class="card-actions">
                    <a href="{{ route('requests.show', $request) }}">عرض التفاصيل</a>
                </div>

            </div>

        @empty
            <p class="empty">لا توجد طلبات</p>
        @endforelse
    </div>

    <div class="pagination">
        {{ $requests->links() }}
    </div>

</div>
@endsection
