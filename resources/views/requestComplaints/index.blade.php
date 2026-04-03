@extends('layouts.app')

@section('content')
    <link rel="stylesheet" href="{{ asset('css/systemComplaints/index.css') }}">

    <div class="system-complaints">

        <!-- ===== Stats ===== -->
        <div class="stats-grid">
            <a class="stat-card">
                <h4>إجمالي البلاغات</h4>
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

            <a href="?status=resolved" class="stat-card success">
                <h4>محلولة</h4>
                <span>{{ $stats['completed'] }}</span>
            </a>
        </div>

        <!-- ===== Charts ===== -->
        <div class="charts-grid">

            <div class="chart-card">
                <h3>توزيع حالات البلاغات</h3>
                <canvas id="statusChart"></canvas>
            </div>

            <div class="chart-card">
                <div class="chart-actions">
                    <a href="?days=7" class="{{ $days == 7 ? 'active' : '' }}">7 أيام</a>
                    <a href="?days=30" class="{{ $days == 30 ? 'active' : '' }}">30 يوم</a>
                    <a href="?days=90" class="{{ $days == 90 ? 'active' : '' }}">90 يوم</a>
                </div>

                <h3>البلاغات خلال الفترة</h3>
                <canvas id="dailyChart"></canvas>
            </div>

        </div>

        <!-- ===== Table ===== -->
        <div class="table-card">
            <h2>بلاغات الطلبات</h2>

            <table>
                <thead>
                    <tr>
                        <th>#</th>
                        <th>تم التبليغ على طلب رقم</th>
                        <th>العنوان</th>
                        <th>النوع</th>
                        <th>مرسل البلاغ</th>
                        <th>الحالة</th>
                        <th>التاريخ</th>
                        <th>التحكم</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse ($complaints as $complaint)
                        <tr class="row-{{ $complaint->status }}">
                            <td data-label="#">{{ $complaint->id }}</td>
                            <td data-label="طلب رقم">
                                <a href="{{ route('requests.show', $complaint->request_id) }}" style="color: #4f46e5; text-decoration: underline; font-weight: bold;">
                                    #{{ $complaint->request_id }}
                                </a>
                            </td>
                            <td data-label="العنوان">{{ $complaint->title }}</td>
                            <td data-label="النوع">{{ $complaint->type }}</td>
                            <td data-label="المرسل">
                                {{ $complaint->user->name ?? 'غير متوفر' }}
                                <br>
                                @if($complaint->user_id == $complaint->request->user_id)
                                    <span style="font-size: 0.8em; color: #ec4899; font-weight: bold;">(طالب الخدمة)</span>
                                @else
                                    <span style="font-size: 0.8em; color: #6366f1; font-weight: bold;">(مزود الخدمة)</span>
                                @endif
                            </td>

                            <td data-label="الحالة">
                                <span class="badge {{ $complaint->status }}">
                                    @if($complaint->status == 'pending') قيد المراجعة @endif
                                    @if($complaint->status == 'in_progress') قيد المعالجة @endif
                                    @if($complaint->status == 'resolved') محلولة @endif
                                </span>
                            </td>

                            <td data-label="التاريخ">{{ $complaint->created_at->format('Y-m-d') }}</td>

                            <td data-label="التحكم" class="actions">
                                <a href="{{ route('request-complaints.show', $complaint) }}">عرض</a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="empty">لا توجد بلاغات للطلبات</td>
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
                labels: ['قيد المراجعة', 'قيد المعالجة', 'محلولة'],
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
                    label: 'عدد البلاغات',
                    data: @json($data),
                    borderColor: '#ec4899',
                    backgroundColor: 'rgba(236,72,153,.15)',
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