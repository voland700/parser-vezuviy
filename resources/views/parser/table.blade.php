<table>
    <thead>
    <tr>
        <th>Ссылка</th>
        <th>Название</th>

        <th>Категории</th>
        <th>Категория</th>
        <th>Артикул</th>
        <th>Изображение</th>
        <th>Доп. изображения</th>
        <th>Цена</th>
        <th>Описание</th>
        <th>JSON-Характиристики</th>
        <th>JSON-Документы</th>
        <th>JSON-Видео</th>
        @if(count($NamesProperty)>0)
        @foreach($NamesProperty as $name)
            <td>{{$name}}</td>
        @endforeach
        @endif
    </tr>
    </thead>
    <tbody>
    @foreach($products as $product)
        <tr>
            <td>{{ $product->link }}</td>
            <td>{{ $product->name }}</td>
            <td>{{ $product->categories }}</td>
            <td>{{ $product->category }}</td>
            <td>{{ $product->artNamber }}</td>
            <td>{{ $product->image }}</td>
            <td>{{ $product->images }}</td>
            <td>{{ $product->price }}</td>
            <td>{{ $product->description }}</td>
            <td>{{ $product->options }}</td>
            <td>{{ $product->documentation }}</td>
            <td>{{ $product->video }}</td>
            @if(count($NamesProperty)>0)
                @foreach ($NamesProperty  as $name)
                    <td>
                    @foreach ($product->properties as $prop)
                        @if($prop['name'] == $name)
                            {{$prop['value'] }}
                        @endif
                    @endforeach
                    </td>
                @endforeach
            @endif
        </tr>
    @endforeach
    </tbody>
</table>
