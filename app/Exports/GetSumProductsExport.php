<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\Exportable;

class GetSumProductsExport implements  FromArray, WithHeadings,  WithMapping
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
            $row['id'],
            $row['name'],
            $row['code'],
            $row['price']
        ];
    }

    public function headings(): array
    {
        return [
            'id',
            'Наименование',
            'Коды товаров',
            'Цена'
        ];
    }

    public function array(): array
    {
        return $this->rows;
    }
}

