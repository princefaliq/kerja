<?php

namespace App\Http\Controllers\Dashboard;

use App\Exports\LaporanExport;
use App\Exports\LaporanSummaryExport;
use App\Http\Controllers\Controller;
use App\Models\Acara;
use App\Models\Pelamar;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class AppLaporanController extends Controller
{
    public function index()
    {
        $acaras = Acara::orderBy('tanggal_mulai', 'desc')->get();
        $idAcara = request('id_acara');

        // Query dasar peserta yang sudah absen
        $query = Pelamar::join('absensis', 'pelamar.user_id', '=', 'absensis.user_id');

        if ($idAcara) {
            $query->where('absensis.acara_id', $idAcara);
        }

        // =====================
        // Statistik Gender
        // =====================

        $totalLaki = (clone $query)
            ->where('jenis_kelamin', 'laki-laki')
            ->distinct('pelamar.id')
            ->count('pelamar.id');

        $totalPerempuan = (clone $query)
            ->where('jenis_kelamin', 'perempuan')
            ->distinct('pelamar.id')
            ->count('pelamar.id');

        // =====================
        // Statistik Pendidikan
        // =====================

        $dataPendidikan = (clone $query)
            ->select(
                'pendidikan_terahir',
                'jenis_kelamin',
                DB::raw('COUNT(DISTINCT pelamar.id) as total')
            )
            ->groupBy('pendidikan_terahir', 'jenis_kelamin')
            ->get();

        $kategori = [
            'SD', 'SMP', 'SMA', 'SMK',
            'D1', 'D2', 'D3', 'S1/D4', 'S2', 'S3'
        ];

        $laki = [];
        $perempuan = [];

        foreach ($kategori as $pendidikan) {

            $laki[] = $dataPendidikan
                ->where('pendidikan_terahir', $pendidikan)
                ->where('jenis_kelamin', 'laki-laki')
                ->sum('total');

            $perempuan[] = $dataPendidikan
                ->where('pendidikan_terahir', $pendidikan)
                ->where('jenis_kelamin', 'perempuan')
                ->sum('total');
        }

        // =====================
        // Statistik Kabupaten
        // =====================

        $dataKabupaten = (clone $query)
            ->select(
                'kabupaten',
                DB::raw('COUNT(DISTINCT pelamar.id) as total')
            )
            ->groupBy('kabupaten')
            ->orderBy('kabupaten')
            ->pluck('total', 'kabupaten');

        return view('content.laporan.index', compact(
            'totalLaki',
            'totalPerempuan',
            'dataKabupaten',
            'kategori',
            'laki',
            'perempuan',
            'idAcara',
            'acaras'
        ));
    }
    public function export()
    {
        return Excel::download(new LaporanExport, 'laporan_pencaker.xlsx');
    }
    public function exportSummary()
    {
        return Excel::download(new LaporanSummaryExport, 'laporan_rekap_pencaker.xlsx');
    }
}
