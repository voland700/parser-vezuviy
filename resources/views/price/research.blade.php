@extends('adminlte::page')

@section('title', 'Парсинг категрой товаров')

@section('content_header')
    <h1>Анализ данных прайс-листов</h1>
@stop

@section('content')



    <x-adminlte-card title="Анализ, сопоставления цен" class="col-12" collapsible removable maximizable>
        <div class="col-lg-9">
            <div class="callout callout-info mb-5">
                <h5 class="{{ $store['count'] > 0 ? 'text-dark' : 'text-danger' }}">{{ $store['count'] > 0 ? 'В базе данных магазина содержаться записи' : 'База данных магазина не содержит записей' }}</h5>
                @if($store['count'] > 0)
                    <p>В таблице базы данных магазина содержится <span class="text-success font-weight-bold">{{$store['count']}}</span> записи от <span class="text-success font-italic">{{ $store['date'] }}</span>.</p>
                @endif

                <h5 class="{{ $origin['count'] > 0 ?'text-dark' : 'text-danger' }}">{{ $origin['count'] > 0 ? 'В базе данных товаров Везувий содержаться записи' : 'База данных товаров Везувий не содержит записей' }}</h5>
                @if($origin['count'] > 0)
                    <p>В таблице базы данных магазина содержится <span class="text-success font-weight-bold">{{$origin['count']}}</span> записи от <span class="text-success font-italic">{{ $origin['date'] }}</span>.</p>
                @endif
            </div>

            <div class="mb-5">
                <p>Для изучения данных, анализа и сопоставления стоимости товаров в магазине и прайс листа  производителя Везувий, необходимо предварительно загрузить данные!</p>
                <p>Порядок, последовательность проведения анализа цен:</p>
                <ol>
                    <li>Загрузить актуальный прайс лист производителя Везувий</li>
                    <li>Загрузить данные товаров Везувий содержащиеся в магазине</li>
                    <li>Произвести анализ, сопоставления цен товаров, получить актуальны данные для последующий загрузки в магазин</li>
                </ol>
                <p>В результате проведенного анализа, будет получен Excel – файл, листы которого содержат данные: </p>
                <ul>
                    <li><strong>found</strong> - id товара, статус активности, наименование товара, код, старой и новой ценах, а так же информация об изменении цены .</li>
                    <li><strong>luck</strong> – информация о товарах содержащихся в магазине, но отсутствующих в прайс-листе производителя Везувий.</li>
                    <li><strong>empty</strong> - информация о товарах содержащихся в магазине, в который отсутствует поле code – для поиска и сопоставления цен с прайс-листом производителя.</li>
                    <li><strong>absence</strong> - информация о товарах содержащихся в прайс-листе производителя Везувий, но отсутствующих  в магазине.</li>
                </ul>
            </div>

            <div class="mb-5">
            @if($store['count'] || $origin['count'])
                <a class="btn btn-primary" href="{{route('get.research')}}" role="button">Анализ</a>
            @else
                @php
                    $massage = '';
                    if($store['count'] == 0 || $origin['count'] > 0) $massage = 'база данных магазина не содержит записей';
                    if($store['count'] > 0 || $origin['count']  == 0) $massage = 'база данных производителя Везувий не содержит записей';
                    if($store['count'] == 0 || $origin['count']  == 0) $massage = 'базы данных магазина и производителя Везувий не содержат записей';
                @endphp
                <p class="text-danger">Анилиз не доступен, так как {{$massage}}</p>
            @endif
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
