<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="icon" type="image/png" href="{{asset('/dashboard/img/logo.png')}}">
        <title>studio-mim</title>
        <!-- Fonts -->
        <link href="https://fonts.bunny.net/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

        <style>
            body {
                font-family: 'Nunito', sans-serif;
            }
        </style>
    </head>
    <body
        style="background-image: url(https://studio-mim.com/wp-content/uploads/2022/04/Mental-path.jpg);
        background-size: cover;
        background-repeat:no-repeat;
        ">

        <div class="container mt-5 pt-5">
            <div class="row justify-content-center">
                <div class="col-md-4 text-center">
                    <img src="{{asset('/dashboard/img/logo.png')}}" class="w-25">
                </div>
            </div>
            <div class="row justify-content-center">
                <div class="col-md-4 text-center">
                    <h1 class="bold text-white display-1">Studio Mim</h1>
                </div>
            </div>

            <div class="row justify-content-center mt-5">
                <div class="col-md-4 text-center">
                    @if(auth()->check())
                        @if(auth()->user()->level == 'admin')
                        <a href="{{route('admin.index')}}"  class="btn btn-outline-light">
                            پنل مدیریت
                        </a>

                        <a href="{{route('agent.index')}}" class="btn btn-outline-light">
                            پنل بازاریاب
                        </a>
                        @else
                            <a href="{{route('agent.index')}}" >
                                ورود به پنل
                            </a>
                        @endif
                    @else
                        <a href="{{route('otp-login.form')}}" class="btn btn-outline-light">
                           ورود به سایت
                        </a>
                    @endif
                </div>
            </div>
        </div>
    </body>
</html>
