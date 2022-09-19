<table>
    <thead>
    <tr><th>JSON-Характиристики</th>
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
            <td>{{ $product->options }}</td>
            @if(count($NamesProperty)>0)
                @foreach ($NamesProperty  as $name)
                    @foreach ($product->properties as $prop)
                        @if($prop['name'] == $name)
                         <td>{{$prop['value'] }}</td>
                        @endif
                    @endforeach
                @endforeach
            @endif
        </tr>
    @endforeach
    </tbody>
</table>
