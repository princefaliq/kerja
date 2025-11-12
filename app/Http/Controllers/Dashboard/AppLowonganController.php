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
                                ->orWhere('jumlah_lowongan', 'like', "%{$search}%");
                        });
                    }
                    // 🟢 Filter berdasarkan status dari dropdown
                    if ($request->filled('status')) {
                        $status = trim($request->status);

                        // Pastikan value '1' dan '0' bisa diterima
                        if ($status === '1' || $status === '0') {
                            $query->where('status', $status);
                        }
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
            'jenis_pekerjaan' => 'required|string|max:255',
            'tipe_pekerjaan' => 'nullable|string|max:255',
            'jenis_kelamin' => 'nullable|in:Laki-laki,Perempuan,Laki-laki/Perempuan',
            'rentang_gaji' => 'nullable|string|max:255',
            'jumlah_lowongan' => 'nullable|integer|min:1',
            'batas_lamaran' => 'nullable|date',
            'status' => 'boolean',
            'deskripsi_pekerjaan' => 'nullable|string',
            'persyaratan_khusus' => 'nullable|string',
            'pendidikan_minimal' => 'nullable|in:SD,SMP,SMA,D1,D2,D3,S1/D4,S2,S3',
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
    $validated = $request->validate([
        'judul'               => 'required|string|max:255',
        'lokasi'              => 'required|string|max:255',
        'bidang_pekerjaan'    => 'nullable|string|max:255',
        'jenis_pekerjaan'     => 'required|string|max:50',
        'tipe_pekerjaan'      => 'nullable|string|max:50',
        'jenis_kelamin'       => 'nullable|string|max:50',
        'rentang_gaji'        => 'nullable|string|max:100',
        'jumlah_lowongan'     => 'nullable|integer|min:1',
        'batas_lamaran'       => 'nullable|date',
        'status'              => 'required|in:0,1',
        'deskripsi_pekerjaan' => 'nullable|string',
        'persyaratan_khusus'  => 'nullable|string',
        'pendidikan_minimal'  => 'nullable|in:SD,SMP,SMA,D1,D2,D3,S1/D4,S2,S3',
        'status_pernikahan'   => 'nullable|string|max:50',
        'pengalaman_minimal'  => 'nullable|integer|min:0',
        'kondisi_fisik'       => 'nullable|string|max:50',
        'keterampilan'        => 'nullable|string',
    ]);

    // Update data ke database
    $lowongan->update([
        'judul'               => $validated['judul'],
        'lokasi'              => $validated['lokasi'],
        'bidang_pekerjaan'    => $validated['bidang_pekerjaan'] ?? null,
        'jenis_pekerjaan'     => $validated['jenis_pekerjaan'] ?? null,
        'tipe_pekerjaan'      => $validated['tipe_pekerjaan'] ?? null,
        'jenis_kelamin'       => $validated['jenis_kelamin'] ?? null,
        'rentang_gaji'        => $validated['rentang_gaji'] ?? null,
        'jumlah_lowongan'     => $validated['jumlah_lowongan'] ?? null,
        'batas_lamaran'       => $validated['batas_lamaran'] ?? null,
        'status'              => $validated['status'],
        'deskripsi_pekerjaan' => $validated['deskripsi_pekerjaan'] ?? null,
        'persyaratan_khusus'  => $validated['persyaratan_khusus'] ?? null,
        'pendidikan_minimal'  => $validated['pendidikan_minimal'] ?? null,
        'status_pernikahan'   => $validated['status_pernikahan'] ?? null,
        'pengalaman_minimal'  => $validated['pengalaman_minimal'] ?? null,
        'kondisi_fisik'       => $validated['kondisi_fisik'] ?? null,
        'keterampilan'        => $validated['keterampilan'] ?? null,
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
