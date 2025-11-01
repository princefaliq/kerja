<?php

namespace App\Http\Controllers\Crafto;

use App\Http\Controllers\Controller;
use App\Models\Lamaran;
use App\Models\Lowongan;
use App\Models\Pelamar;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Str;

class LamarController extends Controller
{
    public function daftar(Request $request)
    {
        $sudahIsi = Pelamar::where('user_id', auth()->id())
            ->exists();
        if(!$sudahIsi)
        {
            abort(404);
        }
        // Validasi input
        $request->validate([
            'id_lowongan' => 'required|exists:lowongan,id',
        ]);
        $user = Auth::user();
        if(!$user->hasRole('User'))
        {
            abort(403);
        }
        $sudahMelamar = Lamaran::where('user_id', $user->id)
            ->where('lowongan_id', $request->id_lowongan)
            ->exists();

        if ($sudahMelamar) {
            return redirect()->back()->with('error', 'Anda sudah melamar pada lowongan ini.');
        }
        Lamaran::create([
            'user_id' => $user->id,
            'lowongan_id' => $request->id_lowongan,
            'status' => 'dikirim',
        ]);

        return redirect()->back()->with('success', 'Lamaran berhasil dikirim!');
    }

}
