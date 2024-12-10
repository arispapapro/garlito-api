<html lang="en">
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title>@yield('title')</title>
        <style>
            .text-center{text-align: center;}
            main{ background: white; padding:20px; }
            a.button{
                background: {{$data['primary_color']}};
                padding: 10px 20px;
                border-radius: 25px;
                color: white;
                text-decoration: none;
            }
        </style>
    </head>
    <body style="background:#f3f3f3; padding:20px;">

        <header style="text-align: center; padding: 10px;">
            <img width="150" height="50" src="{{url('images/branding/logo.png')}}" alt="Logo">
        </header>

        <main style="width:300px;">
            @yield('content')
        </main>

    </body>
</html>
