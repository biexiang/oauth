<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://cdn.bootcss.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet">
    <title>Agreement</title>
</head>
<body>
    <div class="container">
        <h1>{{ $nickname  }}</h1>
        <h2>同意此应用获取您的下面这些信息:</h2>
        <p>1、个人基本信息</p> <br>
        <p>2、发送消息到平台</p>
        <a href="{{ $redirect_url  }}?code={{ $code  }}" class="btn btn-default btn-info">同意</a>
        <a href="{{ $redirect_url  }}?code=fucked" class="btn btn-default btn-danger">不同意</a>
    </div>
</body>
</html>