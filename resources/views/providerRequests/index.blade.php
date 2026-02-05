@extends('layouts.app')

@section('content')
    <link rel="stylesheet" href="{{ asset('css/providerRequests/index.css') }}">

    <div class="provider-requests">

        <!-- ===== Stats ===== -->
        <div class="stats-grid">

            <a href="{{ route('provider-requests.index') }}" class="stat-card">
                <h4>إجمالي الطلبات</h4>
                <span>{{ $stats['total'] }}</span>
            </a>

            <a href="{{ route('provider-requests.index', ['status' => 'pending']) }}" class="stat-card warning">
                <h4>قيد المراجعة</h4>
                <span>{{ $stats['pending'] }}</span>
            </a>

            <a href="{{ route('provider-requests.index', ['status' => 'accepted']) }}" class="stat-card success">
                <h4>مقبولة</h4>
                <span>{{ $stats['accepted'] }}</span>
            </a>

            <a href="{{ route('provider-requests.index', ['status' => 'rejected']) }}" class="stat-card danger">
                <h4>مرفوضة</h4>
                <span>{{ $stats['rejected'] }}</span>
            </a>

        </div>

        <!-- ===== Charts ===== -->

        <div class="charts-grid">

            <div class="chart-card">
                <h3>توزيع حالات الطلبات</h3>
                <canvas id="statusChart"></canvas>
            </div>
            <div class="chart-card">
                <div class="chart-actions">
                    <a href="?days=7" class="{{ $days == 7 ? 'active' : '' }}">7 أيام</a>
                    <a href="?days=30" class="{{ $days == 30 ? 'active' : '' }}">30 يوم</a>
                    <a href="?days=90" class="{{ $days == 90 ? 'active' : '' }}">90 يوم</a>
                </div>
                <h3>الطلبات خلال آخر 7 أيام</h3>
                <canvas id="dailyChart"></canvas>
            </div>

        </div>




        <!-- ===== Table ===== -->
        <div class="table-card">
            <h2>طلبات مزودي الخدمات</h2>

            <table>
                <thead>
                    <tr>
                        <th>#</th>
                        <th>الاسم</th>
                        <th>المستخدم</th>
                        <th>الحالة</th>
                        <th>المشرف</th>
                        <th>التاريخ</th>
                        <th>التحكم</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse ($requests as $request)
                        <tr class="row-{{ $request->status }}">
                            <td data-label="#"> {{ $request->id }}</td>
                            <td data-label="الاسم">{{ $request->name }}</td>
                            <td data-label="المستخدم">{{ $request->user->name }}</td>

                            <td data-label="الحالة">
                                <span class="badge {{ $request->status }}">
                                    {{ __($request->status) }}
                                </span>
                            </td>

                            <td data-label="المشرف">
                                {{ $request->admin->name ?? '—' }}
                            </td>

                            <td data-label="التاريخ">
                                {{ $request->created_at->format('Y-m-d') }}
                            </td>

                            <td data-label="التحكم" class="actions">
                                <a href="{{ route('provider-requests.show', $request->id) }}">عرض</a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="empty">لا توجد طلبات</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>
        /* ===== Status Chart ===== */
        new Chart(document.getElementById('statusChart'), {
            type: 'doughnut',
            data: {
                labels: ['قيد المراجعة', 'مقبولة', 'مرفوضة'],
                datasets: [{
                    data: [
                                    {{ $stats['pending'] }},
                                    {{ $stats['accepted'] }},
                        {{ $stats['rejected'] }}
                    ],
                    backgroundColor: [
                        '#facc15', // pending
                        '#22c55e', // accepted
                        '#ef4444'  // rejected
                    ]
                }]
            },
            options: {
                plugins: {
                    legend: { position: 'bottom' }
                }
            }
        });

        /* ===== Daily Chart ===== */
        new Chart(document.getElementById('dailyChart'), {
            type: 'line',
            data: {
                labels: @json($labels),
                datasets: [{
                    label: 'عدد الطلبات',
                    data: @json($data),
                    borderColor: '#2563eb',
                    backgroundColor: 'rgba(37,99,235,.15)',
                    borderWidth: 3,
                    tension: 0.4,
                    fill: true,
                    pointRadius: 5,
                    pointHoverRadius: 7
                }]
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: { stepSize: 1 }
                    }
                }
            }
        });
    </script>
@endsection