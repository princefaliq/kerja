<?php

namespace App\Http\Controllers\Dashboard;

use App\Exports\LaporanExport;
use App\Exports\LaporanSummaryExport;
use App\Http\Controllers\Controller;
use App\Models\Pelamar;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class AppLaporanController extends Controller
{
    public function index()
    {
        // === 1️⃣ Jumlah berdasarkan jenis kelamin ===
        $totalLaki = Pelamar::where('jenis_kelamin', 'laki-laki')->count();
        $totalPerempuan = Pelamar::where('jenis_kelamin', 'perempuan')->count();

        // === 2️⃣ Jumlah berdasarkan pendidikan terakhir ===
        $dataPendidikan = Pelamar::select('pendidikan_terahir', DB::raw('count(*) as total'))
            ->groupBy('pendidikan_terahir')
            ->orderByRaw("
                FIELD(pendidikan_terahir, 'SD', 'SMP', 'SMA', 'SMK', 'D1', 'D2', 'D3', 'S1/D4', 'S2', 'S3')
            ")
            ->pluck('total', 'pendidikan_terahir');

        // === 3️⃣ Jumlah pelamar berdasarkan kabupaten ===
        $dataKabupaten = Pelamar::select('kabupaten', DB::raw('count(*) as total'))
            ->groupBy('kabupaten')
            ->orderBy('kabupaten', 'asc')
            ->pluck('total', 'kabupaten');
        return view('content.laporan.index',compact('totalLaki','totalPerempuan','dataPendidikan','dataKabupaten'));
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
