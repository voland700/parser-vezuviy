<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

use Maatwebsite\Excel\Concerns\Exportable;


class AstonExport implements FromView
{
    use Exportable;

    protected $products;
    protected $names;

    public function __construct(array $products, array $names)
    {
        $this->products = $products;
        $this->names = $names;
    }

    public function view(): View
    {
        return view('parser.excel_table_aston', [
            'products' => $this->products,
            'NamesProperty' => $this->names
        ]);
    }
}
