<?php


namespace App\Library;
use Carbon\Carbon;

class GetInfo
{
    static $data = [
        'count'=> 0,
        'date' => null
    ];

    static function info($obj)
    {
        if(!$obj->count() > 0) return self::$data;
        self::$data['count'] = $obj->count();
        self::$data['date'] = Carbon::parse($obj->select('created_at')->first()->created_at)->translatedFormat('j F Y');
        return self::$data;
    }
}
