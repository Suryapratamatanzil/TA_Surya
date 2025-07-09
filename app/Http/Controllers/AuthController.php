<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    // Menampilkan halaman login
    public function index()
    {
        if (auth()->check()) {
        return redirect()->route('beranda');
        }

        return view('login'); // sesuaikan dengan nama file view login
    }

    // Proses login dengan validasi dan fitur remember me
    public function login(Request $request)
    {
        // Validasi form login
        $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        // Ambil kredensial dan status "ingat saya"
        $credentials = $request->only('email', 'password');
        $remember = $request->has('remember'); // checkbox remember

        // Autentikasi dengan Auth::attempt
        if (Auth::attempt($credentials, $remember)) {
            $request->session()->regenerate(); // Cegah session fixation

            return redirect()->intended('/beranda'); // ganti dengan route yang kamu inginkan
        }

        // Jika gagal login, kembalikan error
        throw ValidationException::withMessages([
            'email' => ['Email tidak ditemukan atau password salah.'],
        ]);
    }

    // (Optional) Jika ingin logika terpisah nanti
    public function proseslogin()
    {
        // Kosong, bisa dihapus jika tidak dipakai
    }

    // Logout dan hapus session serta token
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();       // Hapus session
        $request->session()->regenerateToken();  // Ganti CSRF token

        return redirect('/login'); // Kembali ke halaman login
    }
}
