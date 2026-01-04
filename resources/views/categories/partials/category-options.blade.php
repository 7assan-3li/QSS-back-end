@php
    $prefix = $prefix ?? ''; // إذا لم يُرسل، اجعلها فارغة
@endphp

@foreach ($categories as $category)
    <option value="{{ $category->id }}"
        {{ old('category_id') == $category->id ? 'selected' : '' }}>
        {{ $prefix }}{{ $category->name }}
    </option>

    @if ($category->childrenRecursive->isNotEmpty())
        @include('categories.partials.category-options', [
            'categories' => $category->childrenRecursive,
            'prefix' => $prefix . '— '
        ])
    @endif
@endforeach
