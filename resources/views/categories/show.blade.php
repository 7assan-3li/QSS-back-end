@extends('layouts.app')

@section('content')
<link rel="stylesheet" href="{{ asset('css/categories/show.css') }}">

<div class="container">

    <!-- Header -->
    <div class="page-header">
        <h1>{{ $category->name }}</h1>
        <p>تفاصيل التصنيف</p>
    </div>

    <!-- Main Card -->
    <div class="show-card">

        <!-- Image -->
        @if($category->image)
        <div class="show-image">
            <img src="{{ $category->image }}" alt="{{ $category->name }}">
        </div>
        @endif

        <!-- Content -->
        <div class="show-content">
            <h2>الوصف</h2>
            <p>{{ $category->description ?? 'لا يوجد وصف لهذا التصنيف' }}</p>

            <div class="show-meta">
                <div><strong>تاريخ الإنشاء:</strong> {{ $category->created_at->format('Y-m-d') }}</div>
                <div><strong>آخر تحديث:</strong> {{ $category->updated_at->format('Y-m-d') }}</div>
            </div>

            <div class="show-actions">
                <a href="{{ route('categories.index') }}" class="btn-secondary">رجوع</a>
                 @can('update', $category)
                <a href="{{ route('categories.edit', $category->id) }}" class="btn-primary">تعديل</a>
                @endcan
                 @can('delete', $category)
                <form action="{{ route('categories.destroy', $category->id) }}" method="POST" style="display:inline;">
                    @csrf
                    @method('DELETE')
                    <button class="btn-danger" onclick="return confirm('هل أنت متأكد من الحذف؟')">حذف</button>
                </form>
                @endcan
            </div>
        </div>

    </div>

    <!-- Children Categories -->
    @if($category->children->isNotEmpty())
        <h2 class="children-title">الأبناء</h2>
        <div class="children-grid">
            @foreach($category->children as $child)
                <div class="child-card">
                    <h3>{{ $child->name }}</h3>
                    <p>{{ $child->description ?? 'لا يوجد وصف' }}</p>
                    <a href="{{ route('categories.show', $child->id) }}" class="btn-primary btn-sm">عرض التفاصيل</a>
                </div>
            @endforeach
        </div>
    @endif

</div>
@endsection
