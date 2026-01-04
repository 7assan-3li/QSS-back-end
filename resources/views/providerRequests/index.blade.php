@extends('layouts.app')

@section('content')
<link rel="stylesheet" href="{{ asset('css/providerRequests/index.css') }}">

<div class="provider-requests">

    <!-- ===== Reports ===== -->
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
                    <tr>
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
@endsection
