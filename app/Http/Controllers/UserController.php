<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function destroy(Request $request)
    {
        $user = Auth::user();

        Auth::logout();

        $user->delete();

        return redirect('/register')->with('success', 'Akun kamu berhasil dihapus.');
    }

    public function showDeleteForm()
    {
        return view('profile.delete');
    }

    public function deleteAccount(Request $request)
    {
        $request->validate([
            'password' => 'required',
        ]);

        $user = Auth::user();

        if (!Hash::check($request->password, $user->password)) {
            return back()->with('error', 'Password tidak cocok.');
        }

        Auth::logout();
        $user->delete();

        return redirect('/register')->with('success', 'Akun berhasil dihapus.');
    }

    
}
