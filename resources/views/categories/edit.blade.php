@extends('layouts.app')

@section('content')
    <link rel="stylesheet" href="{{ asset('css/categories/edit.css') }}">

    <div class="page-container">

        {{-- Breadcrumb --}}
        <div class="breadcrumb">
            <a href="{{ route('dashboard') }}">الرئيسية</a>
            <span>/</span>
            <a href="{{ route('categories.index') }}">التصنيفات</a>
            <span>/</span>
            تعديل التصنيف
        </div>

        <div class="card">

            {{-- Header --}}
            <div class="card-header">
                <div>
                    <h1>✏️ تعديل التصنيف</h1>
                    <p>تحديث بيانات التصنيف وصورته</p>
                </div>

                <form action="{{ route('categories.destroy', $category) }}" method="POST"
                    onsubmit="return confirm('هل أنت متأكد من الحذف؟')">
                    @csrf
                    @method('DELETE')
                    <button class="btn-delete">🗑️ حذف</button>
                </form>
            </div>

            {{-- Form --}}
            <form action="{{ route('categories.update', $category) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="form-grid">

                    {{-- Data --}}
                    <div>
                        <div class="form-group">
                            <label>اسم التصنيف</label>
                            <input type="text" name="name" value="{{ old('name', $category->name) }}">
                            @error('name')
                                <span class="error-text">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label>التصنيف الأب</label>
                            <select name="category_id">
                                <option value="">— بدون —</option>

                                @include('categories.partials.category-options-update', [
                                    'categories' => $categories,
                                    'prefix' => '',
                                    'cat' => $category,
                                ])

                            </select>
                        </div>


                        <div class="form-group">
                            <label>الوصف</label>
                            <textarea name="description" rows="5">{{ old('description', $category->description) }}</textarea>
                        </div>
                    </div>

                    {{-- Image --}}
                    <div class="form-group">
                        <label>صورة التصنيف</label>

                        <label class="image-upload {{ $category->image_path ? 'has-image' : '' }}" id="imageUpload">
                            <input type="file" name="image" id="imageInput" accept="image/*">

                            {{-- Placeholder --}}
                            <div class="image-placeholder" style="{{ $category->image_path ? 'display:none;' : '' }}">
                                <i class="fa-regular fa-image"></i>
                                <span>اضغط لاختيار صورة</span>
                                <small>PNG, JPG حتى 2MB</small>
                            </div>

                            {{-- Preview --}}
                            <div class="image-preview" style="{{ $category->image_path ? '' : 'display:none;' }}">
                                <img id="previewImage"
                                    src="{{ $category->image_path ? asset('storage/' . $category->image_path) : '' }}">
                            </div>
                        </label>
                    </div>



                </div>

                {{-- Actions --}}
                <div class="form-actions">
                    <a href="{{ route('categories.index') }}" class="btn-secondary">إلغاء</a>
                    <button class="btn-primary">💾 حفظ التعديلات</button>
                </div>

            </form>
        </div>
    </div>

    <script>
        const input = document.getElementById('imageInput');
        const preview = document.getElementById('previewImage');
        const wrapper = document.getElementById('imageUpload');
        const placeholder = wrapper.querySelector('.image-placeholder');
        const previewContainer = wrapper.querySelector('.image-preview');

        input.addEventListener('change', function() {
            if (this.files && this.files[0]) {
                preview.src = URL.createObjectURL(this.files[0]);
                wrapper.classList.add('has-image');
                placeholder.style.display = 'none';
                previewContainer.style.display = 'block';
            }
        });
    </script>
@endsection
