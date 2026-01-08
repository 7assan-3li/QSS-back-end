@extends('layouts.app')

@section('title', 'تفاصيل التصنيف')

@section('content')
    <link rel="stylesheet" href="{{ asset('css/categories/show.css') }}">

    <!-- Header -->
    <div class="page-header">
        <div>
            <h1>{{ $category->name }}</h1>
            <p>تفاصيل التصنيف</p>
        </div>

        <div class="header-actions">
            <a href="{{ route('categories.index') }}" class="btn-back">رجوع</a>
            <a href="{{ route('categories.edit', $category->id) }}" class="btn-edit">تعديل</a>
        </div>
    </div>

    <!-- Details -->
    <div class="details-card">
        <!-- Image -->
        @if ($category->image_path)
            <div class="category-image">
                <img src="{{ asset('storage/' . $category->image_path) }}" alt="{{ $category->name }}">
            </div>
        @else
            <div class="category-placeholder">
                لا توجد صورة للتصنيف
            </div>
        @endif

        <div class="info-row">
            <div class="info-item">
                <h4>اسم التصنيف</h4>
                <p>{{ $category->name }}</p>
            </div>

            <div class="info-item">
                <h4>التصنيف الأب</h4>
                <p>{{ $category->parent?->name ?? 'تصنيف رئيسي' }}</p>
            </div>

            <div class="info-item">
                <h4>عدد التصنيفات الفرعية</h4>
                <p>{{ $category->children->count() }}</p>
            </div>

            <div class="info-item">
                <h4>تاريخ الإنشاء</h4>
                <p>{{ $category->created_at->format('Y-m-d') }}</p>
            </div>
        </div>

        @if ($category->description)
            <div class="description">
                {{ $category->description }}
            </div>
        @endif
    </div>

    <!-- Children -->
    @if ($category->children->count())
        <h2 class="children-title">التصنيفات الفرعية</h2>

        <div class="children-grid">
            @foreach ($category->children as $child)
                <div class="child-card">
                    <h3>{{ $child->name }}</h3>
                    <p>{{ Str::limit($child->description, 60) ?? 'لا يوجد وصف' }}</p>

                    <a href="{{ route('categories.show', $child->id) }}">
                        عرض التفاصيل →
                    </a>
                </div>
            @endforeach
        </div>
    @endif
@endsection
