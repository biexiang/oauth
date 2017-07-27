<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://cdn.bootcss.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.bootcss.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <title>Auth Login</title>
</head>
<body>
<div class="container">
    <div class="header">
        <h2>授权登录</h2>
    </div>
    <form action="/e/o/login_handler" method="post">
        <div class="info">
            授权您在Evil Corp的信息到应用:{{ $app_name  }} <br>
            请登录!
        </div>
        <div class="form-group">
            <label for="exampleInputEmail1">邮箱:</label>
            <input type="email" class="form-control" id="exampleInputEmail1" name="email">
        </div>
        <div class="form-group">
            <label for="exampleInputPassword1">密码:</label>
            <input type="password" class="form-control" id="exampleInputPassword1" name="pass">
        </div>
        {!! csrf_field() !!}
        <button type="submit" class="btn btn-default">登录</button>
    </form>
</div>
</body>
</html>