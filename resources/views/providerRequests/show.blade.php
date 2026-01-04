@extends('layouts.app')

@section('content')
    <link rel="stylesheet" href="{{ asset('css/providerRequests/show.css') }}">

    <div class="request-show">

        <div class="header">
            <h1>طلب مزود خدمة</h1>
            <a href="{{ route('provider-requests.index') }}" class="back-btn">رجوع</a>
        </div>

        <!-- Info -->
        <div class="info-grid">

            <div class="info-card">
                <span>الاسم</span>
                <strong>{{ $providerRequest->name }}</strong>
            </div>

            <div class="info-card">
                <span>المستخدم</span>
                <strong>{{ $providerRequest->user->name }}</strong>
            </div>

            <div class="info-card">
                <span>الحالة</span>
                <strong class="status {{ $providerRequest->status }}">
                    {{ $providerRequest->status }}
                </strong>
            </div>

            <div class="info-card">
                <span>تمت المراجعة بواسطة</span>
                <strong>{{ $providerRequest->admin->name ?? '—' }}</strong>
            </div>

            <div class="info-card">
                <span>تاريخ الطلب</span>
                <strong>{{ $providerRequest->created_at->format('Y-m-d') }}</strong>
            </div>

        </div>

        <!-- Request Text -->
        <div class="message-card">
            <h3>تفاصيل الطلب</h3>
            <p>{{ $providerRequest->requestContent }}</p>
        </div>
        
        <!-- ID Card -->
        <div class="id-card">
            <h3>صورة الهوية</h3>
            <img src="{{ asset('storage/' . $providerRequest->id_card) }}" alt="ID Card">
        </div>

        <!-- Actions -->
        @if ($providerRequest->status === \App\constant\providerRequestStatus::PENDING)
            <div class="actions">
                <form method="POST" action="{{ route('provider-requests.update.status', $providerRequest->id) }}">
                    @csrf
                    @method('patch')
                    <input type="hidden" name="status" value="accepted">
                    <button class="btn success">قبول الطلب</button>
                </form>

                <form method="POST" action="{{ route('provider-requests.update.status', $providerRequest->id) }}">
                    @csrf
                    @method('patch')
                    <input type="hidden" name="status" value="rejected">
                    <button class="btn danger">رفض الطلب</button>
                </form>
            </div>
        @endif

    </div>
@endsection
