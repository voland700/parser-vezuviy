<?php

namespace App\Imports;

use App\Models\Origin;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class OriginalImport implements ToCollection, WithHeadingRow
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
            if(!$row['code']) continue;
            Origin::create([
                'name' => trim($row['name']),
                'code' => (int)$row['code'],
                'price' => $row['price']
            ]);
            $this->count++;
        }
        return $this->count;
    }
}
