{{-- Artigo novo do blog para a newsletter (App\Mail\ArtigoNovoMail).
     E-mail: tabelas e estilos inline, sem fontes da web garantidas
     (Newsreader só onde o leitor aceita; Georgia e Arial no resto). --}}
@php
    $serif = "'Newsreader', Georgia, 'Times New Roman', serif";
    $sans = "'Public Sans', Arial, Helvetica, sans-serif";
    $resumo = $aviso->resumo ? \Illuminate\Support\Str::limit($aviso->resumo, 260, '…', preserveWords: true) : null;
@endphp
<!doctype html>
<html lang="pt-BR">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="color-scheme" content="light">
    <title>{{ $aviso->titulo }}</title>
    <link href="https://fonts.googleapis.com/css2?family=Newsreader:opsz,wght@6..72,600&display=swap" rel="stylesheet">
    <style>
        @media (max-width: 620px) {
            .folha { width: 100% !important; border-radius: 0 !important; }
            .miolo { padding-left: 24px !important; padding-right: 24px !important; }
            .titulo { font-size: 26px !important; line-height: 32px !important; }
        }
        a.botao:hover { background: #6d0a67 !important; }
    </style>
</head>
<body style="margin:0;padding:0;background:#F5F1F4;">
    {{-- Prévia na caixa de entrada --}}
    <div style="display:none;max-height:0;overflow:hidden;opacity:0;color:#F5F1F4;">{{ \Illuminate\Support\Str::limit($aviso->resumo ?? $aviso->titulo, 110) }}&#8199;&#847;&#8199;&#847;&#8199;&#847;&#8199;&#847;</div>

    <table role="presentation" width="100%" cellpadding="0" cellspacing="0" border="0" style="background:#F5F1F4;">
        <tr>
            <td align="center" style="padding:32px 12px 40px;">
                <table role="presentation" class="folha" width="600" cellpadding="0" cellspacing="0" border="0" style="width:600px;max-width:600px;background:#FFFFFF;border-radius:16px;overflow:hidden;">
                    <tr>
                        <td style="background:#590854;padding:22px 40px;" class="miolo">
                            <a href="{{ url('/') }}" style="text-decoration:none;">
                                <img src="{{ url('/assets/images/logo-acinzentado.png') }}" width="132" alt="Cassia Souza Advocacia" style="display:block;width:132px;height:auto;border:0;color:#EFCF9F;font-family:{{ $serif }};font-size:18px;">
                            </a>
                        </td>
                    </tr>

                    @if ($aviso->imagem)
                        <tr>
                            <td>
                                <a href="{{ $aviso->url }}">
                                    <img src="{{ $aviso->imagem }}" width="600" alt="" style="display:block;width:100%;max-width:600px;height:auto;border:0;">
                                </a>
                            </td>
                        </tr>
                    @endif

                    <tr>
                        <td class="miolo" style="padding:36px 48px 8px;">
                            @if ($aviso->categoria)
                                <p style="margin:0 0 10px;font-family:{{ $sans }};font-size:14px;line-height:20px;font-weight:600;color:#8A3A84;">{{ $aviso->categoria }}</p>
                            @endif
                            <h1 class="titulo" style="margin:0;font-family:{{ $serif }};font-size:32px;line-height:38px;font-weight:600;color:#3B2F3A;">
                                <a href="{{ $aviso->url }}" style="color:#3B2F3A;text-decoration:none;">{{ $aviso->titulo }}</a>
                            </h1>
                            @if ($resumo)
                                <p style="margin:18px 0 0;font-family:{{ $sans }};font-size:16px;line-height:26px;color:#4A3B48;">{{ $resumo }}</p>
                            @endif
                        </td>
                    </tr>

                    <tr>
                        <td class="miolo" style="padding:28px 48px 36px;">
                            <table role="presentation" cellpadding="0" cellspacing="0" border="0">
                                <tr>
                                    <td style="border-radius:999px;background:#590854;">
                                        <a class="botao" href="{{ $aviso->url }}" style="display:inline-block;padding:14px 30px;border-radius:999px;background:#590854;font-family:{{ $sans }};font-size:16px;line-height:20px;font-weight:600;color:#EFCF9F;text-decoration:none;">Ler o artigo</a>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>

                    <tr>
                        <td class="miolo" style="padding:0 48px 36px;">
                            <table role="presentation" width="100%" cellpadding="0" cellspacing="0" border="0">
                                <tr><td style="border-top:2px solid #EFCF9F;font-size:0;line-height:0;">&nbsp;</td></tr>
                            </table>
                            <p style="margin:22px 0 0;font-family:{{ $serif }};font-size:20px;line-height:26px;font-weight:600;color:#590854;">Cassia Souza</p>
                            <p style="margin:4px 0 0;font-family:{{ $sans }};font-size:14px;line-height:22px;color:#6A5D68;">Advocacia tributária para empresas, em Suzano (SP) e online.<br>Dúvidas sobre o tema? <a href="{{ route('contato') }}" style="color:#590854;font-weight:600;">Fale com a Cassia</a>.</p>
                        </td>
                    </tr>
                </table>

                <table role="presentation" class="folha" width="600" cellpadding="0" cellspacing="0" border="0" style="width:600px;max-width:600px;">
                    <tr>
                        <td class="miolo" style="padding:24px 48px 0;font-family:{{ $sans }};font-size:13px;line-height:20px;color:#6A5D68;">
                            Você recebe este e-mail porque se inscreveu na newsletter da <a href="{{ url('/') }}" style="color:#6A5D68;">Cassia Souza Advocacia</a>.
                            Não quer mais receber? <a href="{{ $linkCancelar }}" style="color:#590854;font-weight:600;">Cancelar inscrição</a>.
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>
</html>
