<!doctype html>
<html lang="ru_RU">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <title>{{ config('app.name', 'Учим Laravel') }}</title>
</head>
<body>
<div class="container">
    <div class="row">
        <nav class="navbar navbar-expand-lg bg-light">
            <div class="container-fluid">

                <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
                    <div class="navbar-nav">
                        <a class="nav-link active" aria-current="page" href="{{ route('main.index') }}">Main</a>
                        <a class="nav-link" href="{{ route('post.index') }}">Posts</a>
                        <a class="nav-link disabled" href="{{ route('about.index') }}">About</a>
                        <a class="nav-link" href="{{ route('contacts.index') }}">Contacts</a>
                        @can('view', auth()->user())
                        <a class="nav-link" href="{{ route('admin.post.index') }}">Админка</a>
                        @endcan
                    </div>
                </div>
            </div>
        </nav>

        <!--nav>
            <ul>
                <li><a href="{{ route('main.index') }}">Main</a></li>
                <li><a href="{{ route('post.index') }}">Posts</a></li>
                <li><a href="{{ route('about.index') }}">About</a></li>
                <li><a href="{{ route('contacts.index') }}">Contacts</a></li>
            </ul>
        </nav-->
    </div>

    @yield('content')

</div>
</body>
</html>