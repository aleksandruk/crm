<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
 
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
 
    <title>Test</title>
 
    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <script type="text/javascript" src="//cdn.jsdelivr.net/jquery/1/jquery.min.js"></script>
<script type="text/javascript" src="//cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
    <script src="//{{ Request::getHost() }}:6001/socket.io/socket.io.js"></script>
</head>
<body>
    <div id="app">
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
                    <a class="navbar-brand123" href="{{ url('/') }}">
                        Test
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
                            <li><a href="{{ route('login') }}">Login</a></li>
                            <li><a href="{{ route('register') }}">Register</a></li>
                        @else
                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                                    {{ Auth::user()->name }} <span class="caret"></span>
                                </a>
 
                                <ul class="dropdown-menu" role="menu">
                                    <li>
                                        <a href="{{ route('auth.logout') }}"
                                            onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                            Logout
                                        </a>
 
                                        <form id="logout-form" action="{{ route('auth.logout') }}" method="POST" style="display: none;">
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
 
        <div class="content">
                <div class="m-b-md">
                    New notification will be alerted realtime!<br>
                    <ul id="comments-results"></ul>
                </div>
        </div>
    </div>
 
    <!-- receive notifications -->
    <script src="{{ asset('js/echo.js') }}"></script>
 
    <script src="https://js.pusher.com/4.1/pusher.min.js"></script>
         
        <script>

            window.Echo = new Echo({
                broadcaster: 'socket.io',
                host: window.location.hostname + ':6001'
            });

            Echo.channel('comments')
            .listen('NewCommentNotification', (e) => {

                $('#comments-results').prepend('<li>Номер: '+e.comment.num_fak+' - '+'Клієнт: '+e.comment.сlient+' - '+'Коментар: '+e.comment.comment+' - '+'Пріоритет: '+e.comment.priority+' - '+'Архів: '+e.comment.archive+'</li>');
              // alert('Номер: '+e.comment.num_fak+' - '+'Клієнт: '+e.comment.сlient+' - '+'Коментар: '+e.comment.comment+' - '+'Пріоритет: '+e.comment.priority+' - '+'Архів: '+e.comment.archive);
            });
        </script>
    <!-- receive notifications -->
</body>
</html>