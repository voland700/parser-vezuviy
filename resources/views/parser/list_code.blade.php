@extends('adminlte::page')

@section('title', 'Поиск, анализ данных по товарам Везувий')

@section('content_header')
    <h1>Поиск, анализ данных по товарам Везувий</h1>
@stop

@section('content')
    @if(session()->has('success'))
        <div id="showAllert">
            <div class="alert alert-success alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                <h5><i class="icon fas fa-check"></i> Данные получены!</h5>
                {!! session()->get('success') !!}
            </div>
        </div>
    @endif


    @if(session()->has('error'))
        <div class="alert alert-danger alert-dismissible">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
            <h5><i class="icon fas fa-ban"></i> Данные не получены!</h5>
            {{ session()->get('error') }}
        </div>
    @endif



    <x-adminlte-card title="Ссылки для парсинга" class="col-12" collapsible removable maximizable>
        <div class="col-lg-6">
            <p>Для парсинга необходимо по строчно указать данные штрих-кодов товаров Везувий.</p>
            <p>Поиск данных производится по таблице <i>"products"</i> одержаться преварительно загруженные данные товаров с сайтов Везувий, с сылками на страницы товаров.</p>
            <form role="form" method="post" action="{{ route('get.research-code') }}">
                @csrf
                <div class="form-group">
                    <label for="list">Список кодов товара</label>
                    <textarea name="list" class="form-control" id="list" rows="10" required placeholder="4680019129181..."></textarea>
                </div>
                <div class="card-footer">
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
            </form>
        </div>
    </x-adminlte-card>
@stop

@section('css')
    <link rel="stylesheet" href="/assets/admin/css/admin_custom.css">
@stop

@section('js')
    <script> console.log('Hi!'); </script>
@stop
