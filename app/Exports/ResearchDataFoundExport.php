<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithMapping;

class ResearchDataFoundExport implements FromArray, WithHeadings, WithTitle, ShouldAutoSize, WithMapping
{
    protected $rows;

    public function __construct(array $rows)
    {
        $this->rows = $rows;
    }

    public function map($row): array
    {
        return [
            $row['id'],
            $row['active'],
            $row['name'],
            $row['code'],
            $row['old_price'],
            $row['new_price'],
            $row['changes']
        ];
    }

    public function headings(): array
    {
        return [
            'id',
            'Активность',
            'Наименование',
            'Артикул',
            'Старая цена',
            'Новая цена',
            'Изменения'
        ];
    }

    public function array(): array
    {
        return $this->rows;
    }

    public function title(): string
    {
        return 'found';
    }


}
