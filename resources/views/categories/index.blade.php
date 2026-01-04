@extends('layouts.app')
@section('content')
    <link rel="stylesheet" href="{{ asset('css/categories/index.css') }}">

    <div class="container">
        <div class="page-header">
            <h1>التصنيفات</h1>
            @can('create', App\Models\Category::class)
            <a href="{{ route('categories.create') }}">إضافة تصنيف</a>
            @endcan
            <p>استعرض جميع التصنيفات المتاحة</p>
        </div>

        <div class="cards-grid">

            @forelse($categories as $category)
                <div class="category-card">

                    {{-- <div class="card-image">
                        <img src="{{ $category->image ?? asset('images/default-category.png') }}" alt="{{ $category->name }}">
                    </div> --}}

                    <div class="card-body">
                        <h2>{{ $category->name }}</h2>

                        <p>
                            {{ $category->description ?? 'لا يوجد وصف لهذا التصنيف' }}
                        </p>

                        <a href="{{ route('categories.show', $category->id) }}" class="details-btn">
                            عرض التفاصيل →
                        </a>
                        @can('update', $category)
                        <a href="{{ route('categories.edit', $category->id) }}" class="btn">
                            تعديل
                        </a>
                        @endcan

                    </div>

                </div>
            @empty
                <p class="empty-text">لا توجد تصنيفات حاليًا</p>
            @endforelse

        </div>
    </div>
@endsection
