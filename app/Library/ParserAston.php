<?php


namespace App\Library;

use App\Library\Parser;
use App\Models\Product;
use DiDom\Document;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\ProductsExport;

use Maatwebsite\Excel\Concerns\Exportable;

class ParserAston
{

    public static $products = [];

    public static function getAstonProducts($src){
        $html = Parser::getContent($src);
        if(!$html) return self::$products;
        $document = new Document($html);
        $items = $document->find('.item');
        if (!count($items) > 0) return self::$products;
        $categoriy = $document->first('title')->text();

        foreach ($items as $item){

            $ArrOptions = [];
            $video = null;
            $mainImg = null;
            $moreImages = [];
            $options = [];
            $optionsJSON = [];

            $name = $item->first('.models_info > span')->text();
            $price = (int)preg_replace('/\s+/', '', $item->first('.models_info > p')->text());
            $description = $item->first('.models_description')->innerHtml();



            $description = str_replace('&#13;', '', $description);


            $ArrOptions =  $item->find('.models_table tr');
            if(count($ArrOptions)>0){
                $key = 1;
                foreach ($ArrOptions as $option){
                    $property = $option->find('td')[0]->text();
                    $value    = $option->find('td')[1]->text();
                    $optionsJSON[$key] = ['name'=>$property, 'value'=>$value];
                    $key++;
                    array_push($options,  ['name'=>$property, 'value'=>$value]);
                }
            }
            $videoUrl = $item->first('.models_video');
            if ($videoUrl) {
                $videoUrl->getAttribute('href');
                $parts = parse_url($videoUrl);
                parse_str($parts['query'], $query);
                $video =  $query['v'];
            }

            $mainImgLink = $item->first('.models_image')->getAttribute('href');
            if($mainImgLink) {
                $mainImgLink = 'https://aston-pech.ru/'.$mainImgLink;
                if (preg_match("|\s|", $mainImgLink) ){
                    $mainImgLink = str_replace(' ', '%20', $mainImgLink);
                }
                $contents = file_get_contents($mainImgLink);
                $ext = pathinfo($mainImgLink, PATHINFO_EXTENSION);
                $fileName = 'aston_main_'.Str::lower(Str::random(5)).'.'.$ext;
                if(Storage::disk('public')->put('upload/main/' . $fileName, $contents)) $mainImg = $fileName;
            }
            $moreImagesArr = $item->find('.models_gallery a');
            if (count($moreImagesArr) > 0) {
                $part_name = Str::lower(Str::random(5));
                $key = 1;
                foreach ($moreImagesArr as $moreImgItem){
                    $moreImgLink = $moreImgItem->getAttribute('href');
                    $moreImgLink = 'https://aston-pech.ru/'.$moreImgLink;
                    if (preg_match("|\s|", $moreImgLink) ){
                        $moreImgLink = str_replace(' ', '%20', $moreImgLink);
                    }
                    $contents = file_get_contents($moreImgLink);
                    $ext = pathinfo($moreImgLink, PATHINFO_EXTENSION);
                    $fileName = 'aston_more_'.$key.'_'.$part_name.'.'.$ext;
                    if(Storage::disk('public')->put('upload/more/' . $fileName, $contents))  $moreImg = '/more/' . $fileName;
                    array_push($moreImages,  $moreImg);
                    $key++;
                }
            }

            self::$products[] = [
                'link' => $src,
                'name' => $name,
                'category' => $categoriy,
                'artNamber' => null,
                'image' => $mainImg,
                'more' => $moreImages,
                'price' => $price,
                'description' => $description,
                'options' => $options,
                'json' =>  count($optionsJSON)>0 ? json_encode($optionsJSON, JSON_UNESCAPED_UNICODE) : null,
                'video' => $video
            ];
        }

        return self::$products;
    }

}
