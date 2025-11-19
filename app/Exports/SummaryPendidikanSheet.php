<?php

namespace App\Exports;

use App\Models\Pelamar;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithTitle;

class SummaryPendidikanSheet implements FromArray, WithTitle
{
    public function array(): array
    {
        $data = Pelamar::select('pendidikan_terahir', DB::raw('count(*) as total'))
            ->groupBy('pendidikan_terahir')
            ->orderByRaw("
                FIELD(pendidikan_terahir, 'SD', 'SMP', 'SMA', 'SMK', 'D1', 'D2', 'D3', 'S1/D4', 'S2', 'S3')
            ")
            ->get();

        $rows = [['Pendidikan', 'Jumlah']];
        foreach ($data as $row) {
            $rows[] = [$row->pendidikan_terahir, $row->total];
        }

        return $rows;
    }

    public function title(): string
    {
        return 'Pendidikan';
    }
}

