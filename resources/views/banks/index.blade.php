@extends('layouts.app')

@section('content')
<link rel="stylesheet" href="{{ asset('css/banks/index.css') }}">

<div class="banks-page">

    <div class="page-header">
        <div>
            <h2>إدارة البنوك</h2>
            <p>قائمة بجميع البنوك المسجلة في النظام</p>
        </div>

        <a href="{{ route('banks.create') }}" class="btn-add">
            + إضافة بنك
        </a>
    </div>

    @if(session('success'))
        <div class="success-alert">{{ session('success') }}</div>
    @endif

    <div class="banks-grid">
        @forelse($banks as $bank)
            <div class="bank-card">

                <div class="bank-image">
                    @if($bank->image_path)
                        <img src="{{ asset('storage/'.$bank->image_path) }}" alt="{{ $bank->bank_name }}">
                    @else
                        <div class="no-image">لا توجد صورة</div>
                    @endif
                </div>

                <div class="bank-body">
                    <h3>{{ $bank->id }}: {{ $bank->bank_name }}</h3>
                    <p>{{ Str::limit($bank->description, 90) }}</p>
                </div>

                <div class="bank-actions">
                    <a href="{{ route('banks.show', $bank->id) }}" class="btn-view">عرض</a>
                    <a href="{{ route('banks.edit', $bank->id) }}" class="btn-edit">تعديل</a>

                    <form action="{{ route('banks.destroy', $bank->id) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn-delete"
                            onclick="return confirm('هل أنت متأكد من الحذف؟')">
                            حذف
                        </button>
                    </form>
                </div>

            </div>
        @empty
            <p class="empty">لا يوجد بنوك حتى الآن</p>
        @endforelse
    </div>

</div>
@endsection
