<?php

namespace App\Http\Controllers;

use App\constant\Role;
use App\Jobs\SendEmailVerificationJob;
use App\Models\User;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Jobs\SendEmailVerificationCode;
use App\Models\EmailVerificationCode;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\RateLimiter;
class UserController extends Controller
{
    use AuthorizesRequests;

    // public function apiRegister(Request $request)
    // {
    //     $request->validate([
    //         'name' => 'required|string|max:255',
    //         'email' => 'required|email|unique:users,email',
    //         'password' => 'required|min:6|confirmed',
    //         'seeker_policy' => 'required|accepted'
    //     ]);

    //     $user = User::create([
    //         'name' => $request->name,
    //         'email' => $request->email,
    //         'password' => Hash::make($request->password),
    //         'seeker_policy' => true,
    //     ]);

    //     // إنشاء توكن مباشرة بعد التسجيل
    //     $token = $user->createToken('api-token')->plainTextToken;

    //     // أرسل الإيميل عبر Queue
    //     SendEmailVerificationJob::dispatch($user);

    //     return response()->json([
    //         'message' => 'Account created successfully',
    //         'token' => $token,
    //         'user' => $user,
    //         'email_verified' => $user->hasVerifiedEmail()
    //     ], 201);
    // }

    public function apiRegister(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6|confirmed',
            'seeker_policy' => 'required|accepted'
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'seeker_policy' => true,
        ]);

        $code = random_int(100000, 999999);
        EmailVerificationCode::create([
            'user_id' => $user->id,
            'code' => $code,
            'expires_at' => now()->addMinutes(10)
        ]);

        SendEmailVerificationCode::dispatch($user, $code);

        $token = $user->createToken('api-token')->plainTextToken;

        $user->profile()->create([
        ]);

        // $user->sendEmailVerificationNotification();
        return response()->json([
            'message' => 'تم إنشاء الحساب، تحقق من بريدك الإلكتروني',
            'token' => $token,
            'user' => $user,
            'email_verified' => false
        ], 201);
    }
    public function apiLogin(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:8',
        ]);

        if (!Auth::attempt($request->only('email', 'password'))) {
            return response()->json(['message' => 'Invalid credentials'], 401);
        }

        $user = Auth
            ::user();
        $token = $user->createToken('api-token')->plainTextToken;

        return response()->json([
            'token' => $token,
            'user' => $user,
            'email_verified' => $user->hasVerifiedEmail()
        ]);
    }

    // API LOGOUT
    public function apiLogout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();
        return response()->json(['message' => 'Logged out']);
    }



    // wep functions ...

public function index()
{
    $this->authorize('viewAny', User::class);

    $users = User::all();

    // تسجيل المستخدمين حسب الشهور
    $usersChart = User::selectRaw('MONTH(created_at) as month, COUNT(*) as count')
        ->whereYear('created_at', Carbon::now()->year)
        ->groupBy('month')
        ->orderBy('month')
        ->pluck('count', 'month')
        ->mapWithKeys(function ($count, $month) {
            return [
                Carbon::create()->month($month)->translatedFormat('F') => $count
            ];
        });

    // توزيع المستخدمين حسب الدور
    $rolesChart = User::selectRaw('role, COUNT(*) as count')
        ->groupBy('role')
        ->pluck('count', 'role');

    // تقارير ذكية
    $todayUsers = User::whereDate('created_at', today())->count();

    $weekUsers = User::whereBetween('created_at', [
        now()->startOfWeek(),
        now()->endOfWeek()
    ])->count();

    $currentMonth = User::whereMonth('created_at', now()->month)->count();
    $lastMonth = User::whereMonth('created_at', now()->subMonth()->month)->count();

    $growth = $lastMonth > 0
        ? round((($currentMonth - $lastMonth) / $lastMonth) * 100, 1)
        : 100;

    return view('users.index', compact(
        'users',
        'usersChart',
        'rolesChart',
        'todayUsers',
        'weekUsers',
        'growth'
    ));
}


    public function show(User $user)
    {
        $this->authorize('view', $user);

        // Eager load everything for the Executive Identity Matrix
        $user->load([
            'profile',
            'verificationRequests' => function($q) { $q->latest()->limit(5); }
        ]);

        $user->loadCount(['requests', 'services', 'verificationRequests']);

        return view('users.show', [
            'user' => $user,
        ]);
    }
    public function edit(User $user)
    {
        $this->authorize('update', $user);
        return view('users.edit', ['user' => $user]);
    }
    public function update(Request $request, User $user)
    {
        $this->authorize('update', $user);
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'role' => 'required|string|in:employee,seeker,provider',
        ]);
        $user->update($validated);
        return to_route('users.index')->with('success', 'تم تحديث بيانات المستخدم بنجاح');
    }

    public function updatePassword(Request $request, User $user)
    {
        $this->authorize('update', $user);
        $validated = $request->validate([
            'password' => 'required|min:8',
        ]);
        $user->update([
            'password' => Hash::make($validated['password']),
        ]);
        return to_route('users.index')->with('success', 'تم تحديث كلمة المرور بنجاح');
    }

    // public function verifyEmail(User $user)
    // {
    //     $this->authorize('update', $user);
    //     if ($user->hasVerifiedEmail()) {
    //         return to_route('users.index')->with('info', 'البريد الإلكتروني موثق بالفعل');
    //     }
    //     $user->email_verified_at = now();
    //     $user->save();

    //     return to_route('users.index')->with('success', 'تم توثيق البريد الإلكتروني بنجاح');
    // }
    public function verifyEmail(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'code' => 'required',
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return response()->json(['message' => 'المستخدم غير موجود'], 404);
        }

        if ($user->email_verified_at) {
            return response()->json(['message' => 'الإيميل موثق مسبقًا']);
        }

        if ($user->email_verification_code !== $request->code) {
            return response()->json(['message' => 'كود التحقق غير صحيح'], 422);
        }

        $user->update([
            'email_verified_at' => now(),
            'email_verification_code' => null,
        ]);

        return response()->json([
            'message' => 'تم توثيق البريد الإلكتروني بنجاح',
        ]);
    }

    public function destroy(User $user)
    {
        $this->authorize('delete', $user);
        $user->delete();
        return to_route('users.index')->with('success', 'تم حذف المستخدم بنجاح');
    }

    public function loginPage()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {

        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        $user = User::where('email', $request->email)->first();

        // المستخدم غير موجود
        if (!$user) {
            return back()->withErrors([
                'email' => 'The provided credentials do not match our records.',
            ]);
        }

        // التحقق من الدور
        if ($user->role != Role::ADMIN && $user->role != Role::EMPLOYEE) {
            return back()->withErrors(
                'You are not authorized to access the admin dashboard.'
            );
        }



        // التحقق من توثيق الإيميل
        // if (!$user->hasVerifiedEmail()) {
        //     return back()->withErrors([
        //         'email' => 'Please verify your email address first.',
        //     ]);
        // }

        // محاولة تسجيل الدخول
        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            return to_route('dashboard');
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->onlyInput('email');
    }

    public function verifyEmailAdmin(User $user)
    {
        if($user->email_verified_at){
            return back()->with('info', 'المستخدم موثق بالفعل');
        }
        $user->update([
            'email_verified_at' => now()
        ]);
        return back()->with('success', 'تم توثيق البريد الإلكتروني بنجاح');
    }


    //api functions
    public function resendCode(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email',
        ]);

        // 🛑 منع الإزعاج (محاولة كل دقيقة)
        $key = 'resend-code:' . $request->email;

        if (RateLimiter::tooManyAttempts($key, 1)) {
            return response()->json([
                'message' => 'يرجى الانتظار دقيقة قبل إعادة الإرسال'
            ], 429);
        }

        RateLimiter::hit($key, 60);

        $user = User::where('email', $request->email)->first();

        // لو الحساب مفعّل
        if ($user->email_verified_at) {
            return response()->json([
                'message' => 'الحساب مفعّل بالفعل'
            ], 400);
        }

        // 🔢 توليد كود جديد
        $code = random_int(100000, 999999);

        EmailVerificationCode::updateOrCreate([
            'user_id' => $user->id,
            'code' => $code,
            'expires_at' => now()->addMinutes(10)
        ]);

        // 📬 إرسال الإيميل عبر Queue
        SendEmailVerificationCode::dispatch($user, $code);

        return response()->json([
            'message' => 'تم إرسال رمز التحقق مرة أخرى'
        ]);
    }

    public function verifyEmailCode(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'code' => 'required'
        ]);

        $user = User::where('email', $request->email)->firstOrFail();

        $record = EmailVerificationCode::where('user_id', $user->id)
            ->where('code', $request->code)
            ->where('expires_at', '>', now())
            ->first();

        if (!$record) {
            return response()->json([
                'message' => 'الكود غير صحيح أو منتهي'
            ], 422);
        }

        $user->update([
            'email_verified_at' => now()
        ]);

        $record->delete();

        return response()->json([
            'message' => 'تم توثيق البريد الإلكتروني بنجاح'
        ]);
    }


    public function logout()
    {
        Auth::logout();
        return to_route('login');
    }
}
