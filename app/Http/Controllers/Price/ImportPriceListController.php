<?php

namespace App\Http\Controllers\Price;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\FileRequest;
use Illuminate\Support\Facades\DB;

use App\Imports\OriginalImport;
use App\Imports\TemporaryImport;

use App\Models\Origin;
use App\Models\Temporary;

use Carbon\Carbon;

class ImportPriceListController extends Controller
{
     public function showImportOrigenPrice()
     {
         $count = DB::table('origins')->count();
         $date = null;
         if($count > 0){
             $one = DB::table('origins')->select('created_at')->first();
             $date = Carbon::parse($one->created_at)->translatedFormat('j F Y');
         }
         return view('price.origin_import', compact('count', 'date'));
     }

     public function getImportOrigenPrice(FileRequest $request)
     {
         $file = $request->file('file')->store('import');
         Origin::truncate();
         $import = new OriginalImport;
         $import->import($file);
         if($import->count > 0) {
             return back()->withStatus('Данные загружены, успешно обработано и загружено '. $import->count .' строк.');
         }  else {
             return back()->withFailures('Новые данные не загружены.');
         }
     }


     public function showImportTemporaryPrice()
     {
         $count = DB::table('temporaries')->count();
         $date = null;
         if($count > 0){
             $one = DB::table('temporaries')->select('created_at')->first();
             $date = Carbon::parse($one->created_at)->translatedFormat('j F Y');
         }
         return view('price.temporary_import', compact('count', 'date'));
     }

    public function getImportTemporaryPrice(FileRequest $request)
    {
        $file = $request->file('file')->store('import');
        Temporary::truncate();
        $import = new TemporaryImport;
        $import->import($file);
        if($import->count > 0) {
            return back()->withStatus('Данные загружены, успешно обработано и загружено '. $import->count .' строк.');
        }  else {
            return back()->withFailures('Новые данные не загружены.');
        }
    }


    public function showResearchPrice()
    {
        $store['count'] = DB::table('temporaries')->count();
        $store['date'] = null;
        if($store['count'] > 0) {
            $store['date'] = Carbon::parse(DB::table('temporaries')->select('created_at')->first()->created_at)->translatedFormat('j F Y');
        }

        $origin['count'] = DB::table('origins')->count();
        $origin['date'] = null;
        if($origin['count'] > 0) {
            $origin['date'] = Carbon::parse(DB::table('origins')->select('created_at')->first()->created_at)->translatedFormat('j F Y');
        }
        return view('price.research', compact('store', 'origin'));
    }

    public function getResearchPrice()
    {
        $data =  \App\Library\ResearchData::getData();
        return (new \App\Exports\ResearchDataAllExport($data))->download('data.xlsx');
    }

    public function getPechnikSum()
    {
        $data = \App\Library\getSumProducts::getData();
        return (new \App\Exports\GetSumProductsExport($data))->download('pechnik_sum.xlsx');

    }







}
