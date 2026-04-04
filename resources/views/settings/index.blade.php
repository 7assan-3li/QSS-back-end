@extends('layouts.app')

@section('title', 'إعدادات النظام المالية')

@section('content')
<link rel="stylesheet" href="{{ asset('css/settings/index.css') }}">
<!-- FontAwesome for standard icons instead of just emojis -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

<div class="settings-container" dir="rtl">
    <div class="header">
        <h2><i class="fas fa-sliders-h"></i> إعدادات النظام المالية والإدارية</h2>
        <p>قم بالتحكم الحي بنسب العمولات والمكافآت المئوية والتي تؤثر أوتوماتيكياً على جميع العمليات الجديدة في التطبيق لحظة حفظها.</p>
    </div>

    @if (session('success'))
        <div class="alert alert-success">
            <i class="fas fa-check-circle"></i> {{ session('success') }}
        </div>
    @endif

    <div class="card settings-card">
        <form action="{{ route('settings.update') }}" method="POST">
            @csrf
            @method('PUT')
            
            <div class="settings-list">
                @foreach ($settings as $setting)
                    <div class="form-group setting-item">
                        <div class="setting-info">
                            <label for="{{ $setting->key }}">{{ $setting->display_name }}</label>
                            <small class="text-muted">المفتاح البرمجي: <code style="background:#f1f3f5; padding:2px 8px; border-radius:4px;">{{ $setting->key }}</code></small>
                        </div>
                        <div class="setting-input-wrapper">
                            <input type="number" step="0.01" min="0" max="100" class="form-control" 
                                id="{{ $setting->key }}" name="{{ $setting->key }}" value="{{ $setting->value }}" required>
                            <span class="percentage-symbol">%</span>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="form-actions">
                <button type="submit" class="btn btn-primary btn-lg">
                    <i class="fas fa-save"></i> حفظ جميع المتغيرات الحية
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
