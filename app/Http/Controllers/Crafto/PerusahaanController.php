<?php

namespace App\Http\Controllers\Crafto;

use App\Http\Controllers\Controller;
use App\Models\Lowongan;
use App\Models\Perusahaan;
use App\Models\User;
use Illuminate\Http\Request;

class PerusahaanController extends Controller
{
    public function show($slug)
    {
        // Cari perusahaan berdasarkan slug
        $perusahaan = Perusahaan::where('slug', $slug)->firstOrFail();

        // Ambil relasi user dari perusahaan
        $user = $perusahaan->user;

        // Ambil lowongan yang aktif berdasarkan user_id perusahaan tersebut
        $lowongans = Lowongan::where('user_id', $perusahaan->user_id)
            ->where('status', 1)
            ->get();

        // Kirim data ke view
        return view('crafto.perusahaan', compact('user', 'perusahaan', 'lowongans'));
    }

}
