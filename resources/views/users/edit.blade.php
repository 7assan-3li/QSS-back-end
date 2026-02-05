@extends('layouts.app')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/users/edit.css') }}">
@endsection

@section('content')
    <div class="container">

        <!-- Page Header -->
        <div class="page-header">
            <h1>تعديل بيانات المستخدم</h1>
            <p>يمكنك تعديل بيانات المستخدم وصلاحياته</p>
        </div>

        <div class="form-card">

            <form action="{{ route('users.update', $user->id) }}" method="POST">
                @csrf
                @method('PUT')

                <!-- Name -->
                <div class="form-group">
                    <label for="name">الاسم</label>
                    <input type="text" id="name" name="name" value="{{ old('name', $user->name) }}" required>
                    @error('name')
                        <span class="error-text">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Email -->
                <div class="form-group">
                    <label for="email">البريد الإلكتروني</label>
                    <input type="email" id="email" name="email" value="{{ old('email', $user->email) }}" required>
                    @error('email')
                        <span class="error-text">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Role -->
                <div class="form-group">
                    <label for="role">الدور</label>
                    <select name="role" id="role">


                        <option value="{{ \App\constant\Role::EMPLOYEE }}"
                            {{ $user->role === \App\constant\Role::EMPLOYEE ? 'selected' : '' }}>
                            Employee
                        </option>

                        <option value="{{ \App\constant\Role::SEEKER }}"
                            {{ $user->role === \App\constant\Role::SEEKER ? 'selected' : '' }}>
                            Seeker
                        </option>

                        <option value="{{ \App\constant\Role::PROVIDER }}"
                            {{ $user->role === \App\constant\Role::PROVIDER ? 'selected' : '' }}>
                            Provider
                        </option>
                    </select>
                </div>

                <!-- Password -->
                {{-- <div class="form-group">
                    <label for="password">كلمة المرور الجديدة (اختياري)</label>
                    <input type="password" id="password" name="password">
                </div> --}}

                <!-- Actions -->
                <div class="form-actions">
                    <button type="submit" class="btn-primary">حفظ التعديلات</button>
                    <a href="{{ route('users.index') }}" class="btn-secondary">رجوع</a>
                </div>

            </form>

        </div>
        <div class="page-header">
            <h1></h1>
            <p>يمكنك تعديل كلمة مرور المستخدم </p>
        </div>

        <div class="form-card">

            <form action="{{ route('users.update.password', $user->id) }}" method="POST">
                @csrf
                @method('PUT')
                <!-- Password -->
                <div class="form-group">
                    <label for="password">كلمة المرور الجديدة</label>
                    <input type="password" id="password" name="password">
                </div>
                <!-- Actions -->
                <div class="form-actions">
                    <button type="submit" class="btn-primary">حفظ التعديلات</button>
                    <a href="{{ route('users.index') }}" class="btn-secondary">رجوع</a>
                </div>
            </form>



        </div>

        <div class="page-header">
            <h1></h1>
            <p>يمكنك توثيق البريد الالكتروني </p>
        </div>

        <div class="form-card">
            @if ($user->hasVerifiedEmail())
                <div class="info-box">
                    تم توثيق البريد الإلكتروني لهذا المستخدم بالفعل.
                </div>
            @else
            <form action="{{ route('verify.email.admin', $user->id) }}" method="POST">
                @csrf
                @method('PATCH')
                <!-- Actions -->
                <div class="form-actions">
                    <button type="submit" class="btn-primary">توثيق البريد الإلكتروني</button>
                    <a href="{{ route('users.index') }}" class="btn-secondary">رجوع</a>
                </div>
            </form>
            @endif
        </div>

    </div>
@endsection
