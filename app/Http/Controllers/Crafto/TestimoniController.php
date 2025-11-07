<?php

namespace App\Http\Controllers\Crafto;

use App\Http\Controllers\Controller;
use App\Models\Testimoni;
use Illuminate\Http\Request;

class TestimoniController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'isi' => 'required|string|max:500',
        ]);

        // Ambil pelamar yang terhubung dengan user login
        $pelamar = auth()->user()->pelamar;

        if (!$pelamar) {
            return redirect()->back()->with('error', 'Data pelamar tidak ditemukan.');
        }

        // Simpan testimoni
        Testimoni::create([
            'pelamar_id' => $pelamar->id,
            'isi' => $request->isi,
            'status' => false, // default belum dikonfirmasi admin
        ]);

        return redirect()->back()->with('success', 'Terima kasih! Testimoni Anda telah terkirim dan menunggu konfirmasi admin.');
    }

}
