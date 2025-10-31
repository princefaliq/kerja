<?php

namespace App\Http\Controllers\Crafto;

use App\Http\Controllers\Controller;
use App\Models\Lowongan;
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
            ->where(function ($query) {
                $query->whereDate('batas_lamaran', '>=', Carbon::today())
                    ->orWhereNull('batas_lamaran');
            })
            ->latest()
            ->get();
        $totalLowongan = Lowongan::where(function ($q) {
            $q->whereDate('batas_lamaran', '>=', Carbon::today())
                ->orWhereNull('batas_lamaran');
        })->count();

        return view('crafto.home',compact('lowongans','totalLowongan'));
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
