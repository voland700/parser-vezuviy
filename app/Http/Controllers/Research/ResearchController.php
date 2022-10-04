<?php

namespace App\Http\Controllers\Research;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


use App\Models\Origin;
use App\Models\Temporary;
use App\Models\Pechnik;
use App\Models\Legenda;
use App\Models\Tula;


use App\Library\GetInfo;



class ResearchController extends Controller
{
    public function showResearchTemporaryPrice()
    {
        $store = GetInfo::info(DB::table('temporaries'));
        $origin = GetInfo::info(DB::table('origins'));
        $name = 'temporaries';
        return view('price.research', compact('store', 'origin', 'name'));
    }

    public function showResearchPechnikPrice()
    {
        $store = GetInfo::info(DB::table('pechniks'));
        $origin = GetInfo::info(DB::table('origins'));
        $name = 'pechniks';
        return view('price.research', compact('store', 'origin', 'name'));
    }

    public function showResearchLegendaPrice()
    {
        $store = GetInfo::info(DB::table('legendas'));
        $origin = GetInfo::info(DB::table('origins'));
        $name = 'legendas';
        return view('price.research', compact('store', 'origin', 'name'));
    }

    public function showResearchTulaPrice()
    {
        $store = GetInfo::info(DB::table('tulas'));
        $origin = GetInfo::info(DB::table('origins'));
        $name = 'tulas';
        return view('price.research', compact('store', 'origin', 'name'));
    }

    public function getResearchPrice($name)
    {

        if($name == 'temporaries') $shop = Temporary::select('product_id', 'active', 'name', 'code', 'price')->get();
        if($name == 'pechniks') $shop = Pechnik::select('product_id', 'active', 'name', 'code', 'price')->get();
        if($name == 'legendas') $shop = Legenda::select('product_id', 'active', 'name', 'code', 'price')->get();
        if($name == 'tulas') $shop = Tula::select('product_id', 'active', 'name', 'code', 'price')->get();

        $data = new \App\Library\ResearchData();
        $data =  $data->getData($shop);
        return (new \App\Exports\ResearchDataAllExport($data))->download('data_'.$name.'.xlsx');
    }

    public function getPechnikSum()
    {
        $data = \App\Library\getSumProducts::getData();
        return (new \App\Exports\GetSumProductsExport($data))->download('pechnik_sum.xlsx');
    }

    public function showResearchCode()
    {
        return view('parser.list_code');
    }
    public function getResearchCode(Request $request)
    {
        $listCount = 0;
        $productsCount = 0;
        $goods = [];
        $list  = $request->list;
        $list = explode("\n", $list);
        foreach ($list as  $key => $row) {
            $list[$key] = (int)trim($row);
        }

        $products = DB::table('products')->whereIn('code', $list)->get();

        $listCount = count($list);
        $productsCount = $products->count();

        foreach ($list as $k => $one){
            $item = $products->where('code', $one)->first();
            if($item){
                $goods[$k]['code'] = $one;
                $goods[$k]['name'] = $item->name;
                $goods[$k]['number'] = $item->number;
                $goods[$k]['price'] = $item->price;
                $goods[$k]['link'] = $item->link;
            }else{
                $goods[$k]['code'] = $one;
                $goods[$k]['name'] = null;
                $goods[$k]['number'] = null;
                $goods[$k]['price'] = null;
                $goods[$k]['link'] = null;
            }
        }



       $fileName = 'products_code_'.time();
       return (new \App\Exports\ResearchDataCodeProducts($goods))->download($fileName.'.xlsx');

        if(count($listCount)>0 && count($productsCount)>0 ) {
            $massage = 'Найдено: <b>'.$productsCount.'</b> товара из <b>'.$listCount.'</b> зарашиваемых.';
            return redirect()->back()->with('success', $massage);
        } else{
            $massage = '<b>'.$productsCount.'</b> товаров из <b>'.$listCount.'</b>.';
            return redirect()->back()->with('error', $massage);
        }

    }







}
