<!doctype html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Foobooks</title>

</head>
<body>
<h1>Practice</h1>
@foreach($methods as $method)
    <a href='{{ str_replace('practice', '/practice/', $method) }}'> {{ $method }}</a><br>
@endforeach

</body>
</html>