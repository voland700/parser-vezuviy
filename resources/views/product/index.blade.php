@extends('adminlte::page')

@section('title', 'Список товаров производителя Везувий')

@section('content_header')
    <h1>Список товаров Везувий</h1>
@stop

@section('content')
    @if ($message = Session::get('success'))
        <div class="alert alert-success alert-dismissible">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
            <p>{{ $message }}</p>
        </div>
    @endif


    <a href="{{route('product.create')}}" type="button" class="btn btn-primary mb-3">Добавить</a>
    <x-adminlte-card title="Список товаров" class="col-12" collapsible removable maximizable>
        @php
            $heads = [
                ['label' => 'ID', 'width' => 2],
                'Name',
                ['label' => 'Артикул', 'width' => 10],
                ['label' => 'Код', 'width' => 10],
                ['label' => 'Actions', 'no-export' => true, 'width' => 8],
            ];
            $config = [
                'order' => [[1, 'asc']],
                'columns' => [null, null, ['orderable' => false], ['orderable' => false], ['orderable' => false]],
            ];
        @endphp
        <x-adminlte-datatable id="table1" :heads="$heads">
            @foreach($products as $product)
                <tr>
                    <td>{{$product->id}}</td>
                    <td> @if($product->link)
                            <a href="{{$product->link}}" target="_blank">{{$product->name}}</a>
                        @else
                            {{$product->name}}}
                        @endif
                    </td>
                    <td>{{$product->number}}</td>
                    <td>{{$product->code}}</td>
                    <td>
                        <a href="{{ route('product.edit', $product->id) }}" class="btn btn-xs btn-info mx-1 shadow"><i class="fa fa-lg fa-fw fa-pen"></i></a>
                        <form method="POST" action="{{ route('product.destroy', $product->id) }}" class="formDelete">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-xs btn-danger mx-1 shadow delete" onclick="return confirm('Подтвердите удаление')"><i class="fa fa-lg fa-fw fa-trash"></i></button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </x-adminlte-datatable>

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
