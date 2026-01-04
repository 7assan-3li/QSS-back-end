@extends('layouts.app')

@section('content')
    <link rel="stylesheet" href="{{ asset('css/users/index.css') }}">

    <div class="container">

        <!-- Page Header -->
        <div class="page-header">
            <h1>إدارة المستخدمين</h1>
            <p>عرض وإدارة جميع المستخدمين المسجلين</p>
        </div>

        <!-- Stats -->
        <div class="stats-grid">
            <div class="stat-card">
                <h3>{{ $users->count() }}</h3>
                <span>إجمالي المستخدمين</span>
            </div>

            <div class="stat-card">
                <h3>{{ $users->where('role', \App\constant\Role::ADMIN)->count() }}</h3>
                <span>المشرفون</span>
            </div>

            <div class="stat-card">
                <h3>{{ $users->where('role', \App\constant\Role::EMPLOYEE)->count() }}</h3>
                <span>الموظفين</span>
            </div>
            <div class="stat-card">
                <h3>{{ $users->where('role', \App\constant\Role::PROVIDER)->count() }}</h3>
                <span>المزودين</span>
            </div>
            <div class="stat-card">
                <h3>{{ $users->where('role', \App\constant\Role::SEEKER)->count() }}</h3>
                <span>طالبي الخدمة</span>
            </div>
        </div>

        {{-- @can('create', App\Models\User::class) --}}
        <!-- Table -->
        <div class="table-card">
            <table>
                <thead>
                    <tr>
                        <th>#</th>
                        <th>الاسم</th>
                        <th>البريد الإلكتروني</th>
                        <th>الدور</th>
                        <th>تاريخ التسجيل</th>
                        <th>التحكم</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($users as $user)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->email }}</td>
                            <td>
                                <span class="role-badge {{ $user->role }}">
                                    {{ $user->role }}
                                </span>
                            </td>
                            <td>{{ $user->created_at->format('Y-m-d') }}</td>
                            <td class="actions">
                                @can('view', $user)
                                    <a href="{{ route('users.show', $user->id) }}" class="btn view">عرض</a>
                                @endcan
                                @can('update', $user)
                                    <a href="{{ route('users.edit', $user->id) }}" class="btn edit">تعديل</a>
                                @endcan
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="empty">لا يوجد مستخدمون</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
            {{-- @endcan --}}
        </div>

    </div>
@endsection
