<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Lowongan;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Yajra\DataTables\Facades\DataTables;

class AppLowonganController extends Controller
{
    public function index(Request $request)
    {
        // Jika request berasal dari AJAX (DataTables)
        if ($request->ajax()) {
            $user = Auth::user();

            $query = Lowongan::with('user')
                ->when(!$user->hasRole('Admin'), function ($q) use ($user) {
                    $q->where('user_id', $user->id);
                });

            return DataTables::eloquent($query)
                // 🧠 tambahkan bagian filter untuk pencarian
                ->filter(function ($query) use ($request) {
                    if ($request->has('search') && $request->search['value']) {
                        $search = $request->search['value'];
                        $query->where(function ($q) use ($search) {
                            $q->where('judul', 'like', "%{$search}%")
                                ->orWhere('lokasi', 'like', "%{$search}%")
                                ->orWhere('bidang_pekerjaan', 'like', "%{$search}%")
                                ->orWhere('jenis_pekerjaan', 'like', "%{$search}%")
                                ->orWhere('rentang_gaji', 'like', "%{$search}%");
                        });
                    }
                })
                ->editColumn('batas_lamaran', function ($lowongan) {
                    return $lowongan->batas_lamaran
                        ? Carbon::parse($lowongan->batas_lamaran)->format('d/m/Y')
                        : '-';
                })
                ->make(true);
        }

        // Render tampilan utama jika bukan request AJAX
        return view('content.lowongan.index');

    }
    public function create()
    {
        return view('content.lowongan.create');
    }
    public function store(Request $request)
    {
        $validated = $request->validate([
            'judul' => 'required|string|max:255',
            'lokasi' => 'required|string|max:255',
            'bidang_pekerjaan' => 'nullable|string|max:255',
            'jenis_pekerjaan' => 'nullable|string|max:255',
            'tipe_pekerjaan' => 'nullable|string|max:255',
            'jenis_kelamin' => 'nullable|in:Laki-laki,Perempuan,Laki-laki/Perempuan',
            'rentang_gaji' => 'nullable|string|max:255',
            'jumlah_lowongan' => 'nullable|integer|min:1',
            'batas_lamaran' => 'nullable|date',
            'status' => 'boolean',
            'deskripsi_pekerjaan' => 'nullable|string',
            'persyaratan_khusus' => 'nullable|string',
            'pendidikan_minimal' => 'nullable|in:SD,SMP,SMA,D1,D2,D3,S1,S2,S3',
            'status_pernikahan' => 'nullable|in:Nikah,Belum,Tidak Ada Preferensi',
            'pengalaman_minimal' => 'nullable|integer|min:0',
            'kondisi_fisik' => 'nullable|in:Non Disabilitas,Disabilitas',
            'keterampilan' => 'nullable|string',
        ]);
        $validated['user_id'] = Auth::id();
        Lowongan::create($validated);
        return redirect()->route('lowongan.index')->with('success', 'Lowongan berhasil ditambahkan.');
    }
    public function edit($id)
    {
        $lowongan = Lowongan::findOrFail($id);

        return view('content.lowongan.edit', compact('lowongan'));
    }
    public function update(Request $request, $id)
    {
        $lowongan = Lowongan::findOrFail($id);

        // Validasi input
        $request->validate([
            'judul'            => 'required|string|max:255',
            'lokasi'           => 'required|string|max:255',
            'bidang_pekerjaan' => 'nullable|string|max:255',
            'jenis_pekerjaan'  => 'nullable|string|max:50',
            'tipe_pekerjaan'   => 'nullable|string|max:50',
            'jenis_kelamin'    => 'nullable|string|max:50',
            'rentang_gaji'     => 'nullable|string|max:100',
            'batas_lamaran'    => 'nullable|date',
        ]);

        // Update data
        $lowongan->update([
            'judul'            => $request->judul,
            'lokasi'           => $request->lokasi,
            'bidang_pekerjaan' => $request->bidang_pekerjaan,
            'jenis_pekerjaan'  => $request->jenis_pekerjaan,
            'tipe_pekerjaan'   => $request->tipe_pekerjaan,
            'jenis_kelamin'    => $request->jenis_kelamin,
            'rentang_gaji'     => $request->rentang_gaji,
            'batas_lamaran'    => $request->batas_lamaran,
        ]);

        return redirect()
            ->route('lowongan.index')
            ->with('success', 'Lowongan berhasil diperbarui.');
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function toggleStatus(Request $request)
    {
        $lowongan = Lowongan::findOrFail($request->id);
        $lowongan->status = !$lowongan->status; // toggle true/false
        $lowongan->save();

        return response()->json([
            'success' => true,
            'status' => $lowongan->status ? 'Aktif' : 'Nonaktif'
        ]);
    }

    public function qrcode($slug)
    {
        $lowongan = Lowongan::where('slug', $slug)->firstOrFail();
        $url = url('lowongan-kerja/' . $lowongan->slug);

        $svg = QrCode::format('svg')
            ->size(250)
            ->margin(2)
            ->generate($url);

        return view('content.lowongan.qrcode', compact('lowongan', 'svg', 'url'));
    }

    public function downloadQrcode($slug)
    {
        $lowongan = Lowongan::where('slug', $slug)->firstOrFail();
        $url = url('lowongan-kerja/' . $lowongan->slug);

        $svg = QrCode::format('svg')
            ->size(300)
            ->margin(1)
            ->generate($url);

        $fileName = 'qrcode-' . $lowongan->slug . '.svg';

        return Response::make($svg, 200, [
            'Content-Type' => 'image/svg+xml',
            'Content-Disposition' => "attachment; filename={$fileName}",
        ]);
    }

}
