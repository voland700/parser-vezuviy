<?php

namespace App\Exports\Sheets;

use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\FromArray;

use Maatwebsite\Excel\Concerns\WithTitle;

use Maatwebsite\Excel\Concerns\Exportable;

class ResearchDataAbsenceExport implements FromArray, WithMapping, WithHeadings, WithTitle
{
    use Exportable;


    protected $data;

    public function __construct(array $data)
    {
        $this->data = $data;
    }

    public function array(): array
    {
        return $this->data;
    }

    public function headings(): array
    {
        return [
            'Наименование',
            'Артикул',
            'Цена'
        ];
    }

    public function map($data): array
    {
        return [
            $data['name'],
            $data['code'],
            $data['price']
        ];
    }

    public function title(): string
    {
        return 'Нет на сайте';
    }




}
