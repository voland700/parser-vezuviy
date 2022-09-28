<?php


namespace App\Library;

use App\Models\Origin;
use App\Models\Temporary;

class ResearchData
{

    public static $origin  = null;
    public static $shop  = null;
    public static $data = [
        'found' => [],
        'lack' => [],
        'empty' => [],
        'absence' => []
    ];

    public  function  __construct()
    {
        //self::$origin = Origin::select('name', 'code', 'price')->get();
        //self::$shop = Temporary::select('product_id', 'active', 'name', 'code', 'price')->get();
    }

    public static function getData()
    {
        if(!self::$origin) self::$origin = Origin::select('name', 'code', 'price')->get();
        if(!self::$shop) self::$shop = Temporary::select('product_id', 'active', 'name', 'code', 'price')->get();

        foreach (self::$shop as $item){
            if($item->code){
                $origin = self::$origin->where('code', $item->code)->first();
                if($origin) {
                    $res = null;
                    if((int)$item->price > (int)$origin->price) $res= 'меньше';
                    if((int)$item->price < (int)$origin->price) $res= 'больше';
                    self::$data['found'][] = [
                        'id' => $item->product_id,
                        'active' => $item->active,
                        'name' => $item->name,
                        'code' => $item->code,
                        'old_price' => $item->price,
                        'new_price' => $origin->price,
                        'changes' => $res
                    ];
                } else {
                    self::$data['lack'][] = $item->toArray();
                }
            } else {
                self::$data['empty'][] = $item->toArray();
            }
        }

        $arrCode = self::$shop->pluck('code');
        self::$data['absence'] = self::$origin->whereNotIn('code', $arrCode)->toArray();

        return self::$data;

    }


}





