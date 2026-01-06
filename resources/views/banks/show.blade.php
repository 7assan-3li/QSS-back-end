@extends('layouts.app')

@section('content')
<link rel="stylesheet" href="{{ asset('css/banks/show.css') }}">

<div class="bank-show">

    <!-- Header -->
    <div class="show-header">
        <div>
            <h2>{{ $bank->bank_name }}</h2>
            <p>تفاصيل البنك</p>
        </div>

        <div class="header-actions">
            <a href="{{ route('banks.edit', $bank->id) }}" class="btn-edit">تعديل</a>
            <a href="{{ route('banks.index') }}" class="btn-back">رجوع</a>
        </div>
    </div>

    <!-- Card -->
    <div class="bank-card">

        <div class="bank-image">
            @if($bank->image_path)
                <img src="{{ asset($bank->image_path) }}" alt="{{ $bank->bank_name }}">
            @else
                <div class="no-image">لا توجد صورة</div>
            @endif
        </div>

        <div class="bank-info">
            <div class="info-item">
                <span>اسم البنك</span>
                <strong>{{ $bank->bank_name }}</strong>
            </div>

            <div class="info-item">
                <span>الوصف</span>
                <p>
                    {{ $bank->description ?? 'لا يوجد وصف لهذا البنك' }}
                </p>
            </div>

            <div class="info-item">
                <span>تاريخ الإضافة</span>
                <strong>{{ $bank->created_at->format('Y-m-d') }}</strong>
            </div>
        </div>

    </div>

</div>
@endsection
