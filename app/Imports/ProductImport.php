<?php

namespace App\Imports;

use App\Models\Product;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ProductImport implements ToCollection, WithHeadingRow
{
    use Importable;

    public $count;

    public function __construct()
    {
        $this->count = 0;
    }

    public function collection(Collection $rows)
    {
        foreach ($rows as $row)
        {
            Product::create([
                'name' => $row['name'] ? trim($row['name']) : null,
                'number' => $row['number'] ? trim($row['number']) : null,
                'code' => $row['code'] ? (int)$row['code'] : null,
                'price' => $row['price'] ? (int)$row['price'] : null,
                'link' => $row['link'] ?? null
            ]);
            $this->count++;
        }
        return $this->count;
    }
}
