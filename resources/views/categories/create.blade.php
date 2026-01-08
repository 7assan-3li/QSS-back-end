@extends('layouts.app')

@section('title', 'إضافة تصنيف')

@section('content')
<link rel="stylesheet" href="{{ asset('css/categories/create.css') }}">

<div class="container">

    <!-- Breadcrumb -->
    <div style="margin-bottom:20px;font-size:14px;color:#6b7280">
        لوحة التحكم / التصنيفات / <strong>إضافة تصنيف</strong>
    </div>

    <div class="page-header">
        <h1>إضافة تصنيف جديد</h1>
        <p>إنشاء تصنيف جديد وربطه بالتصنيفات الأخرى بسهولة</p>
    </div>

    <div class="form-card">

        <form action="{{ route('categories.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <!-- Basic Info -->
            <div class="form-section">
                <h3>📌 المعلومات الأساسية</h3>

                <div class="form-group">
                    <label>اسم التصنيف</label>
                    <input type="text" name="name" value="{{ old('name') }}" required>
                    @error('name') <span class="error-text">{{ $message }}</span> @enderror
                </div>

                <div class="form-group">
                    <label>التصنيف الأب</label>
                    <select name="category_id">
                        <option value="">— تصنيف رئيسي —</option>
                        @include('categories.partials.category-options', [
                            'categories' => $categories,
                            'prefix' => '',
                        ])
                    </select>
                </div>
            </div>

            <!-- Description -->
            <div class="form-section">
                <h3>📝 الوصف</h3>

                <div class="form-group">
                    <textarea name="description" rows="4"
                        placeholder="وصف مختصر للتصنيف">{{ old('description') }}</textarea>
                </div>
            </div>

            <!-- Image -->
            <div class="form-section">
                <h3>🖼 صورة التصنيف</h3>

                <label class="file-upload">
                    <input type="file" name="image_path" accept="image/*" onchange="previewImage(event)">
                    <span>اضغط لاختيار صورة</span>
                </label>

                <img id="preview" class="image-preview">

                @error('image_path')
                    <span class="error-text">{{ $message }}</span>
                @enderror
            </div>

            <!-- Actions -->
            <div class="form-actions">
                <button class="btn-primary">حفظ التصنيف</button>
                <a href="{{ route('categories.index') }}" class="btn-secondary">إلغاء</a>
            </div>

        </form>

    </div>

</div>
@endsection

@section('js')
<script>
function previewImage(event) {
    const preview = document.getElementById('preview');
    preview.src = URL.createObjectURL(event.target.files[0]);
    preview.style.display = 'block';
}
</script>
@endsection
