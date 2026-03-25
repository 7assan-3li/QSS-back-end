@extends('layouts.app')

@section('title', 'تعديل باقة نقاط')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/admin/points_packages.css') }}">
@endsection

@section('content')
    <div class="page-header">
        <div>
            <h1>✏️ تعديل باقة: {{ $package->name }}</h1>
            <p>تحديث معلومات الباقة الحالية</p>
        </div>
    </div>

    <div class="form-container">
        <form action="{{ route('admin.points-packages.update', $package->id) }}" method="POST">
            @csrf
            @method('PUT')
            
            <div class="form-group">
                <label for="name">اسم الباقة</label>
                <input type="text" name="name" id="name" required value="{{ $package->name }}">
            </div>

            <div class="form-group">
                <label for="points">عدد النقاط الأساسية</label>
                <input type="number" name="points" id="points" required min="1" value="{{ $package->points }}">
            </div>

            <div class="form-group">
                <label for="bonus_points">النقاط الإضافية</label>
                <input type="number" name="bonus_points" id="bonus_points" min="0" value="{{ $package->bonus_points }}">
            </div>

            <div class="form-group">
                <label for="price">السعر (بالريال)</label>
                <input type="number" step="0.01" name="price" id="price" required min="0" value="{{ $package->price }}">
            </div>

            <div class="form-group">
                <label for="is_active">الحالة</label>
                <select name="is_active" id="is_active">
                    <option value="1" {{ $package->is_active ? 'selected' : '' }}>نشطة</option>
                    <option value="0" {{ !$package->is_active ? 'selected' : '' }}>معطلة</option>
                </select>
            </div>

            <div class="form-group">
                <label for="expires_at">تاريخ انتهاء الباقة</label>
                <input type="date" name="expires_at" id="expires_at" value="{{ $package->expires_at ? $package->expires_at->format('Y-m-d') : '' }}">
            </div>

            <div class="form-actions">
                <button type="submit" class="btn-save">تحديث البيانات</button>
                <a href="{{ route('admin.points-packages.index') }}" class="btn-cancel">إلغاء</a>
            </div>
        </form>
    </div>
@endsection
