<?php

namespace App\Http\Controllers\Product;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\FileRequest;

use App\Models\Product;

use App\Imports\ProductImport;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $products = Product::select('id', 'name', 'number', 'code', 'price', 'link')->get();
        return view('product.index', compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('product.store');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $messages = [
            'name.required' => 'Укажите название товара',
            'code.integer' => 'Штрих-код товара должен иметь числовое значение',
            'number.unique' => 'Товар с указанным номром уже присутсвует в базе данных',
            'code.unique' => 'Товар с указанным штрих-кодом уже присутсвует в базе данных'
        ];
        $this->validate($request, [
            'name' => 'required',
            'code' => 'integer|nullable|unique:products',
            'number' => 'nullable|unique:products',
        ],$messages);

        $product = new Product($request->all());
        $product->save();
        return redirect()->route('product.index')->with('success', 'Данные успешно добавлены');

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $product = Product::find($id);
        return view('product.show', compact('product'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $product = Product::find($id);
        return view('product.update', compact('product'));

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $product = Product::find($id);

        //dd($request->all());
        $messages = [
            'name.required' => 'Укажите название товара',
            'code.integer' => 'Штрих-код товара должен иметь числовое значение',
            'number.unique' => 'Товар с указанным номром уже присутсвует в базе данных',
            'code.unique' => 'Товар с указанным штрих-кодом уже присутсвует в базе данных'
        ];
        $this->validate($request, [
            'name' => 'required',
            'code' => 'integer|nullable|unique:products,code,'. $product->id,
            'number' => 'nullable|unique:products,number,'. $product->id
        ],$messages);
        $product->update($request->all());
        return redirect()->route('product.index')->with('success', 'Данные товара обновлены');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $product = Product::find($id);
        $product->delete();
        return redirect()->route('product.index')->with('success', 'Данные товара удалены');
    }


    public function showImportProductsExcel()
    {
        return view('product.import');
    }

    public function getImportProductsExcel(FileRequest $request)
    {
        $file = $request->file('file')->store('import');
        $import = new ProductImport;
        $import->import($file);
        if($import->count > 0) {
            return back()->withStatus('Данные загружены, успешно обработано и загружено '. $import->count .' строк.');
        }  else {
            return back()->withFailures('Новые данные не загружены.');
        }
    }

}
