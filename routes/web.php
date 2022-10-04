<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/clear', function() {
    Artisan::call('cache:clear');
    Artisan::call('config:cache');
    Artisan::call('view:clear');
    Artisan::call('route:clear');
    return "Кэш очищен.";
})->name('clear.cash');


Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('/test', [App\Http\Controllers\Front\IndexController::class, 'test']);

Route::get('/test2', [App\Http\Controllers\Front\IndexController::class, 'test2']);

Route::get('/test3', [App\Http\Controllers\Front\IndexController::class, 'test3']);



Route::group(['prefix' => 'admin', 'middleware' => ['auth', 'isadmin']], function () {

    Route::get('/', [\App\Http\Controllers\Admin\IndexController::class, 'index'])->name('admin.index');

    Route::get('/category', [\App\Http\Controllers\Parser\ParserController::class, 'showCategory'])->name('show.category');
    Route::post('/category', [App\Http\Controllers\Parser\ParserController::class, 'getCategory'])->name('get.category');

    Route::get('/list-links', [\App\Http\Controllers\Parser\ParserController::class, 'showListLinks'])->name('show.list-links');
    Route::post('/list-links', [App\Http\Controllers\Parser\ParserController::class, 'getListLinks'])->name('get.list-links');

    Route::get('/source', [\App\Http\Controllers\Parser\ParserController::class, 'showGoodsOnSource'])->name('show.source');


    Route::get('/pars-products', [App\Http\Controllers\Parser\ParserController::class, 'showProductsToModel'])->name('show.products');
    Route::post('/pars-products', [App\Http\Controllers\Parser\ParserController::class, 'getProductsToModel'])->name('get.products');

    Route::get('/list-products', [App\Http\Controllers\Parser\ParserController::class, 'listProductsToModel'])->name('list.products');
    Route::get('/list-product/{id?}', [App\Http\Controllers\Parser\ParserController::class, 'getProductToModel'])->name('one.product');

    Route::get('/show-aston', [\App\Http\Controllers\Parser\ParserController::class, 'showAstonProducts'])->name('show.aston');
    Route::post('/get-aston', [App\Http\Controllers\Parser\ParserController::class, 'getAstonProducts'])->name('get.aston');




    Route::resource('/product', \App\Http\Controllers\Product\ProductController::class);
    //загрузка данных о товарах - в табл. products
    Route::get('/import-products', [App\Http\Controllers\Product\ProductController::class, 'showImportProductsExcel'])->name('show.import-products');
    Route::post('/import-products', [App\Http\Controllers\Product\ProductController::class, 'getImportProductsExcel'])->name('get.import-products');


    //загрузка прайс-лита производителя - поставщика

    Route::get('/origin', [App\Http\Controllers\Price\ImportPriceListController::class, 'showImportOrigenPrice'])->name('show.origin');
    Route::post('/origin', [App\Http\Controllers\Price\ImportPriceListController::class, 'getImportOrigenPrice'])->name('get.origin');


    //загрузка прайс-листов магазинов

    Route::get('/temporary', [App\Http\Controllers\Price\ImportPriceListController::class, 'showImportTemporaryPrice'])->name('show.temporary');
    Route::post('/temporary', [App\Http\Controllers\Price\ImportPriceListController::class, 'getImportTemporaryPrice'])->name('get.temporary');

    Route::get('/temp-pechnik', [App\Http\Controllers\Price\ImportPriceListController::class, 'showImportPechnikPrice'])->name('show.tem-pechnik');
    Route::post('/temp-pechnik', [App\Http\Controllers\Price\ImportPriceListController::class, 'getImportPechnikPrice'])->name('get.tem-pechnik');

    Route::get('/temp-legenda', [App\Http\Controllers\Price\ImportPriceListController::class, 'showImportLegendaPrice'])->name('show.temp-legenda');
    Route::post('/temp-legenda', [App\Http\Controllers\Price\ImportPriceListController::class, 'getImportLegendaPrice'])->name('get.temp-legenda');

    Route::get('/temp-tula', [App\Http\Controllers\Price\ImportPriceListController::class, 'showImportTulaPrice'])->name('show.tem-tula');
    Route::post('/temp-tula', [App\Http\Controllers\Price\ImportPriceListController::class, 'getImportTulaPrice'])->name('get.tem-tula');








    Route::get('/research-temp', [App\Http\Controllers\Research\ResearchController::class, 'showResearchTemporaryPrice'])->name('show.temp-research');
    Route::get('/research-pechnik', [App\Http\Controllers\Research\ResearchController::class, 'showResearchPechnikPrice'])->name('show.pechnik-research');
    Route::get('/research-legenda', [App\Http\Controllers\Research\ResearchController::class, 'showResearchLegendaPrice'])->name('show.legenda-research');
    Route::get('/research-tula', [App\Http\Controllers\Research\ResearchController::class, 'showResearchTulaPrice'])->name('show.tula-research');

    Route::get('/research-code', [App\Http\Controllers\Research\ResearchController::class, 'showResearchCode'])->name('show.research-code');
    Route::post('/research-code', [App\Http\Controllers\Research\ResearchController::class, 'getResearchCode'])->name('get.research-code');


    Route::get('/get-research/{name}', [App\Http\Controllers\Research\ResearchController::class, 'getResearchPrice'])->name('get.research');

    Route::get('/pechnik-sum', [App\Http\Controllers\Research\ResearchController::class, 'getPechnikSum'])->name('get.pechnik-sum');


});
