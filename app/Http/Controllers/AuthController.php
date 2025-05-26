<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Socialite;


class AuthController extends Controller
{
    // Nampilin Form Register
    public function showRegisterForm()
    {
        return view('auth.register');
    }

    // Proses data register
    public function register(Request $request)
    {
        // Validasi input dari form
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|min:8|confirmed',
        ]);

        // Simpan user baru ke database
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password), 
        ]);

        // Login user setelah registrasi
        Auth::login($user);

        return redirect('/')->with('success', 'Registrasi berhasil! Selamat datang, ' . $user->name . '!');
    }

    // Nampilin Form Login
    public function showLoginForm()
    {
        return view('auth.login');
    }

    // Proses data login
    public function login(Request $request) 
    {
        // Validasi input dari form
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        // Login
        if (Auth::attempt($credentials)) {
            $request->session()->regenerate(); // Bikin sesion baru
            return redirect()->intended('/dashboard')->with('success', 'Selamat datang!');
        }

        // Gagal login
        return back()-> withErrors([
            'email' => 'Email atau password salah.',
        ])->onlyInput('email');
    }

    // Proses Logout
    public function logout(Request $request) 
    {
        Auth::logout();
        return redirect('/login')->with('success', 'Berhasil logout!');
    }

    // Change password
    public function showChangePasswordForm()
    {
        return view('auth.change-password');
    }

    public function changePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'new_password' => 'required|min:8|confirmed',
        ]);

        if (!Hash::check($request->current_password, Auth::user()->password)) {
            return back()->withErrors(['current_password' => 'Password lama salah.']);
        }

        /** @var \App\Models\User $user */
        $user = Auth::user();
        $user->password = bcrypt($request->new_password);
        $user->save();

        return redirect('/dashboard')->with('success', 'Password berhasil diganti!');
    }

    public function showRecoveryForm()
    {
        return view('auth.recovery'); // pastikan nama view-nya sesuai
    }

    public function recoverPassword(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'name' => 'required|string',
            'current_password' => 'required',
            'new_password' => 'required|min:8|confirmed',
        ]);

        $user = User::where('email', $request->email)
                    ->where('name', $request->name)
                    ->first();

        if (!$user || !Hash::check($request->current_password, $user->password)) {
            return back()->withErrors(['current_password' => 'Data tidak cocok atau password lama salah.'])->withInput();
        }

        $user->password = Hash::make($request->new_password);
        $user->save();

        return redirect()->route('login')->with('success', 'Password berhasil di-reset. Silakan login kembali.');
    }

    public function redirectToGoogle() {
        return Socialite::driver('google')->redirect();
    }

    public function handleGoogleCallback() {
        $user = Socialite::driver('google')->stateless()->user();
    }
}
