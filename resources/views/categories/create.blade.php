@extends('layouts.app')

@section('content')
    <link rel="stylesheet" href="{{ asset('css/categories/create.css') }}">

    <div class="container">

        <div class="page-header">
            <h1>إضافة تصنيف جديد</h1>
            <p>قم بإدخال بيانات التصنيف</p>
        </div>

        <div class="form-card">

            <form action="{{ route('categories.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <!-- Name -->
                <div class="form-group">
                    <label for="name">اسم التصنيف</label>
                    <input type="text" name="name" id="name" value="{{ old('name') }}"
                        placeholder="مثال: تصميم، برمجة..." required>
                    @error('name')
                        <span class="error-text">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Parent Category -->
                <div class="form-group">
                    <label for="parent_id">التصنيف الأب</label>

                    <select name="category_id" id="parent_id">
                        <option value="">— تصنيف رئيسي —</option>

                        @include('categories.partials.category-options', [
                            'categories' => $categories,
                            'prefix' => '',
                        ])
                    </select>

                </div>


                <!-- Description -->
                <div class="form-group">
                    <label for="description">الوصف</label>
                    <textarea name="description" id="description" rows="4" placeholder="وصف مختصر للتصنيف">{{ old('description') }}</textarea>
                </div>

                <!-- Image -->
                {{-- <div class="form-group">
                    <label for="image">صورة التصنيف</label>
                    <input type="file" name="image" id="image" accept="image/*">
                </div> --}}

                <!-- Buttons -->
                <div class="form-actions">
                    <button type="submit" class="btn-primary">
                        حفظ التصنيف
                    </button>

                    <a href="{{ route('categories.index') }}" class="btn-secondary">
                        رجوع
                    </a>
                </div>

            </form>

        </div>

    </div>
@endsection
