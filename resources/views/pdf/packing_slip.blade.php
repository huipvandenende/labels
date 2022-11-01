<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
@foreach($order->orderLines as $line)
    {{$line->quantity . ' x ' . $line->name}}
    {{$line->quantity}}
    {{$line->sku}}
    {{$line->barcode}}
    <br>
@endforeach
<img src="data:image/png;base64,{{ $image }}" width="600"/>
</body>
</html>