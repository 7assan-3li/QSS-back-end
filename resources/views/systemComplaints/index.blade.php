@extends('layouts.app')

@section('content')
    <link rel="stylesheet" href="{{ asset('css/systemComplaints/index.css') }}">

    <div class="system-complaints">

        <!-- ===== Stats ===== -->
        <div class="stats-grid">
            <a class="stat-card">
                <h4>إجمالي الشكاوى</h4>
                <span>{{ $stats['total'] }}</span>
            </a>

            <a href="?status=pending" class="stat-card warning">
                <h4>قيد المراجعة</h4>
                <span>{{ $stats['pending'] }}</span>
            </a>

            <a href="?status=in_progress" class="stat-card info">
                <h4>قيد المعالجة</h4>
                <span>{{ $stats['in_progress'] }}</span>
            </a>

            <a href="?status=completed" class="stat-card success">
                <h4>مكتملة</h4>
                <span>{{ $stats['completed'] }}</span>
            </a>
        </div>

        <!-- ===== Charts ===== -->
        <div class="charts-grid">

            <div class="chart-card">
                <h3>توزيع حالات الشكاوى</h3>
                <canvas id="statusChart"></canvas>
            </div>

            <div class="chart-card">
                <div class="chart-actions">
                    <a href="?days=7" class="{{ $days == 7 ? 'active' : '' }}">7 أيام</a>
                    <a href="?days=30" class="{{ $days == 30 ? 'active' : '' }}">30 يوم</a>
                    <a href="?days=90" class="{{ $days == 90 ? 'active' : '' }}">90 يوم</a>
                </div>

                <h3>الشكاوى خلال الفترة</h3>
                <canvas id="dailyChart"></canvas>
            </div>

        </div>

        <!-- ===== Table ===== -->
        <div class="table-card">
            <h2>شكاوى النظام</h2>

            <table>
                <thead>
                    <tr>
                        <th>#</th>
                        <th>العنوان</th>
                        <th>النوع</th>
                        <th>المستخدم</th>
                        <th>الحالة</th>
                        <th>التاريخ</th>
                        <th>التحكم</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse ($complaints as $complaint)
                        <tr class="row-{{ $complaint->status }}">
                            <td data-label="#">{{ $complaint->id }}</td>
                            <td data-label="العنوان">{{ $complaint->title }}</td>
                            <td data-label="النوع">{{ $complaint->type }}</td>
                            <td data-label="المستخدم">{{ $complaint->user->name }}</td>

                            <td data-label="الحالة">
                                <span class="badge {{ $complaint->status }}">
                                    {{ __($complaint->status) }}
                                </span>
                            </td>

                            <td data-label="التاريخ">{{ $complaint->created_at->format('Y-m-d') }}</td>

                            <td data-label="التحكم" class="actions">
                                <a href="{{ route('system-complaints.show', $complaint) }}">عرض</a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="empty">لا توجد شكاوى</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>
        /* ===== Status Doughnut ===== */
        new Chart(document.getElementById('statusChart'), {
            type: 'doughnut',
            data: {
                labels: ['قيد المراجعة', 'قيد المعالجة', 'مكتملة'],
                datasets: [{
                    data: [
                    {{ $stats['pending'] }},
                    {{ $stats['in_progress'] }},
                        {{ $stats['completed'] }}
                    ],
                    backgroundColor: ['#facc15', '#3b82f6', '#22c55e']
                }]
            },
            options: {
                plugins: { legend: { position: 'bottom' } }
            }
        });

        /* ===== Daily Line ===== */
        new Chart(document.getElementById('dailyChart'), {
            type: 'line',
            data: {
                labels: @json($labels),
                datasets: [{
                    label: 'عدد الشكاوى',
                    data: @json($data),
                    borderColor: '#2563eb',
                    backgroundColor: 'rgba(37,99,235,.15)',
                    borderWidth: 3,
                    tension: .4,
                    fill: true,
                    pointRadius: 4
                }]
            },
            options: {
                scales: {
                    y: { beginAtZero: true, ticks: { stepSize: 1 } }
                }
            }
        });
    </script>
@endsection