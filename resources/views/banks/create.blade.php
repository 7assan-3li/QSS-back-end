@extends('layouts.app')

@section('content')
<link rel="stylesheet" href="{{ asset('css/banks/create.css') }}">

<div class="page-wrapper">

    <div class="card">

        <div class="card-header">
            <h2>إضافة بنك جديد</h2>
            <p>أدخل بيانات البنك الأساسية</p>
        </div>

        @if ($errors->any())
            <div class="alert">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('banks.store') }}" enctype="multipart/form-data">
            @csrf

            <div class="form-group">
                <label>اسم البنك</label>
                <input type="text" name="bank_name" value="{{ old('bank_name') }}" placeholder="مثال: بنك اليمن الدولي" required>
            </div>

            <div class="form-group">
                <label>وصف البنك</label>
                <textarea name="description" rows="4" placeholder="وصف مختصر عن البنك">{{ old('description') }}</textarea>
            </div>

            <div class="form-group">
                <label>شعار البنك</label>

                <div class="file-input">
                    <input type="file" name="image" accept="image/*" onchange="previewImage(event)">
                    <span>اختر صورة</span>
                </div>

                <div class="image-preview" id="preview"></div>
            </div>

            <div class="actions">
                <button type="submit" class="btn-primary">حفظ البنك</button>
                <a href="{{ route('banks.index') }}" class="btn-secondary">رجوع</a>
            </div>

        </form>

    </div>
</div>

<script>
function previewImage(event) {
    const preview = document.getElementById('preview');
    preview.innerHTML = '';
    const img = document.createElement('img');
    img.src = URL.createObjectURL(event.target.files[0]);
    preview.appendChild(img);
}
</script>
@endsection
