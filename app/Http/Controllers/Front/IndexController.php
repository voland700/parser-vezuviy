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
use Illuminate\Http\File;



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
        //$url = 'https://vezuviy.su/gotovim-na-vezuvii-ru/fantastic-grill-legenda/';
        $url = 'https://vezuviy.su/gotovim-na-vezuvii-ru/kostrovye-chashi/';
        $links = Parser::getCategoryLinks($url);
        dd($links);
    }





}
