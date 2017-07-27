<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://cdn.bootcss.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet">
    <title>Developer Info</title>
</head>
<body>
    <div class="container">
        @if($err)
            <h2>Error 500</h2>
        @else
            <h1>Hello:{{ $nickname  }}</h1>
            <h2>Your Dev Info :</h2>
            <h3>ApiKey: {{ $key }}</h3>
            <h3>Secrets: {{ $secret }}</h3>
        @endif
    </div>
</body>
</html>