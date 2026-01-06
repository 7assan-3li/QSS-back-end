@extends('layouts.app')

@section('content')
    <link rel="stylesheet" href="{{ asset('css/banks/edit.css') }}">

    <div class="bank-edit">

        <!-- Header -->
        <div class="edit-header">
            <div>
                <h2>تعديل البنك</h2>
                <p>تحديث بيانات البنك</p>
            </div>

            <a href="{{ route('banks.index') }}" class="btn-back">رجوع</a>
        </div>

        @if ($errors->any())
            <div class="errors">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- Form Card -->
        <form method="POST" action="{{ route('banks.update', $bank->id) }}" enctype="multipart/form-data" class="bank-form">

            @csrf
            @method('PUT')

            <div class="form-grid">

                <!-- Image -->
                <div class="image-box">
                    @if ($bank->image_path)
                        <img src="{{ asset('storage/' . $bank->image_path) }}" alt="{{ $bank->bank_name }}">
                    @else
                        <div class="no-image">لا توجد صورة</div>
                    @endif

                    <label class="upload-btn">
                        تغيير الصورة
                        <input type="file" name="image" hidden>
                    </label>
                </div>

                <!-- Fields -->
                <div class="fields">

                    <div class="form-group">
                        <label>اسم البنك</label>
                        <input type="text" name="bank_name" value="{{ old('bank_name', $bank->bank_name) }}" required>
                    </div>

                    <div class="form-group">
                        <label>الوصف</label>
                        <textarea name="description" rows="5">{{ old('description', $bank->description) }}</textarea>
                    </div>

                </div>
            </div>

            <!-- Actions -->
            <div class="actions">
                <button type="submit" class="btn-save">حفظ التعديلات</button>
                <a href="{{ route('banks.show', $bank->id) }}" class="btn-cancel">إلغاء</a>
            </div>

        </form>

    </div>
@endsection
