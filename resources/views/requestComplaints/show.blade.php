@extends('layouts.app')

@section('content')
    <link rel="stylesheet" href="{{ asset('css/systemComplaints/show.css') }}">

    <div class="complaint-show">

        <!-- ===== Header ===== -->
        <div class="header-card">
            <div>
                <h1>{{ $requestComplaint->title }}</h1>
                <p>نوع البلاغ: <strong>{{ $requestComplaint->type }}</strong></p>
                <p>بلاغ متعلق بطلب رقم: 
                    <a href="{{ route('requests.show', $requestComplaint->request_id) }}" style="color: #4f46e5; text-decoration: underline; font-weight: bold; font-size: 1.1em;">
                        #{{ $requestComplaint->request_id }}
                    </a>
                </p>
            </div>

            <span class="badge {{ $requestComplaint->status }}">
                @if($requestComplaint->status == 'pending') قيد المراجعة @endif
                @if($requestComplaint->status == 'in_progress') قيد المعالجة @endif
                @if($requestComplaint->status == 'resolved') محلولة @endif
            </span>
        </div>

        <!-- ===== Stepper ===== -->
        <div class="stepper-card">
            <ul class="stepper">
                @foreach (['pending', 'in_progress', 'resolved'] as $step)
                    <li class="
                            {{ $requestComplaint->status == $step ? 'active' : '' }}
                            {{ array_search($requestComplaint->status, $statusSteps) > array_search($step, $statusSteps) ? 'completed' : '' }}
                        ">
                        @if($step == 'pending') قيد المراجعة @endif
                        @if($step == 'in_progress') قيد المعالجة @endif
                        @if($step == 'resolved') محلولة @endif
                    </li>
                @endforeach
            </ul>
        </div>

        <!-- ===== Content ===== -->
        <div class="content-grid">

            <div class="info-card">
                <h3>تفاصيل البلاغ</h3>

                <p class="content">
                    {{ $requestComplaint->content }}
                </p>

                <ul class="meta">
                    <li style="background-color: #f3f4f6; padding: 10px; border-radius: 8px; margin-bottom: 10px;">
                        🚨 <strong>مُرسل البلاغ:</strong> 
                        {{ $requestComplaint->user->name ?? 'غير متوفر' }}
                        @if($requestComplaint->user_id == $requestComplaint->request->user_id)
                            <span style="background-color: #ec4899; color: white; padding: 2px 6px; border-radius: 4px; font-size: 0.85em; margin-right: 5px;">تطبيق الطالب</span>
                        @else
                            <span style="background-color: #6366f1; color: white; padding: 2px 6px; border-radius: 4px; font-size: 0.85em; margin-right: 5px;">تطبيق المزود</span>
                        @endif
                    </li>
                    <li>👤 طالب الخدمة (صاحب الطلب الأساسي): <strong>{{ $requestComplaint->request->user->name ?? 'غير متوفر' }}</strong></li>
                    <li>👤 مقدم الخدمة (المكلف بالطلب): <strong>{{ $requestComplaint->request->serviceProvider()->name ?? 'غير مكلف حالياً' }}</strong></li>
                    <li>📅 التاريخ: {{ $requestComplaint->created_at->format('Y-m-d H:i') }}</li>
                </ul>
            </div>

            <!-- ===== Actions ===== -->
            <div class="action-card">
                <h3>إدارة الحالة</h3>

                @if(session('success'))
                    <div class="alert success">{{ session('success') }}</div>
                @endif

                <form method="POST" action="{{ route('request-complaints.update-status', $requestComplaint) }}">
                    @csrf
                    @method('PATCH')

                    <label>تغيير الحالة</label>
                    <select name="status">
                            <option value="pending" {{ $requestComplaint->status == 'pending' ? 'selected' : '' }}>قيد المراجعة</option>
                            <option value="in_progress" {{ $requestComplaint->status == 'in_progress' ? 'selected' : '' }}>قيد المعالجة</option>
                            <option value="resolved" {{ $requestComplaint->status == 'resolved' ? 'selected' : '' }}>محلولة</option>
                    </select>

                    <button type="submit">تحديث الحالة</button>
                </form>
            </div>

        </div>

    </div>

@endsection