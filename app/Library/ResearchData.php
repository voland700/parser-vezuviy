<?php


namespace App\Library;

use App\Models\Origin;
use App\Models\Temporary;

class ResearchData
{

    public $origin;
    public $shop;
    public $data;

    function __construct()
    {

        $this->origin = Origin::select('name', 'code', 'price')->get();
        $this->data =  [
            'found' => [],
            'lack' => [],
            'empty' => [],
            'absence' => []
        ];
    }

    public function getData($shop)
    {

        if(!$this->origin->count() || !$shop->count() ) return false;

        foreach ($shop as $item){
            if($item->code){
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
            } else {
                $this->data['empty'][] = $item->toArray();
            }
        }
        $arrCode = $shop->pluck('code');
        $this->data['absence'] = $this->origin->whereNotIn('code', $arrCode)->toArray();
        return $this->data;
    }
}





