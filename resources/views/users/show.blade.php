@extends('layouts.app')

@section('content')
<link rel="stylesheet" href="{{ asset('css/users/show.css') }}">

<div class="container">

    <!-- Header -->
    <div class="page-header">
        <h1>تفاصيل المستخدم</h1>
        <p>عرض معلومات المستخدم بشكل كامل</p>
    </div>

    <div class="profile-card">

        <!-- Avatar -->
        <div class="avatar">
            {{ strtoupper(substr($user->name, 0, 1)) }}
        </div>

        <!-- Info -->
        <div class="info">
            <h2>{{ $user->name }}</h2>
            <p class="email">{{ $user->email }}</p>

            <div class="meta">
                <span class="badge role-{{ $user->role }}">
                    {{ ucfirst($user->role) }}
                </span>
                <span class="date">
                    تاريخ التسجيل: {{ $user->created_at->format('Y-m-d') }}
                </span>
            </div>
        </div>

        <!-- Actions -->
        <div class="actions">
            <a href="{{ route('users.edit', $user->id) }}" class="btn-primary">تعديل</a>
            <a href="{{ route('users.index') }}" class="btn-secondary">رجوع</a>
        </div>

    </div>

</div>
@endsection
