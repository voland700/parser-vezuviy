@extends('adminlte::page')

@section('title', 'Парсинг категрой товаров')

@section('content_header')
    <h1>Анализ данных прайс-листов</h1>
@stop

@section('content')
    @php
        $info = '';
        if($name == 'temporaries') $info = 'в таблице Временная';
        elseif($name == 'pechniks') $info = 'магазина Pechnik.Su';
        elseif($name == 'legendas') $info = 'магазина Vezuviy-Legenda.Ru';
        elseif($name == 'tulas') $info = 'магазина Pechi-Tula.Ru';
    @endphp


    <x-adminlte-card title="Анализ, сопоставления цен" class="col-12" collapsible removable maximizable>
        <div class="col-lg-9">
            <div class="callout callout-info mb-5">
                <h5 class="{{ $store['count'] > 0 ? 'text-dark' : 'text-danger' }}">{{ $store['count'] > 0 ? 'В базе данных '. $info.' содержаться записи' : 'База данных '. $info.' не содержит записей' }}</h5>
                @if($store['count'] > 0)
                    <p>Всего:  <span class="text-success font-weight-bold">{{$store['count']}}</span> записей от <span class="text-success font-italic">{{ $store['date'] }}</span>.</p>
                @endif

                <h5 class="{{ $origin['count'] > 0 ?'text-dark' : 'text-danger' }}">{{ $origin['count'] > 0 ? 'Орегинальный прайс-лист производителя загружен' : 'Праслист произодителя не загружен, в базе данных отсутствуют записи о товарах' }}</h5>
                @if($origin['count'] > 0)
                    <p>Всего:  <span class="text-success font-weight-bold">{{$origin['count']}}</span> записи от <span class="text-success font-italic">{{ $origin['date'] }}</span>.</p>
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
                <p>Так, же при наличии данных, вы можете получить данные о ценах комплектов товаров Везувий, <i>(сковорода + крышка, банная печь + бак, и т.д.)</i>.</p>
            </div>
            <div class="mb-5">
            @if($store['count'] && $origin['count'])
                <a class="btn btn-primary" href="{{route('get.research', $name)}}" role="button">Анализ цен</a>
                @if($name == 'pechniks')
                        <a class="btn btn-primary" href="{{route('get.pechnik-sum')}}" role="button">Данные комплектов</a>
                @elseif($name == 'legendas')
                        <a class="btn btn-primary" href="{{route('get.tula-sum')}}" role="button">Данные комплектов</a>
                @elseif($name == 'tulas')
                        <a class="btn btn-primary" href="{{route('get.legenda-sum')}}" role="button">Данные комплектов</a>
                @endif

            @else
                @php
                    $massage = '';
                    if($store['count'] == 0 && $origin['count'] > 0) $massage = 'база данных '.$info.' не содержит записей';
                    if($store['count'] > 0 && $origin['count']  == 0) $massage = 'база данных производителя Везувий не содержит записей';
                    if($store['count'] == 0 && $origin['count']  == 0) $massage = 'базы данных '.$info.' и производителя Везувий не содержат записей';
                @endphp
                <p class="text-danger">Анилиз не доступен, так как {{$massage}}.</p>
            @endif
            </div>
        </div>

    </x-adminlte-card>

@stop

@section('css')
    <link rel="stylesheet" href="/assets/admin/css/admin_custom.css">
@stop

@section('js')

@stop
