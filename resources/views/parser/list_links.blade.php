@extends('adminlte::page')

@section('title', 'Парсинг категрой товаров')

@section('content_header')
    <h1>Парсинг товаров по ссылкам</h1>
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
            <p>Для парсинга необходимо по строчно указать список ссылок на товары на сайте vezuviy.su</p>
            <form role="form" method="post" action="{{ route('get.list-links') }}">
                @csrf
                <div class="form-group">
                    <label for="links">Список ссылок</label>
                    <textarea name="links" class="form-control" id="links" rows="10" required></textarea>
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
