@extends('layouts.app')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
@endsection
@section('content')
    <div class="admin-layout">



        <!-- Main Content -->
        <main class="dashboard-content">

            <!-- Header -->
            <div class="dashboard-header">
                <h1>لوحة التحكم</h1>
                <p>نظرة عامة على النظام</p>
            </div>

            <!-- Stats Cards -->
            <div class="stats-grid">

                <div class="stat-card">
                    <h3>عدد المستخدمين</h3>
                    <span>{{ $usersCount }}</span>
                </div>

                <div class="stat-card">
                    <h3>عدد التصنيفات</h3>
                    <span>{{ $categoriesCount }}</span>
                </div>

                <div class="stat-card placeholder">
                    <h3>تقارير مستقبلية</h3>
                    <span>قريبًا</span>
                </div>

            </div>

            <!-- Reports Section -->
            <div class="reports-section">
                <h2>التقارير</h2>

                <div class="report-card">
                    <h4>تقرير المستخدمين</h4>
                    <p>يعرض إحصائيات عامة حول المستخدمين المسجلين في النظام.</p>
                </div>

                <div class="report-card">
                    <h4>تقرير التصنيفات</h4>
                    <p>يعرض عدد التصنيفات ونشاطها داخل النظام.</p>
                </div>

            </div>

        </main>

    </div>
@endsection
