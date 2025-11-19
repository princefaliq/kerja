<?php

namespace App\Exports;

use App\Models\Pelamar;
use Maatwebsite\Excel\Concerns\FromCollection;

class LaporanExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Pelamar::select(
            'nik',
            'jenis_kelamin',
            'pendidikan_terahir',
            'kabupaten',
            'kecamatan',
            'desa',
            'alamat',
            'status_pernikahan',
            'disabilitas',
            'created_at'
        )->get();
    }
    public function headings(): array
    {
        return [
            'NIK',
            'Jenis Kelamin',
            'Pendidikan Terakhir',
            'Kabupaten',
            'Kecamatan',
            'Desa',
            'Alamat',
            'Status Pernikahan',
            'Disabilitas',
            'Tanggal Daftar'
        ];
    }
    public function map($pelamar): array
    {
        return [
            $pelamar->nik,
            ucfirst($pelamar->jenis_kelamin),
            $pelamar->pendidikan_terahir,
            $pelamar->kabupaten,
            $pelamar->kecamatan,
            $pelamar->desa,
            $pelamar->alamat,
            $pelamar->status_pernikahan,
            ucfirst($pelamar->disabilitas),
            $pelamar->created_at->format('d-m-Y')
        ];
    }

}
