@extends('layouts.app')

@section('content')
    <link rel="stylesheet" href="{{ asset('css/requests/show.css') }}">

    <div class="page-container">

        {{-- Breadcrumb --}}
        <div class="breadcrumb">
            <a href="{{ route('dashboard') }}">الرئيسية</a>
            <span>/</span>
            <a href="{{ route('requests.index') }}">الطلبات</a>
            <span>/</span>
            طلب #{{ $request->id }}
        </div>

        {{-- Request Info --}}
        <div class="card">

            <div class="card-header">
                <h2>📄 معلومات الطلب</h2>
                <span class="status {{ $request->status }}">
                    {{ $request->status }}
                </span>
            </div>

            <div class="info-grid">
                <div><strong>العميل:</strong> {{ $request->user->name }}</div>
                <div><strong>تاريخ الطلب:</strong> {{ $request->created_at->format('Y-m-d') }}</div>
                <div><strong>الإجمالي:</strong> {{ number_format($request->total_price, 2) }} ر.ي</div>
                <div><strong>العمولة (10%):</strong> {{ number_format($commission, 2) }} ر.ي</div>
                <div>
                    <strong>حالة العمولة:</strong>
                    @if ($request->commission_paid)
                        <span class="paid">مدفوعة</span>
                    @else
                        <span class="unpaid">غير مدفوعة</span>
                    @endif
                </div>

            </div>
            @if (!$request->commission_paid)
                <div class="payment-card">
                    <div class="payment-info">
                        <h4>💰 حالة العمولة</h4>
                        <p>
                            العمولة لم يتم تأكيد دفعها بعد.
                            <br>
                            عند التأكيد، سيتم اعتبار الطلب مدفوع نهائيًا.
                        </p>
                    </div>

                    <form action="{{ route('requests.markPaid', $request->id) }}" method="POST"
                        onsubmit="return confirmPayment()">
                        @csrf
                        @method('PATCH')

                        <button type="submit" class="btn-paid">
                            ✔️ تأكيد الدفع
                        </button>
                    </form>
                </div>
            @endif

        </div>

        {{-- Services --}}
        <div class="card">
            <h3>🛠️ الخدمات</h3>

            <div class="services-list">
                @foreach ($request->services as $service)
                    <div class="service-item">
                        <div>
                            <strong>{{ $service->name }}</strong>
                            @if ($service->pivot->is_main)
                                <span class="main">رئيسية</span>
                            @endif
                        </div>
                        <div>الكمية: {{ $service->pivot->quantity }}</div>
                        <div>السعر: {{ number_format($service->price, 2) }} ر.ي</div>
                    </div>
                @endforeach
            </div>
        </div>

        {{-- Commission Bonds --}}
        <div class="card">
            <h3>💳 سندات العمولة</h3>

            @if ($request->commissionBonds->count())
                <div class="bonds-grid">
                    @foreach ($request->commissionBonds as $bond)
                        <div class="bond-card">
                            <img src="{{ asset('storage/' . $bond->image_path) }}">

                            <div class="bond-info">
                                <div><strong>رقم السند:</strong> {{ $bond->bond_number ?? '—' }}</div>
                                <div><strong>الوصف:</strong> {{ $bond->description ?? '—' }}</div>
                                <div>
                                    <strong>الحالة:</strong>
                                    <span class="bond-status {{ $bond->status }}">
                                        {{ $bond->status }}
                                    </span>


                                </div>
                            </div>
                        </div>
                        <div class="bond-actions">

                            @if ($bond->status === 'pending')
                                <form action="{{ route('commission-bonds.approve', $bond) }}" method="POST"
                                    onsubmit="return confirm('هل أنت متأكد من قبول السند؟')">
                                    @csrf
                                    @method('PATCH')
                                    <button class="btn-approve">قبول</button>
                                </form>

                                <form action="{{ route('commission-bonds.reject', $bond) }}" method="POST"
                                    onsubmit="return confirm('هل أنت متأكد من رفض السند؟')">
                                    @csrf
                                    @method('PATCH')
                                    <button class="btn-reject">رفض</button>
                                </form>
                            @endif

                        </div>
                    @endforeach
                </div>
            @else
                <p class="empty">لا توجد سندات عمولة لهذا الطلب</p>
            @endif
        </div>

    </div>
@endsection

@section('js')
    <script>
        function confirmPayment() {
            return confirm(
                "⚠️ تأكيد الدفع\n\n" +
                "هل أنت متأكد أن العمولة تم دفعها بالفعل؟\n" +
                "لا يمكن التراجع بعد التأكيد."
            );
        }
    </script>
@endsection
