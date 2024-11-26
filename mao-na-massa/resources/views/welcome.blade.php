<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Mão Massa</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Styles -->
    <style>
        body {
            font-family: 'Figtree', sans-serif;
            margin: 0;
            background-color: #000;
            /* Fundo preto */
            color: #fff;
            /* Letras brancas */
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            text-align: center;
        }

        h1 {
            font-size: 3rem;
            font-weight: bold;
            color: #fff;
            margin-bottom: 1rem;
        }

        p {
            font-size: 1.25rem;
            color: #ccc;
            margin-bottom: 2rem;
        }

        nav a {
            text-decoration: none;
            color: #fff;
            background-color: #1f2937;
            /* Botão escuro */
            padding: 0.75rem 1.5rem;
            border-radius: 8px;
            margin: 0 0.5rem;
            transition: background-color 0.3s ease;
        }

        nav a:hover {
            background-color: #4f46e5;
            /* Destaque ao passar o mouse */
        }

        footer {
            position: absolute;
            bottom: 1rem;
            font-size: 0.875rem;
            color: #888;
            /* Texto do rodapé mais claro */
        }
    </style>
</head>

<body>
    <!-- Conteúdo principal -->
    <div>
        <h1>Mão Massa</h1>
        <p>Um app web para conectar prestadores de serviços e clientes de forma prática e rápida.</p>

        <!-- Navegação -->
        <nav>
            @auth
                @if (Auth::user()->role === 'trabalhador')
                    <a href="{{ url('/worker-dashboard') }}">Dashboard</a>
                @else
                    <a href="{{ url('/dashboard') }}">Dashboard</a>
                @endif
            @else
                <a href="{{ route('login') }}">Login</a>
                <a href="{{ route('register') }}">Registrar</a>
            @endauth
        </nav>
    </div>

    <!-- Rodapé -->
    <footer>
        © {{ date('Y') }} Mão Massa. Todos os direitos reservados.
    </footer>
</body>

</html>
