<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\AdminRegisterRequest;
use App\Http\Requests\AdminLoginRequest;
use App\Http\Requests\UpdateProfileRequest;
use App\Models\AdminUser;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Models\Role;
use Exception;

class AuthController extends Controller
{
    /**
     * Show the form for creating a new admin.
     *
     * @return \Illuminate\View\View
     */
    public function register()
    {
        return view('admin.pages.auth.register');
    }

    /**
     * Store a newly created admin account in the database.
     *
     * @param  \App\Http\Requests\AdminRegisterRequest  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(AdminRegisterRequest $request)
    {
        try {
            AdminUser::create([
                'admin_name' => $request->admin_name,
                'password' => Hash::make($request->password),
                'email' => $request->email,
                'role_id' => 'ALL',
            ]);

            return redirect()->route('admin.login')->with('success', __('auth.register_success'));
        } catch (Exception $e) {
            Log::error($e->getMessage());

            return redirect()->route('admin.register')->with('error', __('auth.register_failed'));
        }
    }

    /**
     * Show the form for logging in.
     *
     * @return \Illuminate\View\View
     */
    public function loginForm()
    {
        return view('admin.pages.auth.login');
    }

    /**
     * Handle an admin login request.
     *
     * @param  \App\Http\Requests\AdminLoginRequest  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function login(AdminLoginRequest $request)
    {
        try {
            $credentials = $request->only('email', 'password');

            $adminUser = AdminUser::where('email', $credentials['email'])->first();

            if (!$adminUser) {
                return back()->withErrors(['email' => '*' . __('auth.email_not_found')])->onlyInput('email');
            }


            if (!Hash::check($credentials['password'], $adminUser->password)) {
                return back()->withErrors(['password' => __('auth.incorrect_password')])->onlyInput('email');
            }

            Auth::guard('admin')->login($adminUser);

            $request->session()->regenerate();

            // dd(Auth::guard('admin')->user(), session()->all(), Auth::guard('admin')->user()->role_id);

            return redirect()->route('admin.dashboard');

        } catch (Exception $e) {
            Log::error($e->getMessage());

            return back()->withErrors(['error' => __('auth.login_failed')]);
        }
    }

    /**
     * Log the admin out of the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function logout(Request $request)
    {
        Auth::guard('admin')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('admin.dashboard');
    }

    /**
     * Show the admin profile.
     *
     * @return \Illuminate\View\View
     */
    public function showProfile()
    {
        // $admin = session('adminUser') ?? Auth::guard('admin')->user();
        $admin = Auth::guard('admin')->user();
        $role = Role::find($admin->role_id);

        return view('admin.pages.auth.profile', compact('admin', 'role'));
    }

    /**
     * Show the form for editing the admin profile.
     *
     * @return \Illuminate\View\View
     */
    public function editProfile()
    {
        $admin = Auth::guard('admin')->user();

        return view('admin.pages.auth.update', compact('admin'));
    }

    /**
     * Update the admin profile in the database.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function updateProfile(UpdateProfileRequest $request, $id)
    {
        try {
            $admin = Auth::guard('admin')->user();

            $admin->admin_name = $request->admin_name;
            $admin->phone = $request->phone;
            $admin->address = $request->address;

            $admin->save();

            return redirect()->route('admin.profile')->with('success', __('auth.profile_updated'));
        } catch (Exception $e) {
            Log::error($e->getMessage());

            return redirect()->route('admin.profile')->with('error', __('auth.profile_update_failed'));
        }
    }
}
