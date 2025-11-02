<!doctype html>
<html>
    <head>
        <meta charset="utf-8">
        <title>Novo assinante</title>
    </head>
    <body>
        <h2>Novo assinante da newsletter</h2>
        <p><strong>E-mail:</strong> {{ $subscriber->email }}</p>
        @if(!empty($subscriber->source))
            <p><strong>Fonte:</strong> {{ $subscriber->source }}</p>
        @endif
        <p>Inscrito em: {{ $subscriber->created_at }}</p>
    </body>
</html>
