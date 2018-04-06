<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Library</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
    <!-- Styles -->

    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/header.css') }}" rel="stylesheet">
</head>
<body>
<div id="app">
    <header class="head">
        <div class="container">
            <nav class="navbar navbar-default navbar-static-top">
                <div class="container">
                    <div class="navbar-header">

                        <!-- Collapsed Hamburger -->
                        <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#app-navbar-collapse">
                            <span class="sr-only">Toggle Navigation</span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                        </button>

                        <!-- Branding Image -->
                        <a class="navbar-brand" href="{{ url('/') }}">
                            <img src="{{URL::to('/')}}/images/logo.png" class="logo">
                        </a>
                    </div>

                    <div class="collapse navbar-collapse" id="app-navbar-collapse">
                        <!-- Left Side Of Navbar -->
                        <ul class="nav navbar-nav">
                            &nbsp;
                        </ul>

                        <!-- Right Side Of Navbar -->
                        <ul class="nav navbar-nav navbar-right">
                            <!-- Authentication Links -->
                            @if (Auth::guest())
                                <li><a href="{{ route('login') }}">Вход</a></li>
                                <li><a href="{{ route('register') }}">Регистрация</a></li>
                            @else
                                <li class="dropdown">
                                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                                        {{ Auth::user()->name }} <span class="caret"></span>
                                    </a>

                                    <ul class="dropdown-menu" role="menu">
                                        <li>
                                            <a href="{{ route('logout') }}"
                                               onclick="event.preventDefault();
                                                             document.getElementById('logout-form').submit();">
                                                Logout
                                            </a>

                                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                                {{ csrf_field() }}
                                            </form>
                                        </li>
                                    </ul>
                                </li>
                            @endif
                        </ul>
                    </div>

                </div>

            </nav>

        </div>
        <div class="top-nav head">
            <div class="container">
                <ul class="nav navbar-nav">
                    <li><a href="{{route('library')}}">Библиотека</a></li>
                    <li><a href="{{route('home')}}">Личный кабинет</a></li>
                    @if (!Auth::guest() && Auth::user()->role == 'admin')
                        <li><a href="{{route('users', 'user')}}">Пользователи</a>
                            <ul class="nav ">
                                <li><a href="{{route('users', 'user')}}">Посетители</a></li>
                                <li><a href="{{route('users', 'admin')}}">Администрация</a></li>
                                <li>
                                    <a href="{{ route('createUser') }}" title="Добавить пользоватля не желающего иметь личный кабинет">
                                        Добавить пользоватля
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <li><a href="{{route('booksAdmin', ['title_book', 'asc'])}}">Управление книгами</a>
                            <ul class="nav ">
                                <li><a href="{{route('taken')}}">Взятые книги</a></li>
                                <li><a href="{{route('createBook')}}">Добавить книгу</a></li>
                                <li><a href="{{route('genresAdmin')}}">Жанры книг</a></li>

                            </ul>
                        </li>
                        <li><a href="{{route('mailForm')}}">Написать письмо</a></li>
                    @endif
                    &nbsp;
                </ul>
            </div>

        </div>
    </header>
    <div class="container">
        @yield('content')
    </div>
</div>

<!-- Scripts -->
<script src="{{ asset('js/app.js') }}"></script>
</body>
</html>





