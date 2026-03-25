@extends('layouts.app')

@section('title', 'إضافة باقة نقاط جديدة')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/admin/points_packages.css') }}">
@endsection

@section('content')
    <div class="page-header">
        <div>
            <h1>➕ إضافة باقة نقاط جديدة</h1>
            <p>أدخل تفاصيل الباقة الجديدة المتاحة للشراء</p>
        </div>
    </div>

    <div class="form-container">
        <form action="{{ route('admin.points-packages.store') }}" method="POST">
            @csrf
            
            <div class="form-group">
                <label for="name">اسم الباقة</label>
                <input type="text" name="name" id="name" required placeholder="مثال: الباقة الذهبية">
            </div>

            <div class="form-group">
                <label for="points">عدد النقاط الأساسية</label>
                <input type="number" name="points" id="points" required min="1" placeholder="عدد النقاط التي سيحصل عليها المستخدم">
            </div>

            <div class="form-group">
                <label for="bonus_points">النقاط الإضافية (اختياري)</label>
                <input type="number" name="bonus_points" id="bonus_points" min="0" value="0" placeholder="نقاط مجانية تضاف كهدية">
            </div>

            <div class="form-group">
                <label for="price">السعر (بالريال)</label>
                <input type="number" step="0.01" name="price" id="price" required min="0" placeholder="0.00">
            </div>

            <div class="form-group">
                <label for="expires_at">تاريخ انتهاء الباقة (اختياري)</label>
                <input type="date" name="expires_at" id="expires_at">
            </div>

            <div class="form-actions">
                <button type="submit" class="btn-save">حفظ الباقة</button>
                <a href="{{ route('admin.points-packages.index') }}" class="btn-cancel">إلغاء</a>
            </div>
        </form>
    </div>
@endsection
