<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>buy requests</title>
</head>
<body>
    <div class="items">
    @foreach ($query as $item)
        <div class="item">
            <h1>{{$item->product->title}}</h1>
            <p>{{$item->product->desc}}</p>
            {{$item->product->img}}<br>
            <span>{{$item->product->price}} коинов</span>
        </div>
    @endforeach
</div>
</body>
</html>