<?php

namespace App\Exports;

use App\Models\Pelamar;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithTitle;

class SummaryKabupatenSheet implements FromArray, WithTitle
{
    public function array(): array
    {
        $data = Pelamar::select('kabupaten', DB::raw('count(*) as total'))
            ->groupBy('kabupaten')
            ->orderBy('kabupaten')
            ->get();

        $rows = [['Kabupaten', 'Jumlah Hadir']];
        foreach ($data as $row) {
            $rows[] = [$row->kabupaten, $row->total];
        }

        return $rows;
    }

    public function title(): string
    {
        return 'Kabupaten';
    }
}
