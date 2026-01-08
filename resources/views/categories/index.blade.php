@extends('layouts.app')

@section('title', 'التصنيفات')

@section('content')
    <link rel="stylesheet" href="{{ asset('css/categories/index.css') }}">

    <!-- Header -->
    <div class="page-header">
        <div>
            <h1>التصنيفات</h1>
            <p>إدارة جميع التصنيفات في النظام</p>
        </div>

        <a href="{{ route('categories.create') }}" class="btn-add">
            ➕ إضافة تصنيف
        </a>
    </div>

    <!-- Stats -->
    <div class="stats-grid">
        <div class="stat-card">
            <h3>إجمالي التصنيفات</h3>
            <span>{{ $categories->count() }}</span>
        </div>

        <div class="stat-card">
            <h3>التصنيفات الرئيسية</h3>
            <span>{{ $categories->whereNull('category_id')->count() }}</span>
        </div>
    </div>

    <!-- Grid -->
    @if ($categories->count())
        <div class="categories-grid">
            @foreach ($categories->whereNull('category_id') as $category)
                <div class="category-card">

                    @if ($category->image_path)
                        <img src="{{ asset('storage/' . $category->image_path) }}">
                    @endif

                    <h3>{{ $category->name }}</h3>

                    <p>
                        {{ Str::limit($category->description, 80) ?? 'لا يوجد وصف' }}
                    </p>

                    <div class="card-actions">
                        <a href="{{ route('categories.show', $category->id) }}" class="btn-view">
                            عرض
                        </a>

                        <a href="{{ route('categories.edit', $category->id) }}" class="btn-edit">
                            تعديل
                        </a>
                    </div>

                </div>
            @endforeach
        </div>
    @else
        <div class="empty-state">
            لا يوجد تصنيفات حتى الآن
        </div>
    @endif
@endsection
