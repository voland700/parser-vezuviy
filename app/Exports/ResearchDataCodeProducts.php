<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\Exportable;

class ResearchDataCodeProducts implements FromArray, WithHeadings, ShouldAutoSize, WithMapping
{
    use Exportable;

    protected $rows;

    public function __construct(array $rows)
    {
        $this->rows = $rows;
    }

    public function map($row): array
    {
        return [
            $row['code'],
            $row['name'],
            $row['number'],
            $row['price'],
            $row['link'],
        ];
    }

    public function headings(): array
    {
        return [
            'штрих-код',
            'Название',
            'Артикул',
            'Цена',
            'Ссылка'
        ];
    }

    public function array(): array
    {
        return $this->rows;
    }
}
