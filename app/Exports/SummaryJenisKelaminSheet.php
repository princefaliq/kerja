<?php

namespace App\Exports;

use App\Models\Pelamar;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithTitle;

class SummaryJenisKelaminSheet implements FromArray, WithTitle
{
    public function array(): array
    {
        $laki = Pelamar::where('jenis_kelamin', 'laki-laki')->count();
        $perempuan = Pelamar::where('jenis_kelamin', 'perempuan')->count();

        return [
            ['Jenis Kelamin', 'Jumlah'],
            ['Laki-laki', $laki],
            ['Perempuan', $perempuan],
        ];
    }

    public function title(): string
    {
        return 'Jenis Kelamin';
    }
}
