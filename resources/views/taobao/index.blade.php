<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://cdn.bootcss.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet">
    <title>Taobao</title>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>TaoBao首页 | 蚂蚁金服</h1>
        </div>
        <hr>
        <div class="login">
            @foreach($config as $item)
            <a href="{{$item['url']}}?redirect_url={{$callback}}&api_key={{$item['api_key']}}" class="btn btn-default btn-info">使用Evil Corp账号登录</a>
            @endforeach
        </div>
    </div>
</body>
</html>