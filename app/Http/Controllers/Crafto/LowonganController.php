<?php

namespace App\Http\Controllers\Crafto;

use App\Http\Controllers\Controller;
use App\Models\Absensi;
use App\Models\Acara;
use App\Models\Lamaran;
use App\Models\Lowongan;
use App\Models\Pelamar;
use App\Models\User;
use App\Notifications\VerifyEmailUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules;

class LowonganController extends Controller
{
    public function index(Request $request)
    {
        // Ambil daftar jenis pekerjaan dan hitung jumlah masing-masing
        $jenisPekerjaanList = Lowongan::select('jenis_pekerjaan', \DB::raw('COUNT(*) as total'))
            ->where('status', 1)
            ->whereNotNull('jenis_pekerjaan')
            ->groupBy('jenis_pekerjaan')
            ->orderBy('jenis_pekerjaan', 'asc')
            ->get();
             // 🔹 Ambil daftar jenis kelamin dan jumlah masing-masing
        $jenisKelaminList = Lowongan::select('jenis_kelamin', \DB::raw('COUNT(*) as total'))
            ->where('status', 1)
            ->whereNotNull('jenis_kelamin')
            ->groupBy('jenis_kelamin')
            ->orderBy('jenis_kelamin', 'asc')
            ->get();
        $perusahaanList = Lowongan::select('user_id', \DB::raw('COUNT(*) as total'))
            ->where('status', 1)
            ->groupBy('user_id')
            ->with(['user:id,name'])
            ->get()
            ->map(function ($item) {
                return [
                    'nama' => $item->user->name ?? 'Tidak diketahui',
                    'total' => $item->total,
                ];
            });

        // Query utama untuk data lowongan
        $query = Lowongan::with('user')->where('status', 1);

        if ($request->filled('perusahaan')) {
            $query->whereHas('user', function ($q) use ($request) {
                $q->where('name', $request->perusahaan);
            });
        }
        if ($request->filled('jenis_pekerjaan')) {
            $query->where('jenis_pekerjaan', $request->jenis_pekerjaan);
        }
         if ($request->filled('jenis_kelamin')) {
            $query->where('jenis_kelamin', $request->jenis_kelamin);
        }

        $lowongans = $query->paginate(12)->appends($request->query());
        return view('crafto.lowongan_kerja', compact('lowongans', 'jenisPekerjaanList','jenisKelaminList','perusahaanList'));
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
            'no_hp' => 'required|regex:/^[0-9]+$/|max:15|unique:users,no_hp',
            'password' => 'required|string|min:8',
            'g-recaptcha-response' => 'required|string',
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

            'no_hp.required' => 'Nomor HP wajib diisi.',
            'no_hp.regex'    => 'Nomor HP hanya boleh berisi angka.',
            'no_hp.max' => 'Nomor HP tidak boleh lebih dari 15 karakter.',
            'no_hp.unique' => 'Nomor HP sudah terdaftar.',

            'password.required' => 'Kata sandi wajib diisi.',
            'password.string' => 'Kata sandi harus berupa teks.',
            'password.min' => 'Kata sandi harus terdiri dari minimal 8 karakter.',
            'g-recaptcha-response.required' => 'Captcha wajib diisi.',
            'g-recaptcha-response.string' => 'Captcha tidak valid.',

        ]);
        // Validasi Google reCAPTCHA
        $verify = Http::asForm()->post('https://www.google.com/recaptcha/api/siteverify', [
            'secret'   => env('INVISIBLE_RECAPTCHA_SECRET_KEY'),
            'response' => $request->input('g-recaptcha-response'),
            'remoteip' => $request->ip(),
        ])->json();

        if (!data_get($verify, 'success', false)) {
            return back()
                ->withErrors(['captcha' => 'Captcha gagal diverifikasi.'])
                ->withInput();
        }

        // === Simpan ke tabel users ===
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'no_hp' => $request->no_hp,
            'password' => Hash::make($request->password),
            'last_login' => now(),
        ]);
        $user->assignRole('User');
        $user->notify(new VerifyEmailUser());

        return redirect('/login')->with('success', 'Berhasil mendaftar. Silahkan cek email (spam/inbox) untuk verifikasi akun!');
    }
    public function detil($acara = null, $slug = null)
    {


        if ($slug === null) {
            // Berarti request dari non-acara: lowongan-kerja/{slug}
            $slug = 'lowongan-kerja/'.$acara; // karena parameter pertama adalah slug
            $acara = null;
        }else{
            $slug = 'job-fair/'.$acara.'/'.$slug;
        }

        if ($slug) {
            $lowongan = Lowongan::with('user')
                ->where('slug', $slug)
                ->firstOrFail();
        } else {
            abort(404, 'Lowongan tidak ditemukan.');
        }

        if ($lowongan->status == 0 && !auth()->user()->hasRole('Admin')) {
            abort(404, 'Lowongan tidak ditemukan.');
        }


        $sudahMelamar = $sudahIsi = $sudahAbsen = false;
        if (auth()->check()) {
            $userId = auth()->id();

            // Cek melamar
            $sudahMelamar = Lamaran::where('user_id', $userId)
                ->where('lowongan_id', $lowongan->id)
                ->exists();

            // Cek apakah sudah isi profil
            $sudahIsi = Pelamar::where('user_id', $userId)->exists();

            // Cek absensi HANYA untuk lowongan acara
            if ($lowongan->acara_id) {
                $sudahAbsen = Absensi::where('user_id', $userId)
                    ->where('acara_id', $lowongan->acara_id)
                    ->exists();
            } else {
                $sudahAbsen = false; // non-acara pasti false
            }
        }

        return view('crafto.lowongan_detil', compact(
            'lowongan', 'sudahMelamar', 'sudahIsi', 'sudahAbsen'
        ));
    }
    public function verify($id, $hash)
    {
        $user = User::findOrFail($id);

        if (sha1($user->email) !== $hash) {
            abort(403, 'Invalid verification link');
        }

        $user->status = 'aktif';
        $user->save();

        return redirect('/login')->with('success', 'Email berhasil diverifikasi! Silakan login.');
    }

    public function resendVerification(Request $request)
    {
        $login = $request->login;

        $user = User::where('email', $login)
            ->orWhere('no_hp', $login)
            ->first();

        if (! $user) {
            return back()->withErrors(['login' => 'Akun tidak ditemukan.']);
        }

        if ($user->status === 'aktif') {
            return back()->with('success', 'Akun Anda sudah aktif.');
        }

        // 🔹 KIRIM ULANG NOTIFICATION
        $user->notify(new VerifyEmailUser());

        return back()->with('success', 'Email verifikasi telah dikirim ulang.');
    }




}
