<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <title>تأكيد البريد الإلكتروني</title>
</head>
<body style="margin:0;background:#f4f6f8;font-family:Segoe UI,Tahoma,Arial;">

<table width="100%" cellpadding="0" cellspacing="0">
    <tr>
        <td align="center" style="padding:40px 0">

            <table width="600" cellpadding="0" cellspacing="0" style="background:#ffffff;border-radius:16px;overflow:hidden">

                <!-- Header -->
                <tr>
                    <td style="background:#111827;color:#ffffff;padding:24px;text-align:center;font-size:20px;font-weight:bold">
                        QSS App
                    </td>
                </tr>

                <!-- Content -->
                <tr>
                    <td style="padding:30px;color:#111827">

                        <h2 style="margin-top:0">مرحباً {{ $user->name }} 👋</h2>

                        <p style="font-size:15px;line-height:1.8;color:#374151">
                            شكراً لتسجيلك في تطبيق <strong>QSS</strong>.
                            لتأكيد بريدك الإلكتروني، يرجى استخدام رمز التحقق التالي:
                        </p>

                        <div style="margin:30px 0;text-align:center">
                            <span style="
                                display:inline-block;
                                padding:15px 30px;
                                font-size:26px;
                                letter-spacing:4px;
                                background:#2563eb;
                                color:#ffffff;
                                border-radius:12px;
                                font-weight:bold">
                                {{ $code }}
                            </span>
                        </div>

                        <p style="font-size:14px;color:#6b7280">
                            الرمز صالح لمدة <strong>10 دقائق</strong>.
                            إذا لم تطلب هذا الرمز، يمكنك تجاهل هذه الرسالة.
                        </p>

                        <p style="margin-top:30px">
                            مع تحياتنا 🌟<br>
                            فريق QSS
                        </p>

                    </td>
                </tr>

                <!-- Footer -->
                <tr>
                    <td style="background:#f9fafb;padding:15px;text-align:center;font-size:12px;color:#6b7280">
                        © {{ date('Y') }} QSS App. All rights reserved.
                    </td>
                </tr>

            </table>

        </td>
    </tr>
</table>

</body>
</html>
