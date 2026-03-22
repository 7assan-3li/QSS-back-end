@extends('layouts.app')

@section('title', 'إضافة باقة توثيق')

@section('content')
<link rel="stylesheet" href="{{ asset('css/verification_packages/create.css') }}">

<div class="container">

    <!-- Breadcrumb -->
    <div style="margin-bottom:20px;font-size:14px;color:#6b7280">
        لوحة التحكم / باقات التوثيق / <strong>إضافة باقة</strong>
    </div>

    <div class="page-header">
        <h1>إضافة باقة توثيق جديدة</h1>
        <p>إنشاء باقة جديدة للتوثيق وتحديد سعرها ومدتها</p>
    </div>

    <div class="form-card">

        <form action="{{ route('verification-packages.store') }}" method="POST">
            @csrf

            <!-- Basic Info -->
            <div class="form-section">
                <h3>📌 المعلومات الأساسية</h3>

                <div class="form-group">
                    <label>اسم الباقة</label>
                    <input type="text" name="name" value="{{ old('name') }}" required>
                    @error('name') <span class="error-text">{{ $message }}</span> @enderror
                </div>

                <div class="form-group">
                    <label>السعر (ر.س)</label>
                    <input type="number" step="0.01" name="price" value="{{ old('price') }}" required>
                    @error('price') <span class="error-text">{{ $message }}</span> @enderror
                </div>

                <div class="form-group">
                    <label>المدة (بالأيام)</label>
                    <input type="number" name="duration_days" value="{{ old('duration_days') }}" required>
                    @error('duration_days') <span class="error-text">{{ $message }}</span> @enderror
                </div>
            </div>

            <!-- Description -->
            <div class="form-section">
                <h3>📝 الوصف</h3>

                <div class="form-group">
                    <textarea name="description" rows="4"
                        placeholder="وصف مختصر للباقة ومميزاتها">{{ old('description') }}</textarea>
                    @error('description') <span class="error-text">{{ $message }}</span> @enderror
                </div>
            </div>

            <!-- Status -->
            <div class="form-section">
                <h3>⚙️ حالة الباقة</h3>

                <div class="form-group">
                    <label class="switch-label">
                        <input type="checkbox" name="is_active" value="1" {{ old('is_active', true) ? 'checked' : '' }}>
                        تفعيل الباقة (متاحة للمستخدمين)
                    </label>
                    @error('is_active') <span class="error-text">{{ $message }}</span> @enderror
                </div>
            </div>

            <!-- Actions -->
            <div class="form-actions">
                <button type="submit" class="btn-primary">حفظ الباقة</button>
                <a href="{{ route('verification-packages.index') }}" class="btn-secondary">إلغاء</a>
            </div>

        </form>

    </div>

</div>
@endsection
