@extends('adminlte::page')

@section('title', 'Просмотр данных товара: '.$product->name)

@section('content_header')
    <h1>Товар Везувий: {{$product->name}}</h1>
@stop

@section('content')

    <x-adminlte-card title="Данные товара товвара" class="col-lg-9" collapsible removable maximizable>
        @if($product->name)<h5>{{$product->name}}</h5> @endif
        <table class="table table-bordered mb-3">
            <thead>
            <tr>
                <th style="width: 10px">№</th>
                <th style="width: 150px">Название</th>
                <th>Значение</th>
            </tr>
            </thead>
            <tbody>
            <tr>
                <td>1.</td>
                <td>Ссылка: </td>
                <td> @if($product->link) <a href="{{$product->link}}" target="_blank">{{$product->link}}</a> @endif </td>
            </tr>
            <tr>
                <td>2.</td>
                <td>Код товара:</td>
                <td> {{$product->number}} </td>
            </tr>
            <tr>
                <td>3.</td>
                <td>Штрих-Код</td>
                <td>{{$product->code}} </td>
            </tr>
            <tr>
                <td>4.</td>
                <td>Цена:</td>
                <td>{{$product->number}}</td>
            </tr>
            </tbody>
        </table>
        <a href="{{route('product.index')}}" class="btn btn-outline-secondary mb-3" role="button" aria-disabled="true">Назад</a>

    </x-adminlte-card>
@stop

@section('css')
    <link rel="stylesheet" href="/assets/admin/css/admin_custom.css">
@stop

@section('js')

@stop
