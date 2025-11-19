<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class LaporanSummaryExport implements WithMultipleSheets
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function sheets(): array
    {
        return [
            new SummaryJenisKelaminSheet(),
            new SummaryPendidikanSheet(),
            new SummaryKabupatenSheet(),
        ];
    }
}
