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

        $user = Auth::user();
        
        if ($user->status === 'suspended') {
            return response()->json([
                'message' => 'عذراً، لقد تم إيقاف حسابك من قبل الإدارة. يرجى التواصل مع الدعم الفني.'
            ], 403);
        }

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

public function index(Request $request)
{
    $this->authorize('viewAny', User::class);

    $query = User::query();

    if ($request->filled('search')) {
        $search = $request->search;
        $query->where(function($q) use ($search) {
            $q->where('name', 'LIKE', "%{$search}%")
              ->orWhere('email', 'LIKE', "%{$search}%");
        });
    }

    if ($request->filled('role')) {
        $query->where('role', $request->role);
    }

    $users = $query->latest()->get();

    // تسجيل المستخدمين حسب الشهور
    $usersChart = User::selectRaw('EXTRACT(MONTH FROM created_at) as month, COUNT(*) as count')
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
    public function create()
    {
        $this->authorize('create', User::class);
        return view('users.create');
    }

    public function store(Request $request)
    {
        $this->authorize('create', User::class);
        
        $rules = [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:8|confirmed',
            'role' => 'required|string|in:employee,seeker,provider',
        ];

        // Add provider-specific rules
        if ($request->role === Role::PROVIDER) {
            $rules = array_merge($rules, [
                'job_title' => 'nullable|string|max:255',
                'bio' => 'nullable|string',
                'latitude' => 'nullable|numeric',
                'longitude' => 'nullable|numeric',
                'commission' => 'nullable|numeric|min:0|max:100',
            ]);
        }

        $validated = $request->validate($rules);

        $userData = [
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role' => $validated['role'],
            'email_verified_at' => now(), // Auto-verify admin-created accounts
        ];

        if ($request->role === Role::PROVIDER) {
            $userData['commission'] = $validated['commission'] ?? 10;
            $userData['no_commission'] = $request->has('no_commission');
        } else {
            $userData['commission'] = 0;
            $userData['no_commission'] = false;
        }

        $user = User::create($userData);

        if ($request->role === Role::PROVIDER) {
            $user->profile()->create([
                'job_title' => $request->job_title,
                'bio' => $request->bio,
                'latitude' => $request->latitude,
                'longitude' => $request->longitude,
            ]);
        } else {
            $user->profile()->create([]);
        }

        return to_route('users.index')->with('success', 'تم إنشاء حساب المستخدم بنجاح');
    }

    public function edit(User $user)
    {
        $this->authorize('update', $user);
        $user->load('profile');
        return view('users.edit', ['user' => $user]);
    }
    public function update(Request $request, User $user)
    {
        $this->authorize('update', $user);
        
        $rules = [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'role' => 'required|string|in:employee,seeker,provider',
        ];

        // Add provider-specific rules
        if ($request->role === Role::PROVIDER) {
            $rules = array_merge($rules, [
                'job_title' => 'nullable|string|max:255',
                'bio' => 'nullable|string',
                'latitude' => 'nullable|numeric',
                'longitude' => 'nullable|numeric',
                'commission' => 'nullable|numeric|min:0|max:100',
                'provider_verified_until' => 'nullable|date',
            ]);
        }

        $validated = $request->validate($rules);

        // Core User Update
        $userFields = [
            'name' => $validated['name'],
            'email' => $validated['email'],
            'role' => $validated['role'],
        ];

        if ($request->role === Role::PROVIDER) {
            $userFields['commission'] = $validated['commission'] ?? null;
            $userFields['no_commission'] = $request->has('no_commission');
            $userFields['provider_verified_until'] = $validated['provider_verified_until'] ?? null;
        }

        $user->update($userFields);

        // Profile Update (Providers/Seekers often have profiles)
        if ($request->role === Role::PROVIDER) {
            $user->profile()->updateOrCreate(
                ['user_id' => $user->id],
                [
                    'job_title' => $request->job_title,
                    'bio' => $request->bio,
                    'latitude' => $request->latitude,
                    'longitude' => $request->longitude,
                ]
            );
        }

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

    public function toggleStatus(User $user)
    {
        $this->authorize('suspend', $user);
        
        $newStatus = $user->status === 'active' ? 'suspended' : 'active';
        $user->update(['status' => $newStatus]);

        $message = $newStatus === 'active' ? 'تم تنشيط الحساب بنجاح' : 'تم إيقاف الحساب بنجاح';
        
        $statusMsg = $newStatus === 'active' ? 'تنشيط حسابك ✨' : 'إيقاف حسابك ⚠️';
        $statusDesc = $newStatus === 'active' 
            ? 'لقد تم إعادة تنشيط حسابك من قبل الإدارة. يمكنك الآن استخدام كافة ميزات التطبيق.' 
            : 'عذراً، لقد تم إيقاف حسابك مؤقتاً من قبل الإدارة. يرجى التواصل مع الدعم الفني لمزيد من التفاصيل.';
            
        app(\App\Services\NotificationService::class)->sendToUser(
            $user->id,
            $statusMsg,
            $statusDesc,
            \App\Constants\NotificationType::ADMIN_MSG
        );
        
        return back()->with('success', $message);
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
            $user = Auth::user();
            if ($user->status === 'suspended') {
                Auth::logout();
                return back()->withErrors([
                    'email' => 'عذراً، لقد تم إيقاف حسابك من قبل الإدارة. يرجى التواصل مع الدعم الفني.',
                ])->onlyInput('email');
            }
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

    public function apiUpdatePassword(Request $request)
    {
        $request->validate([
            'old_password' => 'required',
            'password' => 'required|min:8|confirmed',
        ]);

        $user = Auth::user();

        if (!Hash::check($request->old_password, $user->password)) {
            return response()->json([
                'message' => 'كلمة المرور القديمة غير صحيحة'
            ], 422);
        }

        $user->update([
            'password' => Hash::make($request->password)
        ]);

        return response()->json([
            'message' => 'تم تغيير كلمة المرور بنجاح'
        ]);
    }

    public function editProfile()
    {
        $user = Auth::user();
        return view('admin.profile.edit', compact('user'));
    }

    public function updateProfile(Request $request)
    {
        $user = Auth::user();

        $rules = [
            'name' => 'required|string|max:255',
            'password' => 'nullable|min:8|confirmed',
        ];

        // Only Admin can change email
        if ($user->role === Role::ADMIN) {
            $rules['email'] = 'required|email|unique:users,email,' . $user->id;
        }

        // Check if sensitive data is changing
        $isChangingEmail = $user->role === Role::ADMIN && $request->has('email') && $request->email !== $user->email;
        $isChangingPassword = $request->filled('password');

        if ($isChangingEmail || $isChangingPassword) {
            $rules['current_password'] = 'required';
        }

        $request->validate($rules);

        // Verify current password for sensitive changes
        if ($isChangingEmail || $isChangingPassword) {
            if (!Hash::check($request->current_password, $user->password)) {
                return back()->withErrors(['current_password' => 'كلمة المرور الحالية غير صحيحة']);
            }
        }

        $user->name = $request->name;
        
        if ($user->role === Role::ADMIN && $request->has('email')) {
            $user->email = $request->email;
        }

        if ($isChangingPassword) {
            $user->password = Hash::make($request->password);
        }

        $user->save();

        return back()->with('success', 'تم تحديث الملف الشخصي بنجاح');
    }

    public function logout()
    {
        Auth::logout();
        return to_route('login');
    }
}
