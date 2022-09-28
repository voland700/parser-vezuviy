<?php


namespace App\Library;

use App\Models\Origin;

class getSumProducts
{
    static $pechnik = [
        4691 => [ 'id' => 4691,  'name' => 'Сенсация «АКВА» 16 (ДТ-4)  с баком 30л',  'code_first' => 4680046792006, 'code_second'  => 4680046791986],
        4692 => [ 'id' => 4692,  'name' => 'Сенсация «АКВА» 22 (ДТ-4) с баком 40л',  'code_first' => 4680046792013, 'code_second'  => 4680046791993],
        5012 => [ 'id' => 5012,  'name' => 'Казан 12л. с крышкой',  'code_first' => 4680019120010, 'code_second'  => 4680019120034],
        5009 => [ 'id' => 5009,  'name' => 'Казан 12л. с ручкой',  'code_first' => 4680019125046, 'code_second'  => 4680019120034],
        5010 => [ 'id' => 5010,  'name' => 'Казан 6л. с крышкой',  'code_first' => 4680019129358, 'code_second'  => 4680019129273],
        5007 => [ 'id' => 5007,  'name' => 'Казан 6л. с ручкой',  'code_first' => 4680019129334, 'code_second'  => 4680019129273],
        5011 => [ 'id' => 5011,  'name' => 'Казан 8л. с крышкой',  'code_first' => 4680019120027, 'code_second'  => 4680019120041],
        5008 => [ 'id' => 5008,  'name' => 'Казан 8л. с ручкой',  'code_first' => 4680019125053, 'code_second'  => 4680019120041],
        5143 => [ 'id' => 5143,  'name' => 'Сербский Казан 14 л.',  'code_first' => 4610094703198, 'code_second'  => 4610094703204],
        4907 => [ 'id' => 4907,  'name' => 'Сковорода чугунная Везувий 6л Ø 380мм',  'code_first' => 4680046790545, 'code_second'  => 4680046790521],
        4997 => [ 'id' => 4997,  'name' => 'Сковорода чугунная Везувий 9л Ø 455мм',  'code_first' => 4610094701866, 'code_second'  => 4610094701859]
    ];


    public static function getData()
    {

        $result = [];
        $arrCode = [];
        $arrResults = [];

        foreach (self::$pechnik as $item){
            if (!in_array($item['code_first'], $arrCode)) $arrCode[] = $item['code_first'];
            if (!in_array($item['code_second'], $arrCode)) $arrCode[] = $item['code_second'];
        }

        $originArr = Origin::whereIn('code', $arrCode)->select('name', 'code', 'price')->get()->toArray();

        foreach ($originArr as $item){
            $arrResults[$item['code']] = ['name'=>$item['name'], 'price' => $item['price']];
        }

        foreach (self::$pechnik as $item){
            if(array_key_exists($item['code_first'], $arrResults) || array_key_exists($item['code_second'], $arrResults)){
                $result[] =  [
                    'id'=> $item['id'],
                    'name' => $item['name'],
                    'code' =>  strval($item['code_first'].'/'.$item['code_second']),
                    'price' =>  $arrResults[$item['code_first']]['price'] +  $arrResults[$item['code_second']]['price']
                ];
            } else {
                $result[] =  [
                    'id'=> $item['id'],
                    'name' => $item['name'],
                    'code' =>  strval($item['code_first'].'/'.$item['code_second']),
                    'price' =>  null
                ];
            }
        }

        return $result;
    }


}
