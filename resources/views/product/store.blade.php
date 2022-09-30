@extends('adminlte::page')

@section('title', 'Загрузка данных - товар Везувий')

@section('content_header')
    <h1>Загрузка данных товара Везувий</h1>
@stop

@section('content')
    @if (count($errors) > 0)

            <div class="alert alert-danger alert-dismissible fade show col-lg-9" role="alert">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

    @endif

    <x-adminlte-card title="Загрузка данных товвара" class="col-lg-9" collapsible removable maximizable>
        <div>
            <form action="{{route('product.store')}}" method="post" enctype="multipart/form-data">
                @csrf

                <div class="form-group">
                    <label for="name">Название товара</label>
                    <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name') }}" placeholder="Название...">
                </div>

                <div class="row">
                    <div class="form-group col-lg-6">
                        <label for="number">Номер товара</label>
                        <input type="text" class="form-control @error('number') is-invalid @enderror" id="number"  name="number" value="{{ old('number') }}" placeholder="00000057845.">
                    </div>

                    <div class="form-group col-lg-6">
                        <label for="code">Штрих-код товара</label>
                        <input type="number" class="form-control @error('code') is-invalid @enderror" id="code" name="code" value="{{ old('code') }}" placeholder="4610094703846">
                    </div>


                    <div class="form-group col-lg-3">
                        <label for="price">Цена товара</label>
                        <input type="number" class="form-control" id="price" name="price" value="{{ old('price') }}" placeholder="49780">
                    </div>
                </div>

                <div class="form-group">
                    <label for="link">Ссылка на товар</label>
                    <input type="text" class="form-control" id="link" name="link" value="{{ old('link') }}" placeholder="https://vezuviy.su/...">
                </div>


                <button type="submit" class="btn btn-primary mt-3 mb-3">Сохранить</button>

                </form>
            </div>
        </div>
    </x-adminlte-card>

@stop

@section('css')
    <link rel="stylesheet" href="/assets/admin/css/admin_custom.css">
@stop

@section('js')

@stop
