@extends('layouts.app')

@section('title', 'معالجة طلب السحب')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/admin/user_points_packages.css') }}">
@endsection

@section('content')
    <div class="page-header">
        <div>
            <h1>💸 معالجة طلب السحب #{{ $withdrawal->id }}</h1>
            <p>تأكيد تحويل المبلغ للمزود وإرفاق سند الإيداع</p>
        </div>
        <a href="{{ route('admin.withdrawals.index') }}" class="btn-detail">🔙 العودة للقائمة</a>
    </div>

    <div class="request-details-grid">
        <div class="detail-card">
            <h3>📑 بيانات السحب</h3>
            
            <div class="info-row">
                <span class="info-label">المبلغ المطلوب سحبه:</span>
                <span class="info-value" style="font-size: 20px; color: #b91c1c;">{{ number_format($withdrawal->amount, 2) }} ر.س</span>
            </div>

            <div class="info-row">
                <span class="info-label">تاريخ الطلب:</span>
                <span class="info-value">{{ $withdrawal->created_at->format('Y-m-d H:i') }}</span>
            </div>

            @if($withdrawal->status == 'pending')
                <div style="margin-top: 30px; border-top: 2px solid #f3f4f6; padding-top: 20px;">
                    <h3>✅ إجراء الموافقة (إيداع المبلغ)</h3>
                    <p style="color: #6b7280; font-size: 13px; margin-bottom: 20px;">قم بتحويل المبلغ لحساب المزود البنكي، ثم ارفع صورة السند أدناه.</p>
                    
                    <form action="{{ route('admin.withdrawals.approve', $withdrawal->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PATCH')
                        
                        <div style="margin-bottom: 15px;">
                            <label style="display: block; font-weight: 600; margin-bottom: 5px;">رقم عملية التحويل / السند:</label>
                            <input type="text" name="bond_number" required style="width: 100%; padding: 10px; border-radius: 8px; border: 1px solid #d1d5db;">
                        </div>

                        <div style="margin-bottom: 20px;">
                            <label style="display: block; font-weight: 600; margin-bottom: 5px;">صورة السند / الإيصال:</label>
                            <input type="file" name="bond_image" required accept="image/*" style="width: 100%; padding: 10px; border-radius: 8px; border: 1px solid #d1d5db;">
                        </div>

                        <button type="submit" class="btn-approve" style="width: 100%;">
                            ✅ تأكيد التحويل وخصم النقاط
                        </button>
                    </form>

                    <div style="margin-top: 15px;">
                        <button type="button" class="btn-reject-trigger" style="width: 100%;" onclick="document.getElementById('reject-form').style.display='block'">
                            ❌ رفض الطلب
                        </button>
                    </div>

                    <div id="reject-form" class="reject-form" style="display: none; margin-top: 15px;">
                        <form action="{{ route('admin.withdrawals.reject', $withdrawal->id) }}" method="POST">
                            @csrf
                            @method('PATCH')
                            <label>سبب الرفض:</label>
                            <textarea name="admin_note" rows="3" required placeholder="اكتب سبب الرفض هنا..."></textarea>
                            <div style="display: flex; gap: 10px;">
                                <button type="submit" class="btn-reject-trigger">تأكيد الرفض</button>
                                <button type="button" class="btn-detail" onclick="document.getElementById('reject-form').style.display='none'">إلغاء</button>
                            </div>
                        </form>
                    </div>
                </div>
            @else
                <div style="margin-top: 30px; padding: 20px; background: #f9fafb; border-radius: 12px; border: 1px solid #e5e7eb;">
                    <p><strong>الحالة النهائية:</strong> 
                        <span class="status-label status-{{ $withdrawal->status }}">
                            {{ $withdrawal->status == 'approved' ? 'تم القبول والتحويل' : 'تم الرفض' }}
                        </span>
                    </p>
                    <p><strong>بواسطة:</strong> {{ $withdrawal->admin->name ?? 'النظام' }}</p>
                    
                    @if($withdrawal->status == 'approved')
                        <p><strong>رقم السند:</strong> <code>{{ $withdrawal->bond_number }}</code></p>
                        <div class="bond-image-container">
                            <p class="info-label">صورة السند:</p>
                            <a href="{{ asset('storage/' . $withdrawal->bond_image) }}" target="_blank">
                                <img src="{{ asset('storage/' . $withdrawal->bond_image) }}" alt="Bond Image">
                            </a>
                        </div>
                    @else
                        <p><strong>سبب الرفض:</strong> {{ $withdrawal->admin_note }}</p>
                    @endif
                </div>
            @endif
        </div>

        <div>
            <div class="detail-card" style="margin-bottom: 20px;">
                <h3>👤 المزود (طالب السحب)</h3>
                <p><strong>{{ $withdrawal->user->name }}</strong></p>
                <p style="color: #6b7280;">{{ $withdrawal->user->email }}</p>
                <hr style="margin: 15px 0; border: none; border-top: 1px solid #f3f4f6;">
                <p><strong>الرصيد الحالي (قبل الخصم):</strong></p>
                <p style="font-size: 24px; color: #166534; font-weight: bold;">{{ number_format($withdrawal->user->paid_points, 2) }} ر.س</p>
            </div>

            <div class="detail-card" style="background: #fffbeb; border: 1px solid #fef3c7;">
                <h3 style="color: #92400e;">⚠️ تنبيه</h3>
                <p style="font-size: 13px; color: #92400e;">
                    عند الموافقة على الطلب، سيتم خصم المبلغ فوراً من محفظة المزود. تأكد من إتمام الحوالة البنكية بنجاح قبل الضغط على زر الموافقة.
                </p>
            </div>
        </div>
    </div>
@endsection
