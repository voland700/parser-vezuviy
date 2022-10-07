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

    static $tula = [
        7773 => ['id' => 7773, 'name' => 'Казан 12 л. с крышкой', 'code_first' => 4680019120010, 'code_second'  => 4680019120034],
        7771 => ['id' => 7771, 'name' => 'Казан 12 л. с ручкой', 'code_first' => 4680019125046, 'code_second'  => 4680019120034],
        7767 => ['id' => 7767, 'name' => 'Казан 6 л. с крышкой', 'code_first' => 4680019129358, 'code_second'  => 4680019129273],
        7770 => ['id' => 7770, 'name' => 'Казан 6 л. с ручкой', 'code_first' => 4680019129334, 'code_second'  => 4680019129273],
        7768 => ['id' => 7768, 'name' => 'Казан 8 л. с крышкой', 'code_first' => 4680019120027, 'code_second'  => 4680019120041],
        7769 => ['id' => 7769, 'name' => 'Казан 8 л. с ручкой', 'code_first' => 4680019125053, 'code_second'  => 4680019120041],
        7766 => ['id' => 7766, 'name' => 'Казан Сербский 14 л. с крышкой', 'code_first' => 4610094703198, 'code_second'  => 4610094703204],
        7729 => ['id' => 7729, 'name' => 'Сковорода чугунная  Везувий 9 л. Ø 455мм', 'code_first' => 4610094701866, 'code_second'  => 4610094701859],
        7649 => ['id' => 7649, 'name' => 'Сковорода чугунная Везувий 6л Ø 380мм', 'code_first' => 4680046790545, 'code_second'  => 4680046790521],
        7088 => ['id' => 7088, 'name' => 'Русичъ «АКВА» 16 (ДТ-4) с баком 32л', 'code_first' => 4680046791962, 'code_second'  => 4680046791924],
        7089 => ['id' => 7089, 'name' => 'Русичъ «АКВА» 16 (ДТ-4) с баком 49л', 'code_first' => 4680046791962, 'code_second'  => 4680046791948],
        7090 => ['id' => 7090, 'name' => 'Русичъ «АКВА» 22 (ДТ-4) с баком 40л', 'code_first' => 4680046791979, 'code_second'  => 4680046791931],
        7091 => ['id' => 7091, 'name' => 'Русичъ «АКВА» 22 (ДТ-4) с баком 61л', 'code_first' => 4680046791979, 'code_second'  => 4680046791955],
        7086 => ['id' => 7086, 'name' => 'Сенсация «АКВА» 16 (ДТ-4)  с баком 30л', 'code_first' => 4680046792006, 'code_second'  => 4680046791986],
        7087 => ['id' => 7087, 'name' => 'Сенсация «АКВА» 22 (ДТ-4) с баком 40л', 'code_first' => 4680046792013, 'code_second'  => 4680046791993]
    ];

    static $legenda = [
        22 => ['id' => 22, 'name' => 'Казан чугунный Везувий 6 л', 'code_first' => 4680019129358, 'code_second'  => 4680019129273],
        23 => ['id' => 23, 'name' => 'Казан чугунный Везувий 6 л с ручкой', 'code_first' => 4680019129334, 'code_second'  => 4680019129273],
        24 => ['id' => 24, 'name' => 'Казан чугунный Везувий 8 л', 'code_first' => 4680019120027, 'code_second'  => 4680019120041],
        25 => ['id' => 25, 'name' => 'Казан чугунный Везувий 8 л с ручкой', 'code_first' => 4680019125053, 'code_second'  => 4680019120041],
        26 => ['id' => 26, 'name' => 'Казан чугунный Везувий 12 л', 'code_first' => 4680019120010, 'code_second'  => 4680019120034],
        27 => ['id' => 27, 'name' => 'Казан чугунный Везувий 12 л с ручкой', 'code_first' => 4680019125046, 'code_second'  => 4680019120034],
        28 => ['id' => 28, 'name' => 'Сербский казан 14 л', 'code_first' => 4610094703198, 'code_second'  => 4610094703204],
        30 => ['id' => 30, 'name' => 'Сковорода чугунная Везувий 6л Ø 380мм', 'code_first' => 4680046790545, 'code_second'  => 4680046790521],
        31 => ['id' => 31, 'name' => 'Сковорода чугунная Везувий 9 л Ø 455 мм', 'code_first' => 4610094701866, 'code_second'  => 4610094701859],
    ];



    private static function getData($shopName)
    {

        $result = [];
        $arrCode = [];
        $arrResults = [];

        foreach ($shopName as $item){
            if (!in_array($item['code_first'], $arrCode)) $arrCode[] = $item['code_first'];
            if (!in_array($item['code_second'], $arrCode)) $arrCode[] = $item['code_second'];
        }

        $originArr = Origin::whereIn('code', $arrCode)->select('name', 'code', 'price')->get()->toArray();

        foreach ($originArr as $item){
            $arrResults[$item['code']] = ['name'=>$item['name'], 'price' => $item['price']];
        }

        foreach ($shopName as $item){
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


    public static function pechnik()
    {
        return self::getData(self::$pechnik);
    }

    public static function tula()
    {
        return self::getData(self::$tula);
    }

    public static function legenda()
    {
        return self::getData(self::$legenda);
    }




}
