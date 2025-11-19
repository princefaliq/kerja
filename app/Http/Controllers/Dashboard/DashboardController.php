<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Absensi;
use App\Models\Lamaran;
use App\Models\Lowongan;
use App\Models\Pelamar;
use App\Models\User;
use App\Models\WebsiteUpdate;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class DashboardController extends Controller
{
    public function index()
    {

        return view('content.dashboard.dashboard');
    }

    public function getUserData()
    {
        $totalUser = User::whereHas('roles', function($q) {
            $q->where('name', 'User');
        })->count();

        $totalPelamar = Pelamar::count();

        // Hindari pembagian 0
        $percentage = $totalUser > 0 ? round(($totalPelamar / $totalUser) * 100, 1) : 0;

        return response()->json([
            'total_user' => $totalUser,
            'total_pelamar' => $totalPelamar,
            'percentage' => $percentage
        ]);
    }
    public function widgetData()
    {
        $user = auth()->user();
        $totalUser = User::whereHas('roles', fn($q) => $q->where('name', 'User'))->count();
        $totalPerusahaan = User::whereHas('roles', fn($q) => $q->where('name', 'Perusahaan'))->count();
        $totalPelamar = Pelamar::count();
        $totalAbsen = Absensi::count();


        // Cek role user login
        if ($user->hasRole('Admin')) {
            // Admin: total semua lowongan aktif
            $totalLowongan = Lowongan::where('status', 1)->sum('jumlah_lowongan');
            $totalLamaran = Lamaran::count();
            $totalTolak = Lamaran::where('status','ditolak')->count();
            $totalTerima = Lamaran::where('status','diterima')->count();
        } elseif ($user->hasRole('Perusahaan')) {
            // Perusahaan: total lowongan miliknya sendiri
            $totalLowongan = Lowongan::where('status', 1)
                ->where('user_id', $user->id)
                ->sum('jumlah_lowongan');
            $totalLamaran = Lamaran::whereHas('lowongan', function ($q) use ($user) {
                $q->where('user_id', $user->id);
            })->count();

            // total pelamar ditolak berdasarkan lowongan perusahaan yg login
            $totalTolak = Lamaran::where('status', 'ditolak')
                ->whereHas('lowongan', function($q) use ($user) {
                    $q->where('user_id', $user->id);
                })
                ->count();

            // total pelamar diterima
            $totalTerima = Lamaran::where('status', 'diterima')
                ->whereHas('lowongan', function($q) use ($user) {
                    $q->where('user_id', $user->id);
                })
                ->count();
        } else {
            // Role lain (misal User): bisa diset 0
            $totalLowongan = 0;
            $totalLamaran = 0;
            $totalTolak = 0;
            $totalTerima = 0;
        }
        // === DATA GRAFIK STATUS LAMARAN ===
        if ($user->hasRole('Perusahaan')) {

            // Perusahaan hanya melihat data dari lowongannya sendiri
            $chartData = [
                'dikirim' => Lamaran::where('status', 'dikirim')
                    ->whereHas('lowongan', fn($q) => $q->where('user_id', $user->id))
                    ->count(),

                'ditolak' => Lamaran::where('status', 'ditolak')
                    ->whereHas('lowongan', fn($q) => $q->where('user_id', $user->id))
                    ->count(),

                'diterima' => Lamaran::where('status', 'diterima')
                    ->whereHas('lowongan', fn($q) => $q->where('user_id', $user->id))
                    ->count(),
            ];

        } else {
            // Admin & user lain → munculkan semua tanpa filter
            $chartData = [
                'dikirim' => Lamaran::where('status', 'dikirim')->count(),
                'ditolak' => Lamaran::where('status', 'ditolak')->count(),
                'diterima' => Lamaran::where('status', 'diterima')->count(),
            ];
        }
        return response()->json([
            'user' => $totalUser,
            'perusahaan' => $totalPerusahaan,
            'pelamar' => $totalPelamar,
            'lowongan' => $totalLowongan,
            'lamaran' => $totalLamaran,
            'absen' => $totalAbsen,
            'terima' => $totalTerima,
            'tolak' => $totalTolak,
            'chart_status' => $chartData,
        ]);
    }
}
