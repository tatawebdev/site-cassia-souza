<!doctype html>
<html>
    <head>
        <meta charset="utf-8">
        <title>Novo contato</title>
    </head>
    <body>
        <h2>Novo contato recebido</h2>
        <p><strong>Nome:</strong> {{ $data['nome'] ?? '-' }}</p>
        <p><strong>Telefone:</strong> {{ $data['phone'] ?? '-' }}</p>
        <p><strong>E-mail:</strong> {{ $data['email'] ?? '-' }}</p>
        <p><strong>Área de interesse:</strong> {{ $data['area'] ?? '-' }}</p>
        <p><strong>Mensagem:</strong></p>
        <p>{!! nl2br(e($data['msg'] ?? '')) !!}</p>

        <hr>
        <p>Enviado pelo site Cassia Souza Advocacia.</p>
    </body>
    </html>
