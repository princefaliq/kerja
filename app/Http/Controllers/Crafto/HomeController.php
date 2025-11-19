<?php

namespace App\Http\Controllers\Crafto;

use App\Http\Controllers\Controller;
use App\Models\Lowongan;
use App\Models\Testimoni;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class HomeController extends Controller
{

    public function index()
    {
        $lowongans = Lowongan::select(
            'id',
            'user_id',
            'judul',
            'slug',
            'bidang_pekerjaan',
            'lokasi',
            'rentang_gaji',
            'batas_lamaran',
            'created_at'
        )
            ->with(['user:id,name,avatar'])
            ->where('status', 1)
            ->latest()
            ->get();
        $testimonis = Testimoni::with('user')
            ->where('is_approved', true)
            ->latest()
            ->get();

        $totalLowongan = Lowongan::where('status', 1)
            ->where(function ($q) {
                $q->whereDate('batas_lamaran', '>=', Carbon::today())
                    ->orWhereNull('batas_lamaran');
            })
            ->sum('jumlah_lowongan');

        // Format singkat angka (contoh: 1K, 1.5M, 2.3B)
        if ($totalLowongan >= 1000000000) {
            $totalLowongan = number_format($totalLowongan / 1000000000, 1) . 'B';
        } elseif ($totalLowongan >= 1000000) {
            $totalLowongan = number_format($totalLowongan / 1000000, 1) . 'M';
        } elseif ($totalLowongan >= 1000) {
            $totalLowongan = number_format($totalLowongan / 1000, 1) . 'K';
        }


        return view('crafto.home',compact('lowongans','totalLowongan','testimonis'));
    }
    public function getPerusahaan()
    {
        $perusahaans = User::whereHas('roles', function ($q) {
            $q->where('name', 'Perusahaan');
        })
            ->select('id', 'name', 'avatar')
            ->latest()
            ->get()
            ->map(function ($item) {
                return [
                    'id' => $item->id,
                    'name' => $item->name,
                    'avatar_url' => $item->avatar_url, // otomatis panggil accessor
                ];
            });


        return response()->json($perusahaans);
    }

}
