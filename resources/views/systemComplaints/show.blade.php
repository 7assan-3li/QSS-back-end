@extends('layouts.app')

@section('content')
    <link rel="stylesheet" href="{{ asset('css/systemComplaints/show.css') }}">

    <div class="complaint-show">

        <!-- ===== Header ===== -->
        <div class="header-card">
            <div>
                <h1>{{ $systemComplaint->title }}</h1>
                <p>نوع الشكوى: <strong>{{ $systemComplaint->type }}</strong></p>
            </div>

            <span class="badge {{ $systemComplaint->status }}">
                {{ __($systemComplaint->status) }}
            </span>
        </div>

        <!-- ===== Stepper ===== -->
        <div class="stepper-card">
            <ul class="stepper">
                @foreach ($statusSteps as $step)
                    <li class="
                            {{ $systemComplaint->status == $step ? 'active' : '' }}
                            {{ array_search($systemComplaint->status, $statusSteps) > array_search($step, $statusSteps) ? 'completed' : '' }}
                        ">
                        {{ __($step) }}
                    </li>
                @endforeach
            </ul>
        </div>

        <!-- ===== Content ===== -->
        <div class="content-grid">

            <div class="info-card">
                <h3>تفاصيل الشكوى</h3>

                <p class="content">
                    {{ $systemComplaint->content }}
                </p>

                <ul class="meta">
                    <li>👤 المستخدم: {{ $systemComplaint->user->name }}</li>
                    <li>📧 البريد: {{ $systemComplaint->user->email }}</li>
                    <li>📅 التاريخ: {{ $systemComplaint->created_at->format('Y-m-d H:i') }}</li>
                </ul>
            </div>

            <!-- ===== Actions ===== -->
            <div class="action-card">
                <h3>إدارة الحالة</h3>

                @if(session('success'))
                    <div class="alert success">{{ session('success') }}</div>
                @endif

                <form method="POST" action="{{ route('system-complaints.update-status', $systemComplaint) }}">
                    @csrf
                    @method('PATCH')

                    <label>تغيير الحالة</label>
                    <select name="status">
                        @foreach (\App\constant\SystemComplaintStatus::all() as $status)
                            <option value="{{ $status }}" {{ $systemComplaint->status == $status ? 'selected' : '' }}>
                                {{ __($status) }}
                            </option>
                        @endforeach
                    </select>

                    <button type="submit">تحديث الحالة</button>
                </form>
            </div>

        </div>

        <!-- ===== Analytics ===== -->
        <div class="chart-card">
            <h3>تحليل الشكوى</h3>
            <canvas id="complaintChart"></canvas>
        </div>

    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>
        const ctx = document.getElementById('complaintChart');

        const waitingHours = @json($waitingHours);
        const processingHours = @json($processingHours);

        if (ctx) {
            new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: ['مدة الانتظار (بالساعات)', 'مدة المعالجة (بالساعات)'],
                    datasets: [{
                        data: [waitingHours, processingHours],
                        backgroundColor: ['#facc15', '#22c55e'],
                        borderRadius: 8,
                        barThickness: 40
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: { display: false },
                        tooltip: {
                            callbacks: {
                                label: function (context) {
                                    return context.raw + ' ساعة';
                                }
                            }
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                callback: value => value + 'h'
                            }
                        }
                    }
                }
            });
        }
    </script>

@endsection