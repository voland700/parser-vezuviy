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






}
