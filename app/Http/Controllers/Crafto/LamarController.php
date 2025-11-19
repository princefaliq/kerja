<?php

namespace App\Http\Controllers\Crafto;

use App\Http\Controllers\Controller;
use App\Models\Absensi;
use App\Models\Lamaran;
use App\Models\Lowongan;
use App\Models\Pelamar;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Str;

class LamarController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // Ambil semua lamaran milik user, lengkap dengan relasi ke lowongan dan perusahaan
        $lamarans = Lamaran::with(['lowongan.user'])
            ->where('user_id', $user->id)
            ->latest()
            ->get();

        // Hitung statistik lamaran berdasarkan status
        $statistik = [
            'dikirim'  => $lamarans->where('status', 'dikirim')->count(),
            'diterima' => $lamarans->where('status', 'diterima')->count(),
            'ditolak'  => $lamarans->where('status', 'ditolak')->count(),
        ];

        return view('crafto.lamaran', compact('lamarans', 'statistik'));
    }

    public function daftar(Request $request)
    {
        $request->validate([
            'id_lowongan' => 'required|exists:lowongan,id',
        ]);

        $user = auth()->user();

        // Cek role
        if (!$user->hasRole('User')) {
            abort(403);
        }

        // Ambil data lowongan
        $lowongan = Lowongan::findOrFail($request->id_lowongan);

        // Cek isi biodata
        $sudahIsi = Pelamar::where('user_id', $user->id)->exists();
        if (!$sudahIsi) {
            return redirect()->route('profile')->with('error', 'Anda belum mengisi biodata.');
        }

        // Cek absensi HANYA jika lowongan adalah acara
        if ($lowongan->acara_id) {
            $sudahAbsen = Absensi::where('user_id', $user->id)
                ->where('acara_id', $lowongan->acara_id)
                ->exists();

            if (!$sudahAbsen) {
                return redirect()->back()->with('error', 'Anda belum melakukan absensi.');
            }
        }

        // Cek apakah sudah melamar sebelumnya
        $sudahMelamar = Lamaran::where('user_id', $user->id)
            ->where('lowongan_id', $lowongan->id)
            ->exists();

        if ($sudahMelamar) {
            return redirect()->back()->with('error', 'Anda sudah melamar pada lowongan ini.');
        }

        // Simpan lamaran baru
        Lamaran::create([
            'user_id' => $user->id,
            'lowongan_id' => $lowongan->id,
            'status' => 'dikirim',
        ]);

        return redirect()->back()->with('success', 'Lamaran berhasil dikirim!');
    }


}
