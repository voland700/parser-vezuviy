<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

use Maatwebsite\Excel\Concerns\Exportable;

class ResearchDataAllExport implements FromArray, WithMultipleSheets
{
    use Exportable;

    protected $sheets;

    public function __construct(array $sheets)
    {
        $this->sheets = $sheets;
    }

    public function array(): array
    {
        return $this->sheets;
    }

    public function sheets(): array
    {
        $sheets = [
            new ResearchDataFoundExport($this->sheets['found']),
            new ResearchDataLackExport($this->sheets['lack']),
            new ResearchDataEmptyExport($this->sheets['empty']),
            new ResearchDataAbsenceExport($this->sheets['absence'])
        ];
        return $sheets;
    }
}
