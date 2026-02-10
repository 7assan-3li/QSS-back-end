@extends('layouts.app')

@section('content')
    <link rel="stylesheet" href="{{ asset('css/verificationRequests/index.css') }}">

    <div class="provider-requests">

        <!-- ===== Stats ===== -->
        <div class="stats-grid">

            <div class="stat-card">
                <h4>إجمالي الطلبات</h4>
                <span>{{ $stats['total'] }}</span>
            </div>

            <div class="stat-card warning">
                <h4>قيد المراجعة</h4>
                <span>{{ $stats['pending'] }}</span>
            </div>

            <div class="stat-card success">
                <h4>مقبولة</h4>
                <span>{{ $stats['accepted'] }}</span>
            </div>

            <div class="stat-card danger">
                <h4>مرفوضة</h4>
                <span>{{ $stats['rejected'] }}</span>
            </div>

        </div>

        <!-- ===== Charts ===== -->
        <div class="charts-grid">

            <div class="chart-card">
                <h3>توزيع حالات التحقق</h3>
                <canvas id="statusChart"></canvas>
            </div>

            <div class="chart-card">
                <div class="chart-actions">
                    <a href="?days=7" class="{{ $days == 7 ? 'active' : '' }}">7 أيام</a>
                    <a href="?days=30" class="{{ $days == 30 ? 'active' : '' }}">30 يوم</a>
                    <a href="?days=90" class="{{ $days == 90 ? 'active' : '' }}">90 يوم</a>
                </div>

                <h3>طلبات التحقق خلال الفترة</h3>
                <canvas id="dailyChart"></canvas>
            </div>

        </div>

        <!-- ===== Table ===== -->
        <div class="table-card">
            <h2>طلبات التحقق</h2>

            <table>
                <thead>
                    <tr>
                        <th>#</th>
                        <th>المستخدم</th>
                        <th>المحتوى</th>
                        <th>الحالة</th>
                        <th>التاريخ</th>
                        <th>التحكم</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($requests as $request)
                        <tr class="row-{{ $request->status }}">
                            <td>{{ $request->id }}</td>
                            <td>{{ $request->user->name }}</td>
                            <td>{{ $request->content }}</td>

                            <td>
                                <span class="badge {{ $request->status }}">
                                    {{ __($request->status) }}
                                </span>
                            </td>

                            <td>{{ $request->created_at->format('Y-m-d') }}</td>

                            <td class="actions">
                                <a href="{{ route('verification-requests.show', $request->id) }}" class="btn-view">
                                    👁️ عرض
                                </a>
                                @if($request->status == 'pending')
                                    <form method="POST" action="{{ route('verification-requests.accept', $request->id) }}"
                                        onsubmit="return confirm('هل أنت متأكد من قبول الطلب؟')">
                                        @csrf
                                        <button class="btn success">قبول</button>
                                    </form>

                                    <form method="POST" action="{{ route('verification-requests.reject', $request->id) }}"
                                        onsubmit="return confirm('هل أنت متأكد من رفض الطلب؟')">
                                        @csrf
                                        <button class="btn danger">رفض</button>
                                    </form>
                                @else
                                    —
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="empty">لا توجد طلبات</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            {{ $requests->links() }}
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
                    backgroundColor: ['#facc15', '#22c55e', '#ef4444']
                }]
            },
            options: {
                plugins: { legend: { position: 'bottom' } }
            }
        });

        /* ===== Daily Chart ===== */
        new Chart(document.getElementById('dailyChart'), {
            type: 'line',
            data: {
                labels: @json($labels),
                datasets: [{
                    label: 'طلبات التحقق',
                    data: @json($data),
                    borderWidth: 3,
                    tension: .4,
                    fill: true
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