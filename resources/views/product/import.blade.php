@extends('adminlte::page')

@section('title', 'Загрузка данных о товарах Везувий')

@section('content_header')
    <h1>Импорт товаров Везувий</h1>
@stop

@section('content')
    @if ($message = Session::get('success'))
        <div class="alert alert-success alert-dismissible">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
            <p>{{ $message }}</p>
        </div>
    @endif


    <x-adminlte-card title="Загрузка данных из Excel" class="col-12" collapsible removable maximizable>
        <div class="col-lg-9">
           <div class="mb-5">
           <h5>Поля загружемеого прайс-листа</h5>
                <ul>
                    <li><b>name</b> -  Название товара</li>
                    <li><b>number</b> -  Код товра  - указанный на сайтах Везувий</li>
                    <li><b>code</b> - Штрих-код - Уникальный код товара </li>
                    <li><b>price</b> - Цена товара в каталоге интернет-магазина</li>
                    <li><b>link</b> - Ссылка на товар на сайтах Везувий</li>
                </ul>
            </div>
           <div class="mb-5">
                <form action="{{route('get.import-products')}}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="file">Загрузиить файл</label>
                                <div class="input-group">
                                    <div class="custom-file">
                                        <input type="file" class="custom-file-input" id="file" name="file" value="{{old('file')}}">
                                        <label class="custom-file-label" for="exampleInputFile">Choose file</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 d-flex">
                            <button type="submit" class="btn btn-primary align-self-end mb-3">Загрузить</button>
                        </div>
                    </div>
                </form>
           </div>
        </div>
    </x-adminlte-card>

@stop

@section('css')
    <link rel="stylesheet" href="/assets/admin/css/admin_custom.css">
@stop

@section('js')
    <script>
        document.querySelectorAll('.custom-file-input').forEach(function (item) {
            item.addEventListener('change',function(e){
                let fileName = e.target.files[0].name;
                let nextSibling = e.target.nextElementSibling
                nextSibling.innerText = fileName
            })
        })
    </script>
@stop
