<?php

namespace App\Http\Controllers\Parser;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Library\Parser;



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




}
