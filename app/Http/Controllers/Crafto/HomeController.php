<?php

namespace App\Http\Controllers\Crafto;

use App\Http\Controllers\Controller;
use App\Models\Acara;
use App\Models\Informasi;
use App\Models\Lowongan;
use App\Models\Testimoni;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class HomeController extends Controller
{

    public function index()
    {
        $jadwalAcara = Acara::whereDate('tanggal_selesai', '>=', today())
            ->orderBy('tanggal_mulai')
            ->take(3)
            ->get();
        $informasis = Informasi::where('is_active', true)
            ->orderBy('urutan')
            ->orderByDesc('published_at')
            ->get();
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

            ->sum('jumlah_lowongan');

        // Format singkat angka (contoh: 1K, 1.5M, 2.3B)
        if ($totalLowongan >= 1000000000) {
            $totalLowongan = number_format($totalLowongan / 1000000000, 1) . 'B';
        } elseif ($totalLowongan >= 1000000) {
            $totalLowongan = number_format($totalLowongan / 1000000, 1) . 'M';
        } elseif ($totalLowongan >= 1000) {
            $totalLowongan = number_format($totalLowongan / 1000, 1) . 'K';
        }
        $acara = Acara::latest()->first();

        return view('crafto.home',compact('lowongans','totalLowongan','testimonis','acara','jadwalAcara','informasis'));
    }
    public function getPerusahaan()
    {
        $perusahaans = User::whereHas('roles', function ($q) {
            $q->where('name', 'Perusahaan');
        })
            ->with('perusahaan') // <-- load relasi
            ->select('id', 'name', 'avatar')
            ->latest()
            ->get()
            ->map(function ($item) {
                return [
                    'id' => $item->id,
                    'name' => $item->name,
                    'avatar_url' => $item->avatar_url, // otomatis panggil accessor
                    'slug' => $item->perusahaan->slug, // <-- muncul datanya
                ];
            });


        return response()->json($perusahaans);
    }

}
