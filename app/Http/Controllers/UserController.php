<?php

namespace App\Http\Controllers;

use App\constant\Role;
use App\Models\User;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    use AuthorizesRequests;

    public function apiRegister(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6|confirmed',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);


        // إنشاء توكن مباشرة بعد التسجيل
        $token = $user->createToken('api-token')->plainTextToken;
        $user->sendEmailVerificationNotification();
        return response()->json([
            'message' => 'Account created successfully',
            'token' => $token,
            'user' => $user,
            'email_verified' => $user->hasVerifiedEmail()
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
        return view('users.index', ['users' => $users]);
    }

    public function show(User $user)
    {
        $this->authorize('view', $user);

        return view('users.show', ['user' => $user]);
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

    public function verifyEmail(User $user)
    {
        $this->authorize('update', $user);
        if ($user->hasVerifiedEmail()) {
            return to_route('users.index')->with('info', 'البريد الإلكتروني موثق بالفعل');
        }
        $user->email_verified_at = now();
        $user->save();

        return to_route('users.index')->with('success', 'تم توثيق البريد الإلكتروني بنجاح');
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

    public function logout()
    {
        Auth::logout();
        return to_route('login');
    }
}
