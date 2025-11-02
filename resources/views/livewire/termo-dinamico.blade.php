{{-- View mínima para o componente TermoDinamico --}}
<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $titulo ?? ($servico ?? 'Cassia Souza Advocacia') }}</title>
    <meta name="description" content="{{ $descricao ?? '' }}">
    <meta name="keywords" content="{{ $palavrasChave ?? '' }}">
</head>
<body>
    <main>
        <header>
            <h1>{!! $tituloBanner ?? ($titulo ?? ($servico ?? 'Cassia Souza Advocacia')) !!}</h1>
            @if(!empty($textoBanner))
                <p>{!! $textoBanner !!}</p>
            @endif
        </header>

        <section>
            <h2>{{ $servico ?? $titulo }}</h2>
            <p>{{ $descricao ?? '' }}</p>
            <p><strong>Cidade:</strong> {{ $cidade ?? '-' }} <strong>Estado:</strong> {{ $estado ?? '-' }}</p>
        </section>
    </main>
</body>
</html>
