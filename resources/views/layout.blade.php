<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.12.1/css/all.min.css">
    <link rel="stylesheet" href="/css/estilos.css">
    

    <title>Example</title>
</head>

<body>
    <header>
        <div id="logo">
            <img src="/img/logo.png" alt="Logo">
        </div>
        <h1>Departamento de Engenharia Informática</h1>

        <div class="flex-center position-ref full-height">
            @if (Route::has('login'))
                <div class="top-right links">
                    @auth
                        <a href="{{ route('logout') }}">Logout</a>
                        <h4>Utilizador:{{ Auth::user()->name }}<h4>

                    @else
                        <a href="{{ route('login') }}">Login</a>

                        @if (Route::has('register'))
                            <a href="{{ route('register') }}">Register</a>
                        @endif
                    @endauth
                </div>
            @endif
        </div>

        

        <div id="menuIcon">
            <div class="bar1"></div>
            <div class="bar2"></div>
            <div class="bar3"></div>
        </div>
    </header>
    <div class="container">

        
            @auth {{--verificar se está autenticado--}}
            <nav>
                <ul>
                    <li class="{{Route::currentRouteName() == 'pages.index' ? 'sel' : ''}}">
                        <i class="fas fa-info-circle"></i>
                        <a href="{{route('pages.index')}}">Apresentação</a>
                    </li>
                    <li class="{{Route::currentRouteName() == 'movimentos.index' ? 'sel' : ''}}">
                        <i class="far fa-file"></i>
                        <a href="{{route('movimentos.index')}}">Movimentos</a>
                    </li>
                    <li class="{{Route::currentRouteName() == 'estatisticas.index' ? 'sel' : ''}}">
                        <i class="far fa-file"></i>
                        <a href="{{route('estatisticas.index')}}">Estatisticas</a>
                    </li>
                    <li class="{{Route::currentRouteName() == 'definicoes.index' ? 'sel' : ''}}">
                        <i class="fa fa-bars"></i>
                        <a href="{{route('definicoes.index')}}">Definicões</a>
                    </li>
                </ul>
            </nav>
            
            @endauth
        
    
        <section id="main">
            <div class="content">
                <div class="left-content">
                    @if (session('alert-msg'))
                        <div class="alert alert-{{ session('alert-type') }}">
                            <span class="closebtn" onclick="this.parentElement.style.display='none';">&times;</span>
                            <span>{{ session('alert-msg') }}</span>
                        </div>
                    @endif
                    @yield('content')
                </div>
            </div>
            <footer>
                <p>
                    © <a href="mailto:	coord.dei.estg@ipleiria.pt"> Departamento de Engenharia Informática</a>
                </p>
            </footer>

        </section>
    </div>
    <script src="js/menu.js"></script>
</body>

</html>
