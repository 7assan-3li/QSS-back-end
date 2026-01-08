@php
    $prefix = $prefix ?? '';
@endphp

@foreach ($categories as $item)
    {{-- منع اختيار نفس التصنيف أو أحد أبنائه --}}
    @if ($item->id !== $cat->id && !in_array($item->id, $cat->childrenRecursive->pluck('id')->toArray()))
        <option value="{{ $item->id }}" @selected(old('category_id', $cat->category_id) == $item->id)>
            {{ $prefix }}{{ $item->name }}
        </option>
    @endif

    @if ($item->childrenRecursive && $item->childrenRecursive->count())
        @include('categories.partials.category-options-update', [
            'categories' => $item->childrenRecursive,
            'prefix' => $prefix . '— ',
            'cat' => $cat,
        ])
    @endif
@endforeach
