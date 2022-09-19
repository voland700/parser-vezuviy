@extends('adminlte::page')

@section('title', 'Парсинг категрой товаров')

@section('content_header')
    <h1>Парсинг категорий товаров</h1>
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



    <x-adminlte-card title="Данные для парсинга" class="col-12" collapsible removable maximizable>
        <div class="col-lg-6">
            <p>Для парсинга необходимо указать ссылку на каетгорию товров на сайте vezuviy.su</p>
            <form role="form" method="post" action="{{ route('get.category') }}">
                @csrf

                <div class="form-group">
                    <label for="link">Ссылка</label>

                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fas fa-link"></i></span>
                        </div>
                        <input type="text" name="link" class="form-control" id="link" required placeholder="https://vezuviy.su/...">
                        <span class="input-group-append">
                            <button type="submit" class="btn btn-info btn-flat">Go!</button>
                        </span>
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
    <script> console.log('Hi!'); </script>
@stop
