<?php

namespace App\Http\Controllers\Price;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ImportPriceListController extends Controller
{
     public function showImportOrigenPrice()
     {

         $count = DB::table('origins')->count();
         $date = null;
         if($count > 0){
             $date = Origin::first();
             $date = Carbon::parse($date)->translatedFormat('j F Y');
         }

         return view('price.origin_import', compact('count', 'date'));

     }
}
