@extends('layouts.app')

@section('content')
    <link rel="stylesheet" href="{{ asset('css/users/index.css') }}">

    <div class="container">

        <!-- Header -->
        <div class="page-header">
            <h1>إدارة المستخدمين</h1>
            <p>لوحة تحكم وتقارير إحصائية</p>
        </div>

        <!-- Stats -->
        <div class="stats-grid">
            <div class="stat-card">
                <h3>{{ $users->count() }}</h3>
                <span>إجمالي المستخدمين</span>
            </div>

            <div class="stat-card">
                <h3>{{ $todayUsers }}</h3>
                <span>مستخدمون اليوم</span>
            </div>

            <div class="stat-card">
                <h3>{{ $weekUsers }}</h3>
                <span>هذا الأسبوع</span>
            </div>

            <div class="stat-card">
                <h3>{{ $growth }}%</h3>
                <span>نسبة النمو الشهري</span>
            </div>
        </div>

        <!-- Charts -->
        <div class="charts-grid">
            <div class="chart-card">
                <h3>تسجيل المستخدمين خلال السنة</h3>
                <canvas id="usersChart"></canvas>
            </div>

            <div class="chart-card">
                <h3>توزيع المستخدمين حسب الدور</h3>
                <canvas id="rolesChart"></canvas>
            </div>
        </div>

        <!-- Table -->
        <div class="table-card">
            <table>
                <thead>
                    <tr>
                        <th>#</th>
                        <th>الاسم</th>
                        <th>البريد</th>
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

                            <!-- Actions -->
                            <td class="actions">
                                @can('view', $user)
                                    <a href="{{ route('users.show', $user->id) }}" class="btn view">
                                        عرض
                                    </a>
                                @endcan

                                @can('update', $user)
                                    <a href="{{ route('users.edit', $user->id) }}" class="btn edit">
                                        تعديل
                                    </a>
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
        </div>

    </div>
@endsection

@section('js')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>
        /* Users per month */
        new Chart(document.getElementById('usersChart'), {
            type: 'line',
            data: {
                labels: @json($usersChart->keys()),
                datasets: [{
                    label: 'عدد المستخدمين',
                    data: @json($usersChart->values()),
                    fill: true,
                    tension: 0.4,
                    backgroundColor: 'rgba(17,24,39,0.1)',
                    borderColor: '#111827',
                    pointRadius: 5
                }]
            },
            options: {
                plugins: { legend: { display: false } },
                scales: {
                    y: { beginAtZero: true, ticks: { precision: 0 } }
                }
            }
        });

        /* Roles distribution */
        new Chart(document.getElementById('rolesChart'), {
            type: 'doughnut',
            data: {
                labels: @json($rolesChart->keys()),
                datasets: [{
                    data: @json($rolesChart->values()),
                    backgroundColor: ['#111827', '#374151', '#6b7280', '#9ca3af']
                }]
            },
            options: {
                plugins: {
                    legend: { position: 'bottom' }
                }
            }
        });
    </script>
@endsection