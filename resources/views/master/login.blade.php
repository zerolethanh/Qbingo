<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>MASTER LOGIN</title>
    @include('bootstrap.sources')
</head>
<body>

@if(isset($shop))

@endif

<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">MASTER LOGIN</div>
                <div class="panel-body">
                    @if (count($errors) > 0)
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    <form class="form-horizontal" role="form" method="POST" action="/master/login">
                        {{ csrf_field() }}

                        <div class="form-group">
                            <label for="uuid" class="col-md-4 control-label">ID</label>
                            <div class="col-md-6">
                                <input id="uuid" type="text" class="form-control" name="uuid" autofocus
                                       required/>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="password" class="col-md-4 control-label">PASS</label>
                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control" name="password" required/>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-8 col-md-offset-6">
                                <button type="submit" class="btn btn-primary">
                                    LOGIN
                                </button>
                            </div>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

</body>
</html>
