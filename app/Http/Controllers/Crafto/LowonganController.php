<?php

namespace App\Http\Controllers\Crafto;

use App\Http\Controllers\Controller;
use App\Models\Lamaran;
use App\Models\Lowongan;
use App\Models\Pelamar;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules;

class LowonganController extends Controller
{
    public function index()
    {

        $lowongans = Lowongan::with('user')->paginate(10); // Mengambil 10 data per halaman

        return view('crafto.lowongan_kerja', compact('lowongans'));
    }
    public function login()
    {
        if (Auth::check()) {
            return redirect('/'); // ubah 'home' sesuai route tujuan setelah login
        }
        return view('crafto.login');
    }
    public function register_index()
    {
        if (Auth::check()) {
            return redirect('/');
        }
        return view('crafto.register');
    }
    public function register_store(Request $request)
    {
        //return $request;
        // Validasi input
        $request->validate([
            'name' => 'required|string|max:255|regex:/^[A-Za-z\s]+$/',
            'email' => 'required|string|email|max:255|unique:users',
            'no_hp' => 'nullable|string|max:15|unique:users,no_hp',
            'password' => 'required|string|min:8',
        ], [
            'name.required' => 'Nama wajib diisi.',
            'name.string' => 'Nama harus berupa teks.',
            'name.max' => 'Nama tidak boleh lebih dari 255 karakter.',
            'name.regex' => 'Nama hanya boleh berisi huruf dan spasi.',

            'email.required' => 'Email wajib diisi.',
            'email.string' => 'Email harus berupa teks.',
            'email.email' => 'Format email tidak valid.',
            'email.max' => 'Email tidak boleh lebih dari 255 karakter.',
            'email.unique' => 'Email sudah terdaftar.',

            'no_hp.nullable' => 'Nomor HP boleh kosong.',
            'no_hp.string' => 'Nomor HP harus berupa teks.',
            'no_hp.max' => 'Nomor HP tidak boleh lebih dari 15 karakter.',
            'no_hp.unique' => 'Nomor HP sudah terdaftar.',

            'password.required' => 'Kata sandi wajib diisi.',
            'password.string' => 'Kata sandi harus berupa teks.',
            'password.min' => 'Kata sandi harus terdiri dari minimal 8 karakter.',
        ]);

        // === Simpan ke tabel users ===
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'no_hp' => $request->no_hp,
            'password' => Hash::make($request->password),
            'last_login' => now(),
        ]);
        $user->assignRole('User');

        return redirect('/profile')->with('success', 'Berhasil mendaftar. Silahkan isi profile anda terlebih dahulu.!');
    }
    public function detil($slug)
    {
        // Ambil data lowongan beserta relasi user
        $lowongan = Lowongan::with('user')->where('slug', $slug)->firstOrFail();
        if($lowongan->status == 0)
        {
            abort(404);
        }
        // Default: user belum melamar
        $sudahMelamar = false;
        $sudahIsi = false;

        // Jika user login, cek apakah sudah pernah melamar lowongan ini
        if (auth()->check()) {
            $sudahMelamar = Lamaran::where('user_id', auth()->id())
                ->where('lowongan_id', $lowongan->id)
                ->exists();
            $sudahIsi = Pelamar::where('user_id', auth()->id())
                ->exists();
        }
        
        
        return view('crafto.lowongan_detil', compact('lowongan', 'sudahMelamar','sudahIsi'));

    }

}
