<?php


namespace App\Library;

use App\Models\Origin;
use App\Models\Temporary;

class ResearchData
{

    public $origin;
    public $shop;
    public $data;

    public  function  __construct()
    {
        $this->origin = Origin::select('name', 'code', 'price')->get();
        $this->shop = Temporary::select('product_id', 'active', 'name', 'code', 'price')->get();
        $this->data = [
            'found' => [],
            'lack' => [],
            'absence' => []
        ];
    }

    public function getData()
    {
        foreach ($this->shop as $item){
            $origin = $this->origin->where('code', $item->code)->first();
            if($origin) {
                $res = null;
                if((int)$item->price > (int)$origin->price) $res= 'меньше';
                if((int)$item->price < (int)$origin->price) $res= 'больше';
                $this->data['found'][] = [
                    'id' => $item->product_id,
                    'active' => $item->active,
                    'name' => $item->name,
                    'code' => $item->code,
                    'old_price' => $item->price,
                    'new_price' => $origin->price,
                    'changes' => $res
                ];
            } else {
                $this->data['lack'][] = $item->toArray();
            }
        }

        $arrCode = $this->shop->pluck('code');
        $this->data['absence'] = $this->origin->whereNotIn('code', $arrCode)->toArray();

        return $this->data;

    }


}





