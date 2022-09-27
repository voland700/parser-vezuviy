<?php

namespace App\Exports\Sheets;

use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\FromArray;

use Maatwebsite\Excel\Concerns\WithTitle;

class ResearchDataFoundExport implements FromArray, WithMapping, WithHeadings, WithTitle
{
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
            'id',
            'Активность',
            'Наименование',
            'Артикул',
            'Старая цена',
            'Новая цена',
            'Изменения'
        ];
    }

    public function map($data): array
    {
        return [
            $data['id'],
            $data['active'],
            $data['name'],
            $data['code'],
            $data['old_price'],
            $data['new_price'],
            $data['changes']
        ];
    }

    public function title(): string
    {
        return 'Товары';
    }




}

