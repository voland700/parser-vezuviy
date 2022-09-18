<?php

namespace App\Http\Controllers\Parser;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Library\Parser;

use App\Models\Test;
use Illuminate\Support\Arr;


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
        if($links){
            foreach ($links as $link){
                $parser = new Parser;
                $product = $parser->getProduct($link);
                array_push($products,  $product);
                sleep(1);
                set_time_limit(0);
            }
        }
        dd($products);
    }

    public function showProductsToModel()
    {
        return view('parser.to_model');
    }

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


    public function getProductToModel($id = null)
    {
        if($id !== null){
            $product = Test::find($id);
        } else {
            $product = Test::first();
        }
        $options = (json_decode($product->options, true));

        dd($product->properties);

        //return view('parser.table');
    }

    public function listProductsToModel()
    {
        $products = Test::get();
        $allOpt = Arr::pluck($products, 'options');
        $NamesProperty = [];
        foreach ($allOpt as $itemOpt){
            $arrAll = json_decode($itemOpt, true);
            foreach ($arrAll as $arrOne){
                if(!in_array($arrOne['name'], $NamesProperty)){
                    array_push($NamesProperty,  $arrOne['name']);
                }
            }
        }
        //dd($NamesProperty);
        return view('parser.table', compact('products', 'NamesProperty' ));
    }







}
