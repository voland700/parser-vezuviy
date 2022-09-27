<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;
use Maatwebsite\Excel\Concerns\FromArray;

class ResearchDataAllExport implements WithMultipleSheets
{
    use Exportable;

    protected $found;
    protected $lack;
    protected $absence;
    protected $data;


    public function collection(array $data)
    {
        dd($data);

        $this->found = $data['found'];
        $this->lack = $data['lack'];
        $this->absence = $data['absence'];
    }

    public function sheets(): array
    {
        $sheets = [];
        //dd(new ResearchDataFoundExport($this->found));
        if($this->found) $sheets[] = new ResearchDataFoundExport($this->found);
        if($this->lack)  $sheets[] = new ResearchDataLackExport($this->lack);
        if($this->absence) $sheets[] = new ResearchDataAbsenceExport($this->absence);
        return $sheets;
    }
}
