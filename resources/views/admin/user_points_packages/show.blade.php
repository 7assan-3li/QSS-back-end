@extends('layouts.app')

@section('title', 'تفاصيل طلب الشحن')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/admin/user_points_packages.css') }}">
@endsection

@section('content')
    <div class="page-header">
        <div>
            <h1>📦 تفاصيل طلب الشحن #{{ $subscription->id }}</h1>
            <p>مراجعة بيانات الدفع وتفعيل الباقة للمستخدم</p>
        </div>
        <a href="{{ route('admin.user-points-packages.index') }}" class="btn-detail">🔙 العودة للقائمة</a>
    </div>

    <div class="request-details-grid">
        <div class="detail-card">
            <h3>💳 معلومات الدفع والسند</h3>
            
            <div class="info-row">
                <span class="info-label">اسم البنك:</span>
                <span class="info-value">{{ $subscription->bank_name }}</span>
            </div>
            
            <div class="info-row">
                <span class="info-label">رقم السند / الحوالة:</span>
                <span class="info-value"><code>{{ $subscription->bond_number }}</code></span>
            </div>

            <div class="bond-image-container">
                <p class="info-label">صورة السند:</p>
                <a href="{{ asset('storage/' . $subscription->bond_image) }}" target="_blank">
                    <img src="{{ asset('storage/' . $subscription->bond_image) }}" alt="Bond Image">
                </a>
                <p style="font-size: 12px; color: #6b7280; margin-top: 10px;">انقر على الصورة لفتحها في نافذة جديدة</p>
            </div>

            @if($subscription->status == 'pending')
                <div class="action-section">
                    <form action="{{ route('admin.user-points-packages.approve', $subscription->id) }}" method="POST" style="flex: 1;">
                        @csrf
                        @method('PATCH')
                        <button type="submit" class="btn-approve" onclick="return confirm('هل أنت متأكد من صحة السند وإضافة النقاط للمستخدم؟')">
                            ✅ الموافقة وتفعيل النقاط
                        </button>
                    </form>

                    <button type="button" class="btn-reject-trigger" onclick="document.getElementById('reject-form').style.display='block'">
                        ❌ رفض الطلب
                    </button>
                </div>

                <div id="reject-form" class="reject-form" style="display: none;">
                    <form action="{{ route('admin.user-points-packages.reject', $subscription->id) }}" method="POST">
                        @csrf
                        @method('PATCH')
                        <label>سبب الرفض (سيظهر للمستخدم):</label>
                        <textarea name="admin_note" rows="3" required placeholder="مثال: صورة السند غير واضحة، أو المبلغ غير مكتمل..."></textarea>
                        <div style="display: flex; gap: 10px;">
                            <button type="submit" class="btn-reject-trigger">تأكيد الرفض</button>
                            <button type="button" class="btn-detail" onclick="document.getElementById('reject-form').style.display='none'">إلغاء</button>
                        </div>
                    </form>
                </div>
            @else
                <div style="margin-top: 30px; padding: 20px; background: #f9fafb; border-radius: 12px; border: 1px solid #e5e7eb;">
                    <p><strong>الحالة النهائية:</strong> 
                        <span class="status-label status-{{ $subscription->status }}">
                            {{ $subscription->status == 'approved' ? 'تم القبول' : 'تم الرفض' }}
                        </span>
                    </p>
                    <p><strong>بواسطة:</strong> {{ $subscription->admin->name ?? 'النظام' }}</p>
                    @if($subscription->admin_note)
                        <p><strong>ملاحظة الإدارة:</strong> {{ $subscription->admin_note }}</p>
                    @endif
                </div>
            @endif
        </div>

        <div>
            <div class="detail-card" style="margin-bottom: 20px;">
                <h3>👤 العميل</h3>
                <p><strong>{{ $subscription->user->name }}</strong></p>
                <p style="color: #6b7280;">{{ $subscription->user->email }}</p>
            </div>

            <div class="detail-card">
                <h3>💎 الباقة المختارة</h3>
                <p><strong>{{ $subscription->package->name }}</strong></p>
                <p style="font-size: 24px; color: #2563eb; font-weight: bold; margin: 10px 0;">
                    {{ number_format($subscription->package->points + $subscription->package->bonus_points) }} نقطة
                </p>
                <p>السعر: {{ number_format($subscription->package->price, 2) }} ر.س</p>
            </div>
        </div>
    </div>
@endsection
