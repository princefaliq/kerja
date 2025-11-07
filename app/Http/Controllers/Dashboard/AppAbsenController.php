<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Absensi;
use App\Models\QrToken;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class AppAbsenController extends Controller
{
    public function index()
    {
        return view('content.absen.index');
    }
    public function code()
    {
        return view('content.absen.qr_code');
    }
    public function generate()
    {
        $kodeAcara = 'JOBFAIR2025';

        // bersihkan token lama
        \App\Models\QrToken::where('expired_at', '<', now())->delete();

        $token = \Str::random(32);
        $ttl = 60; // detik berlaku

        $qr = \App\Models\QrToken::create([
            'kode_acara' => $kodeAcara,
            'token' => $token,
            'expired_at' => now()->addSeconds($ttl),
        ]);

        $url = route('absen.scan', ['kode' => $kodeAcara, 'token' => $token]);
        $svg = \QrCode::format('svg')->size(250)->generate($url);

        return response()->json([
            'qr' => (string) $svg,    // SVG mentah
            'is_svg' => true,
            'ttl_seconds' => $ttl,    // <<— pakai ini di frontend
        ]);
    }

    public function store($kode, Request $request)
    {
        $token = $request->query('token');
        $lokasi = $request->query('lokasi'); // 🔹 tangkap lokasi dari URL

        // Cek token QR valid?
        $validToken = QrToken::where('kode_acara', $kode)
            ->where('token', $token)
            ->where('expired_at', '>', now())
            ->where('digunakan', false)
            ->first();

        if (!$validToken) {
            return redirect()->route('profile.index')->with('error', 'QR tidak valid atau sudah kedaluwarsa.');
        }

        // Cek apakah user sudah pernah absen untuk acara ini
        $sudahAbsen = Absensi::where('user_id', Auth::id())
            ->where('kode_acara', $kode)
            ->exists();

        if ($sudahAbsen) {
            return redirect()->route('profile.index')->with('info', 'Kamu sudah absen untuk acara ini.');
        }

        // Simpan data absensi
        Absensi::create([
            'user_id' => Auth::id(),
            'kode_acara' => $kode,
            'waktu_absen' => now(),
            'lokasi' => $lokasi ?? 'Job Fair Bondowoso 2025', // 🔹 gunakan lokasi dari URL jika ada
        ]);

        // Tandai token sudah digunakan
        $validToken->update(['digunakan' => true]);

        return redirect()->route('profile.index')->with('success', 'Absen berhasil dicatat!');
    }


    // 🔹 Cek apakah QR masih aktif
    public function status()
    {
        $latest = QrToken::orderByDesc('created_at')->first();

        if (!$latest) {
            return response()->json(['active' => false]);
        }

        $active = $latest->expired_at->isFuture();

        return response()->json([
            'active' => $active,
            'expired_at' => $latest->expired_at->toIso8601String(),
        ]);
    }
    public function data()
    {
        $items = Absensi::with('user')
            ->orderByDesc('waktu_absen')
            ->get();

        $data = $items->map(function ($item, $index) {
            // pastikan waktu_absen selalu terformat dengan aman
            $waktu = $item->waktu_absen
                ? Carbon::parse($item->waktu_absen)->format('d M Y H:i:s')
                : '-';

            return [
                'id' => $item->id,
                'no' => $index + 1,
                'nama' => $item->user->name ?? '-',
                'email' => $item->user->email ?? '-',
                'kode_acara' => $item->kode_acara,
                'lokasi' => $item->lokasi ?? '-',
                'waktu_absen' => $waktu,
            ];
        });

        return response()->json(['data' => $data]);
    }

}
