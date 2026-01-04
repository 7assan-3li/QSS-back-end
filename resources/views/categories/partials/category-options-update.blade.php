@php
    $prefix = $prefix ?? '';
    $selected_id = $cat->category_id ?? null; // القيمة المحددة
@endphp

@foreach ($categories as $category)

    {{-- منع اختيار نفس التصنيف أو أحد أبنائه --}}
    @if ($category->id !== $cat->id && !in_array($category->id, $cat->childrenRecursive->pluck('id')->toArray()))
        <option value="{{ $category->id }}" {{ $selected_id == $category->id ? 'selected' : '' }}>
            {{ $prefix }}{{ $category->name }}
        </option>
    @endif

    @if ($category->childrenRecursive->isNotEmpty())
        @include('categories.partials.category-options-update', [
            'categories' => $category->childrenRecursive,
            'prefix' => $prefix . '— ',
            'cat' => $cat,
        ])
    @endif
@endforeach
