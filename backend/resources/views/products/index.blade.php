<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>products</title>
</head>
<body>
    <div class="items">
    @foreach ($query as $item)
        <div class="item">
            <h1>{{$item->title}}</h1>
            <p>{{$item->desc}}</p>
            {{$item->img}}<br>
            <span>{{$item->price}} коинов</span>
            <form action="{{route('buyRequest.buy',$item->id)}}" method="post">
                @csrf
                <button type="submit">Купить</button>
            </form>
        </div>
    @endforeach
</div>
</body>
</html>