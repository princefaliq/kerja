<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Absensi;
use App\Models\Acara;
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
        $acaras = Acara::orderBy('tanggal_mulai', 'desc')->get();
        return view('content.dashboard.dashboard',compact('acaras'));
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
    public function widgetData(Request $request)
    {
        $filterAcara = $request->acara_id;
        $tanggalAwal = $request->tanggal_awal;
        $tanggalAkhir = $request->tanggal_akhir;

        $user = auth()->user();

        $totalUser = User::whereHas('roles', fn($q) => $q->where('name', 'User'))->count();

        $totalPerusahaan = User::whereHas('roles', fn($q) => $q->where('name', 'Perusahaan'))->count();

        $pelamarQuery = Pelamar::query();
        $absenQuery = Absensi::query();
        $lowonganQuery = Lowongan::query();
        $lamaranQuery = Lamaran::query();

        if ($tanggalAwal && $tanggalAkhir) {

            $absenQuery->whereBetween(
                'created_at',
                [
                    $tanggalAwal . ' 00:00:00',
                    $tanggalAkhir . ' 23:59:59'
                ]
            );

            $lowonganQuery->whereBetween(
                'created_at',
                [
                    $tanggalAwal . ' 00:00:00',
                    $tanggalAkhir . ' 23:59:59'
                ]
            );

            $lamaranQuery->whereBetween(
                'created_at',
                [
                    $tanggalAwal . ' 00:00:00',
                    $tanggalAkhir . ' 23:59:59'
                ]
            );
        }

        if ($filterAcara == 'non_acara') {

            $lowonganQuery->whereNull('acara_id');

            $lamaranQuery->whereHas('lowongan', function ($q) {
                $q->whereNull('acara_id');
            });

            $absenQuery->whereRaw('1=0');
        }
        elseif ($filterAcara) {

            $absenQuery->where('acara_id', $filterAcara);

            $lowonganQuery->where('acara_id', $filterAcara);

            $lamaranQuery->whereHas('lowongan', function ($q) use ($filterAcara) {
                $q->where('acara_id', $filterAcara);
            });
        }
        $totalPelamar = $pelamarQuery->count();
        $totalAbsen = $absenQuery->count();
        // Cek role user login
        if ($user->hasRole('Admin')) {
            // Admin: total semua lowongan aktif
            $totalLowongan = (clone $lowonganQuery)
                ->where('status', 1)
                ->sum('jumlah_lowongan');

            $totalLamaran = (clone $lamaranQuery)->count();

            $totalTolak = (clone $lamaranQuery)
                ->where('status', 'ditolak')
                ->count();

            $totalTerima = (clone $lamaranQuery)
                ->where('status', 'diterima')
                ->count();
        } elseif ($user->hasRole('Perusahaan')) {
            // Perusahaan: total lowongan miliknya sendiri
            $lowonganPerusahaan = clone $lowonganQuery;

            $lowonganPerusahaan->where('user_id', $user->id);

            $totalLowongan = (clone $lowonganPerusahaan)
                ->where('status', 1)
                ->sum('jumlah_lowongan');

            $totalLamaran = (clone $lamaranQuery)
                ->whereHas('lowongan', function ($q) use ($user) {
                    $q->where('user_id', $user->id);
                })
                ->count();

            $totalTolak = (clone $lamaranQuery)
                ->where('status', 'ditolak')
                ->whereHas('lowongan', function ($q) use ($user) {
                    $q->where('user_id', $user->id);
                })
                ->count();

            $totalTerima = (clone $lamaranQuery)
                ->where('status', 'diterima')
                ->whereHas('lowongan', function ($q) use ($user) {
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
        $chartQuery = clone $lamaranQuery;

        if ($user->hasRole('Perusahaan')) {
            $chartQuery->whereHas('lowongan', function ($q) use ($user) {
                $q->where('user_id', $user->id);
            });
        }

        $chartData = [
            'dikirim' => (clone $chartQuery)->where('status', 'dikirim')->count(),
            'ditolak' => (clone $chartQuery)->where('status', 'ditolak')->count(),
            'diterima' => (clone $chartQuery)->where('status', 'diterima')->count(),
        ];
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
