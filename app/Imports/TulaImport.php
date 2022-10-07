<?php

namespace App\Imports;

use App\Models\Tula;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class TulaImport implements ToCollection, WithHeadingRow
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
            if(!$row['product_id']) continue;
            Tula::create([
                'product_id' => $row['product_id'],
                'active' => $row['active'] ?? null,
                'name' => $row['name'] ? trim($row['name']) : null,
                'code' =>  $row['code'] ? (int)($row['code']) : null,
                'price' => $row['price'] ? intval($row['price']) : null
            ]);
            $this->count++;
        }
        return $this->count;
    }
}
