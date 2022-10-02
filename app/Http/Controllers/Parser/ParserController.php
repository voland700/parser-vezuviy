<?php

namespace App\Http\Controllers\Parser;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Library\Parser;

use App\Models\Test;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Storage;

use Maatwebsite\Excel\Facades\Excel;
use App\Exports\ProductsExport;


class ParserController extends Controller
{
    public function showCategory()
    {
        return view('parser.category');
    }

    public  function getCategory(Request $request)
    {
        $links = Parser::getCategoryLinks($request->link);
        $products =[];
        $countLinks = 0;
        $countProducts = 0;
        if($links){
            foreach ($links as $link){
                $countLinks++;
                $parser = new Parser;
                $product = $parser->getProduct($link);
                array_push($products,  $product);
                sleep(1);
                set_time_limit(0);
            }
        }

        //собираем масив наимнований опций товаров
        $allOpt = Arr::pluck($products, 'options');
        $NamesProperty = [];
        foreach ($allOpt as $itemOptions){
            foreach ($itemOptions as $arrOne){
                if(!in_array($arrOne['name'], $NamesProperty)){
                    array_push($NamesProperty,  $arrOne['name']);
                }
            }
        }

        $countProducts = count($products);

        $export = new ProductsExport($products, $NamesProperty);
        $fileName = 'upload/export_products_'.time().'.xlsx';
        $export->store($fileName, 'local');

        //return view('parser.excel_table', compact('products', 'NamesProperty' ));

        //return $fileName;
        if($countProducts>0) {
            $massage = 'Всего получено: <b>'.$countProducts.'</b> товара из <b>'.$countLinks.'</b>.   Файл:  <a href="'.'/'.$fileName.'" target="_blank">'.$fileName.'</a>';
            return redirect()->back()->with('success', $massage);
        } else{
            return redirect()->back()->with('error', 'Что то пошло не так, проверти ссылки');
        }
    }

    // Это что? Проверить необходимость функционала!
    public function showProductsToModel()
    {
        return view('parser.to_model');
    }

    // Это что? Проверить необходимость функционала!
    public function getProductsToModel(Request $request)
    {
        $links = Parser::getCategoryLinks($request->link);
        //$products =[];
        if($links){
            foreach ($links as $link){
                $parser = new Parser;
                $product = $parser->getProduct($link);
                if($product->allowed){
                    $data = [];
                    $data['link'] = $product->link;
                    $data['name'] = $product->name;
                    $data['categories'] = $product->categories;
                    $data['category'] = $product->category;
                    $data['artNamber'] = $product->artNamber;
                    $data['image'] = $product->image;

                    if(count($product->more)>0) $data['more'] =  json_encode($product->more,JSON_UNESCAPED_UNICODE);

                    $data['price'] = $product->price;
                    $data['description'] = $product->description;
                    if($product->options) $data['options'] = json_encode($product->options,JSON_UNESCAPED_UNICODE);
                    if($product->documentation) $data['documentation'] = json_encode($product->documentation,JSON_UNESCAPED_UNICODE);
                    if($product->video) $data['video'] = json_encode($product->video,JSON_UNESCAPED_UNICODE);
                    $data ['allowed'] = $product->allowed;
                    Test::create($data);
                    //array_push($products,  $product);
                }
                sleep(1);
                set_time_limit(0);
            }
            return '<h1> OK </h1>';
        }
        return '<h1>Данные не получены!</h1>';
        //dd($products);
    }


    public function showListLinks()
    {
        return view('parser.list_links');
    }

    public function getListLinks(Request $request)
    {
        $links  = $request->links;
        $links = explode("\n", $links);


        $products =[];
        $countLinks = 0;
        $countProducts = 0;
        if($links){
            foreach ($links as $link){
                $countLinks++;
                $parser = new Parser;
                $product = $parser->getProduct(trim($link));
                array_push($products,  $product);
                sleep(1);
                set_time_limit(0);
            }
        }

        //собираем масив наимнований опций товаров
        $allOpt = Arr::pluck($products, 'options');
        $NamesProperty = [];
        foreach ($allOpt as $itemOptions){
            foreach ($itemOptions as $arrOne){
                if(!in_array($arrOne['name'], $NamesProperty)){
                    array_push($NamesProperty,  $arrOne['name']);
                }
            }
        }

        $countProducts = count($products);

        $export = new ProductsExport($products, $NamesProperty);
        $fileName = 'upload/pars_products_'.time().'.xlsx';
        $export->store($fileName, 'local');

        //return view('parser.excel_table', compact('products', 'NamesProperty' ));

        //return $fileName;
        if($countProducts>0) {
            $massage = 'Всего получено: <b>'.$countProducts.'</b> товара из <b>'.$countLinks.'</b>.   Файл:  <a href="'.'/'.$fileName.'" target="_blank">'.$fileName.'</a>';
            return redirect()->back()->with('success', $massage);
        } else{
            return redirect()->back()->with('error', 'Что то пошло не так, проверти ссылки');
        }

    }

    // Это что? Проверить необходимость функционала!
    public function showGoodsOnSource()
    {   $html = Parser::getContent('https://vezuviy.su');

        $document = new \DiDom\Document($html);
        $body = $document->first('body');

        $document->first('script[type=text/javascript]')->remove();
        $document->first('noscript')->remove();


        $element = new \DiDom\Element('script');
        $element->setAttribute('src', env('APP_URL').'/assets/admin/source.js');

        $body->appendChild($element);
        $document->first('body')->replace($body);
         echo $document->html();
    }









}
