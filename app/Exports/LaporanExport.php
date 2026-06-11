<?php

namespace App\Exports;

use App\Models\Pelamar;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class LaporanExport implements FromCollection, WithMapping, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Pelamar::select(
            'pelamar.nik',
            'users.name as nama',
            'pelamar.jenis_kelamin',
            'pelamar.pendidikan_terahir',
            'pelamar.kabupaten',
            'pelamar.kecamatan',
            'pelamar.desa',
            'pelamar.alamat',
            'pelamar.status_pernikahan',
            'pelamar.disabilitas',
            'pelamar.created_at'
        )
            ->join('users', 'users.id', '=', 'pelamar.user_id')
            ->get();
    }
    public function headings(): array
    {
        return [
            'NIK',
            'Nama',
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
            $pelamar->nama,
            ucfirst($pelamar->jenis_kelamin),
            $pelamar->pendidikan_terahir,
            $pelamar->kabupaten,
            $pelamar->kecamatan,
            $pelamar->desa,
            $pelamar->alamat,
            $pelamar->status_pernikahan,
            ucfirst($pelamar->disabilitas),
            date('d-m-Y', strtotime($pelamar->created_at))
        ];
    }

}
