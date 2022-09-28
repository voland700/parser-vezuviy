<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Library\Parser;

use DiDom\Document;
use DiDom\Query;
use GuzzleHttp\Client;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

use Illuminate\Support\Arr;

use Illuminate\Http\File;


use App\Models\Origin;
use App\Models\Temporary;



class IndexController extends Controller
{

    static function getUrl($url){
        $client = new \GuzzleHttp\Client();
        $jar = new \GuzzleHttp\Cookie\CookieJar;
        $res = $client->request('GET', $url, [
            'cookies' => $jar,
            'referer' => true,
            'headers' => [
                'User-Agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/102.0.5005.148 Atom/23.0.0.36 Safari/537.36',
                'Referer' => $url
            ]
        ]);
        if($res->getStatusCode()==200){
            $body = $res->getBody();
            return $body->getContents();
        } else {
            return null;
        }
    }




    public function test()
    {

        $src = 'https://vezuviy.su/gotovim-na-vezuvii-ru/smoker-kudesnik-2/';
        $options = [];
        $video = [];
        $mainImages = '';
        $moreImages = [];

        $document = new Document($src, true);

        $name =  $document->first('.ty-product-block-title bdi')->text();
        $category = $document->first('.ty-breadcrumbs a:last-child')->text();
        $artNamber = $document->first('.ty-control-group__item')->text();
        $price =$document->first('.ty-price bdi span:first-child')->text();
        $price = str_replace("\xC2\xA0", "", $price);

        $description = $document->first('#content_description div')->innerHtml();

        $ArrOptions = $document->find('#content_features .ty-product-feature');

        foreach ($ArrOptions as $itemOption){
            $property = $itemOption->first('.ty-product-feature__label')->text();
            $value = $itemOption->first('.ty-product-feature__value')->text();
            array_push($options,  ['name'=>$property, 'value'=>$value]);
        }
        /*
        $mainImgLink = $document->first('.ty-product-img a')->getAttribute('href');
        if($mainImgLink){

            $contents = file_get_contents($mainImgLink);
            $ext = pathinfo($mainImgLink, PATHINFO_EXTENSION);
            if($artNamber) {
                $fileName = 'main_'.$artNamber.'.'.$ext;
            } else {
                $fileName = 'main_'.Str::lower(Str::random(7)).'.'.$ext;
            }
           if(Storage::disk('public')->put('upload/main/' . $fileName, $contents)) $mainImages = '/main/' . $fileName;
        }
        */

        if(count($document->find('.ty-product-img a.cm-image-previewer')) > 1){
            $arrMore = $document->find('.ty-product-img a.cm-image-previewer');

            foreach($arrMore as $key=> $moreItem){
                if($key == 0) continue;
                $moreItemLink  = $moreItem->getAttribute('href');

                $contents = file_get_contents($moreItemLink);
                $ext = pathinfo($moreItemLink, PATHINFO_EXTENSION);
                if($artNamber) {
                    $fileMoreName = $key.'_more_'.$artNamber.'.'.$ext;
                } else {
                    $fileMoreName =  $key.'_more_'.Str::lower(Str::random(7)).'.'.$ext;
                }
                if(Storage::disk('public')->put('upload/more/' . $fileMoreName, $contents)) array_push($moreImages,  '/more/' . $fileMoreName);
            }
        }
        dd($moreImages);
    }



    public function test2()
    {

        dd((int)'4680046790545/4680046790521');




    }

    public function test3(){


        $pechnik = [
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

        $result = [];
        $arrCode = [];
        $arrResults = [];

        foreach ($pechnik as $item){
            if (!in_array($item['code_first'], $arrCode)) $arrCode[] = $item['code_first'];
            if (!in_array($item['code_second'], $arrCode)) $arrCode[] = $item['code_second'];
        }

        $originArr = Origin::whereIn('code', $arrCode)->select('name', 'code', 'price')->get()->toArray();

        foreach ($originArr as $item){
            $arrResults[$item['code']] = ['name'=>$item['name'], 'price' => $item['price']];
        }

         foreach ($pechnik as $item){
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



        dd($result);









    }






}
