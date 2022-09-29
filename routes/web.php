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


    Route::get('/products', [App\Http\Controllers\Parser\ParserController::class, 'showProductsToModel'])->name('show.products');
    Route::post('/products', [App\Http\Controllers\Parser\ParserController::class, 'getProductsToModel'])->name('get.products');


    Route::get('/list-products', [App\Http\Controllers\Parser\ParserController::class, 'listProductsToModel'])->name('list.products');
    Route::get('/list-product/{id?}', [App\Http\Controllers\Parser\ParserController::class, 'getProductToModel'])->name('one.product');



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








    Route::get('/research', [App\Http\Controllers\Price\ImportPriceListController::class, 'showResearchPrice'])->name('show.research');
    Route::get('/research-get', [App\Http\Controllers\Price\ImportPriceListController::class, 'getResearchPrice'])->name('get.research');

    Route::get('/pechnik-sum', [App\Http\Controllers\Price\ImportPriceListController::class, 'getPechnikSum'])->name('get.pechnik-sum');


});
