@extends('adminlte::page')

@section('title', 'Парсинг категрой товаров')

@section('content_header')
    <h1>Загрузка данных магазина</h1>
@stop

@section('content')
    @if ($message = Session::get('success'))
        <div class="alert alert-success alert-dismissible">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
            <p>{{ $message }}</p>
        </div>
    @endif


    <x-adminlte-card title="Загрузка: прайс-лист магазина" class="col-12" collapsible removable maximizable>
        <div class="col-lg-6">
            <div class="callout callout-info">
                <h5>{{ $count > 0 ? 'В базе данных содержаться записи' : 'База данных не содержит записей' }}</h5>

                @if($count > 0)
                    <p>В таблице базы данных содержится <span class="text-success font-weight-bold">{{$count}}</span> записи от <span class="text-success font-italic">{{ $date }}</span>.</p>
                @endif
            </div>

            <p>Загрзка данных о товарах Везувий - из прайс-листа магазина, для последующего сравнения.</p>
            <p>При загрузке прайс листа - текущие записи содержащиеся в таблице базы данных удаляются.Таблица очищается, загружаются только данные,
                содержащиеся в загружаемом прайс-листе.</p>
            <p>Сравнение цен с орегинальным, предварительно загруженным прайс-листом производителя Везувий, происходит по полю <b>code</b> в котором содержится штрих-код - уникальный код товара </p>


            <h5>Поля загружемеого прайс-листа</h5>
            <ul>
                <li><b>product_id</b> -  ID товара в каталоге интернет-магазина</li>
                <li><b>active</b> - Статус активности товара в каталоге интернет-магазина (не обязательно)</li>
                <li><b>name</b> -  Название товара</li>
                <li><b>code</b> - Штрих-код - Уникальный код товара </li>
                <li><b>price</b> - Цена товара в каталоге интернет-магазина</li>
            </ul>
            <form action="{{route('get.temporary')}}" method="post" enctype="multipart/form-data">
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
