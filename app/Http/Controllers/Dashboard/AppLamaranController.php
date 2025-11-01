<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Lamaran;
use App\Models\Pelamar;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;

class AppLamaranController extends Controller
{
    public function index(Request $request)
    {
        // 🧠 Ambil ID user yang sedang login
        $user = Auth::user();

        if ($request->ajax()) {
            $query = Lamaran::with(['user', 'lowongan'])
                ->when(!$user->hasRole('Admin'), function ($q) use ($user) {
                    $q->whereHas('lowongan', function ($sub) use ($user) {
                        $sub->where('user_id', $user->id);
                    });
                });

            return DataTables::eloquent($query)
                ->filter(function ($query) use ($request) {
                    // ✅ Filter pencarian teks (kolom umum)
                    if ($request->has('search') && $request->search['value']) {
                        $search = $request->search['value'];
                        $query->where(function ($q) use ($search) {
                            $q->whereHas('user', function ($u) use ($search) {
                                $u->where('name', 'like', "%{$search}%");
                            })
                                ->orWhereHas('lowongan', function ($l) use ($search) {
                                    $l->where('judul', 'like', "%{$search}%")
                                        ->orWhere('lokasi', 'like', "%{$search}%")
                                        ->orWhere('bidang_pekerjaan', 'like', "%{$search}%");
                                })
                                ->orWhere('status', 'like', "%{$search}%");
                        });
                    }

                    // ✅ Filter berdasarkan status dropdown
                    if ($request->has('status') && $request->status !== 'all') {
                        $query->where('status', $request->status);
                    }
                })
                ->addColumn('pelamar', fn($lamaran) => $lamaran->user->name ?? '-')
                ->addColumn('lowongan', fn($lamaran) => $lamaran->lowongan->judul ?? '-')
                ->addColumn('lokasi', fn($lamaran) => $lamaran->lowongan->lokasi ?? '-')
                ->addColumn('bidang_pekerjaan', fn($lamaran) => $lamaran->lowongan->bidang_pekerjaan ?? '-')
                ->addColumn('tanggal_lamaran', fn($lamaran) =>
                            $lamaran->created_at ? Carbon::parse($lamaran->created_at)->format('d/m/Y H:i') : '-'
                            )
                ->addColumn('dokumen', fn ($lamaran)=> 
                '<a class="btn btn-xs btn-info" href="'. url('app/lamaran/detail/'.$lamaran->user->id).'" target="_blank"><i class="ki-duotone ki-faceid fs-2">
 <span class="path1"></span>
 <span class="path2"></span>
 <span class="path3"></span>
 <span class="path4"></span>
 <span class="path5"></span>
 <span class="path6"></span>
</i> Lihat</a>' )
                // ->addColumn('dokumen', function ($lamaran) {
                //     $files = [];
                //     if ($lamaran->pelamar->CvUrl) $files[] = '<a href="' . $lamaran->pelamar->CvUrl. '" target="_blank">CV</a>';
                //     if ($lamaran->pelamar->IjazahUrl) $files[] = '<a href="' . $lamaran->pelamar->IjazahUrl . '" target="_blank">Ijazah</a>';
                //     if ($lamaran->pelamar->KtpUrl) $files[] = '<a href="' . $lamaran->pelamar->KtpUrl . '" target="_blank">KTP</a>';
                //     if ($lamaran->pelamar->Ak1Url) $files[] = '<a href="' .$lamaran->pelamar->Ak1Url . '" target="_blank">AK1</a>';
                //     if ($lamaran->pelamar->SertifikatUrl) $files[] = '<a href="' . $lamaran->pelamar->SertifikatUrl . '" target="_blank">Sertifikat</a>';
                //     if ($lamaran->pelamar->Syarat_lainUrl) $files[] = '<a href="' . $lamaran->pelamar->Syarat_lainUrl . '" target="_blank">Syarat Lain</a>';
                //     if ($lamaran->pelamar->Pass_fotoUrl) $files[] = '<a href="' . $lamaran->pelamar->Pass_fotoUrl . '" target="_blank">Pas Foto</a>';
                //     return implode(' | ', $files) ?: '-';
                // })
                ->addColumn('status', fn($lamaran) => $lamaran->status ?? 'diproses')
                ->addColumn('actions', fn() => '')
                ->rawColumns(['dokumen'])
                ->make(true);
        }


        return view('content.lamaran.index');
    }

    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:diterima,ditolak,diproses',
        ]);

        $lamaran = Lamaran::with('lowongan')->find($id);

        if (!$lamaran) {
            return response()->json(['message' => 'Lamaran tidak ditemukan.'], 404);
        }

        // 🔐 Pastikan hanya pemilik lowongan yang bisa ubah status
        if ($lamaran->lowongan->user_id !== Auth::id()) {
            return response()->json(['message' => 'Anda tidak memiliki izin untuk mengubah lamaran ini.'], 403);
        }

        $lamaran->status = $request->status;
        $lamaran->save();

        return response()->json([
            'message' => "Status lamaran berhasil diubah menjadi '{$request->status}'.",
            'status'  => $lamaran->status,
        ]);
    }

    public function detail($id)
    {
        $profile = Pelamar::firstOrNew(['user_id' => $id]); // bikin objek kosong kalau belum ada
        $profile->loadMissing('user');
        if ($profile->exists) {
            return view('content.lamaran.detail_lamaran',compact('profile'));
        }
    }
    
}
