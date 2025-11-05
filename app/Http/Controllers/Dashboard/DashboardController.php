<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
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
        $totalUser = User::whereHas('roles', fn($q) => $q->where('name', 'User'))->count();
        $totalPerusahaan = User::whereHas('roles', fn($q) => $q->where('name', 'Perusahaan'))->count();
        $totalPelamar = Pelamar::count();

        // ✅ Jumlahkan field jumlah_lowongan, bukan count baris
        $totalLowongan = Lowongan::sum('jumlah_lowongan');

        return response()->json([
            'user' => $totalUser,
            'perusahaan' => $totalPerusahaan,
            'pelamar' => $totalPelamar,
            'lowongan' => $totalLowongan,
        ]);
    }
}
