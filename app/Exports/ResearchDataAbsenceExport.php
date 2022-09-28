<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithMapping;

class ResearchDataAbsenceExport implements FromArray, WithHeadings, WithTitle, ShouldAutoSize, WithMapping
{

    protected $rows;

    public function __construct(array $rows)
    {
        $this->rows = $rows;
    }

    public function map($row): array
    {
        return [
            $row['name'],
            $row['code'],
            $row['price']
        ];
    }

    public function headings(): array
    {
        return [
            'Наименование',
            'Артикул',
            'Цена'
        ];
    }

    public function array(): array
    {
        return $this->rows;
    }

    public function title(): string
    {
        return 'absence';
    }
}
