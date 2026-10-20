{{-- Artigo novo do blog para a newsletter (App\Mail\ArtigoNovoMail).
     Mesma cara do hero do site: bloco roxo em degradê (cs-plum-bg) com o título
     em serifa branca e o botão champagne; embaixo, a foto do artigo e a
     assinatura com a foto da Cassia.
     E-mail: tabelas e estilos inline. O Outlook ignora degradê (fica o roxo
     sólido do bgcolor) e Hotmail/Gmail não carregam fontes da web (Georgia). --}}
@php
    $serif = "'Newsreader', Georgia, 'Times New Roman', serif";
    $sans = "Arial, Helvetica, sans-serif";
    $resumo = $aviso->resumo ? \Illuminate\Support\Str::limit($aviso->resumo, 240, '…', preserveWords: true) : null;
    // WhatsApp com a mensagem já citando o artigo, para a Cassia saber de onde veio
    $whatsapp = 'https://api.whatsapp.com/send?phone=55'.preg_replace('/\D/', '', config('site.whatsapp'))
        .'&text='.rawurlencode("Olá, Cassia! Li o artigo \"{$aviso->titulo}\" e tenho uma dúvida.");
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
            .moldura { padding: 0 !important; }
            .miolo { padding-left: 24px !important; padding-right: 24px !important; }
            .titulo { font-size: 30px !important; line-height: 36px !important; }
        }
    </style>
</head>
<body style="margin:0;padding:0;background:#F5F1F4;">
    {{-- Prévia na caixa de entrada --}}
    <div style="display:none;max-height:0;overflow:hidden;opacity:0;color:#F5F1F4;">{{ \Illuminate\Support\Str::limit($aviso->resumo ?? $aviso->titulo, 110, '…', preserveWords: true) }}&#8199;&#847;&#8199;&#847;&#8199;&#847;&#8199;&#847;</div>

    <table role="presentation" width="100%" cellpadding="0" cellspacing="0" border="0" style="background:#F5F1F4;">
        <tr>
            <td align="center" class="moldura" style="padding:32px 12px 40px;">
                <table role="presentation" class="folha" width="600" cellpadding="0" cellspacing="0" border="0" style="width:600px;max-width:600px;background:#FFFFFF;border-radius:20px;overflow:hidden;">

                    {{-- Hero roxo, como o da home --}}
                    <tr>
                        <td class="miolo" bgcolor="#590854" style="padding:36px 48px 44px;background-color:#590854;background-image:radial-gradient(120% 90% at 12% 0%, #6E1468 0%, rgba(110,20,104,0) 60%), linear-gradient(160deg, #590854 0%, #3A0637 100%);">
                            <a href="{{ url('/') }}" style="text-decoration:none;">
                                <img src="{{ url('/assets/images/logo-acinzentado.png') }}" width="112" alt="Cassia Souza Advocacia" style="display:block;width:112px;height:auto;border:0;color:#F3E6F1;font-family:{{ $serif }};font-size:16px;">
                            </a>

                            @if ($aviso->categoria)
                                <p style="margin:36px 0 12px;font-family:{{ $sans }};font-size:14px;line-height:20px;font-weight:bold;color:#EFCF9F;">{{ $aviso->categoria }}</p>
                            @endif
                            <h1 class="titulo" style="margin:{{ $aviso->categoria ? '0' : '36px 0 0' }};font-family:{{ $serif }};font-size:38px;line-height:44px;font-weight:600;color:#FFFFFF;">
                                <a href="{{ $aviso->url }}" style="color:#FFFFFF;text-decoration:none;">{{ $aviso->titulo }}</a>
                            </h1>
                            @if ($resumo)
                                <p style="margin:20px 0 0;font-family:{{ $sans }};font-size:17px;line-height:28px;color:#F3E6F1;">{{ $resumo }}</p>
                            @endif

                            <table role="presentation" cellpadding="0" cellspacing="0" border="0" style="margin-top:30px;">
                                <tr>
                                    <td bgcolor="#EFCF9F" style="border-radius:999px;background:#EFCF9F;">
                                        <a href="{{ $aviso->url }}" style="display:inline-block;padding:15px 34px;border-radius:999px;background:#EFCF9F;font-family:{{ $sans }};font-size:16px;line-height:20px;font-weight:bold;color:#24041F;text-decoration:none;">Ler o artigo</a>
                                    </td>
                                </tr>
                            </table>

                            {{-- Foto do artigo dentro do roxo, como a foto no hero do site --}}
                            @if ($aviso->imagem)
                                <a href="{{ $aviso->url }}" style="display:block;margin-top:36px;">
                                    <img src="{{ $aviso->imagem }}" width="504" alt="" style="display:block;width:100%;max-width:504px;height:auto;border:0;border-radius:14px;">
                                </a>
                            @endif
                        </td>
                    </tr>

                    {{-- Assinatura com a foto da Cassia --}}
                    <tr>
                        <td class="miolo" style="padding:32px 48px 36px;">
                            <table role="presentation" cellpadding="0" cellspacing="0" border="0">
                                <tr>
                                    <td style="padding-right:16px;vertical-align:middle;">
                                        <img src="{{ url('/assets/img/cassia-email.jpg?v=2') }}" width="64" height="64" alt="Cassia Souza" style="display:block;width:64px;height:64px;border:0;border-radius:50%;">
                                    </td>
                                    <td style="vertical-align:middle;">
                                        <p style="margin:0;font-family:{{ $serif }};font-size:20px;line-height:24px;font-weight:600;color:#590854;">Cassia Souza</p>
                                        <p style="margin:4px 0 0;font-family:{{ $sans }};font-size:14px;line-height:20px;color:#6A5D68;">Advogada tributarista, atende empresas em Suzano (SP) e online.</p>
                                    </td>
                                </tr>
                            </table>
                            <p style="margin:20px 0 0;font-family:{{ $sans }};font-size:15px;line-height:23px;color:#3B2F3A;">Ficou com dúvida sobre o tema? Responda este e-mail ou chame a Cassia no WhatsApp.</p>
                            <table role="presentation" cellpadding="0" cellspacing="0" border="0" style="margin-top:16px;">
                                <tr>
                                    <td bgcolor="#590854" style="border-radius:999px;background:#590854;">
                                        <a href="{{ $whatsapp }}" style="display:inline-block;padding:12px 24px 12px 20px;border-radius:999px;background:#590854;font-family:{{ $sans }};font-size:15px;line-height:20px;font-weight:bold;color:#FFFFFF;text-decoration:none;"><img src="{{ url('/assets/email/email-whatsapp-branco.png') }}" width="20" height="20" alt="" style="display:inline-block;width:20px;height:20px;border:0;vertical-align:-5px;margin-right:8px;">Chamar no WhatsApp</a>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table>

                <table role="presentation" class="folha" width="600" cellpadding="0" cellspacing="0" border="0" style="width:600px;max-width:600px;">
                    {{-- Redes, as mesmas do rodapé do site (config/site.php) --}}
                    <tr>
                        <td class="miolo" style="padding:28px 48px 0;">
                            <table role="presentation" cellpadding="0" cellspacing="0" border="0">
                                <tr>
                                    @foreach (config('site.social_icons', []) as $rede)
                                        @php($nomeRede = ['instagram' => 'Instagram', 'tiktok' => 'TikTok', 'linkedin' => 'LinkedIn'][$rede['name']] ?? ucfirst($rede['name']))
                                        <td style="padding-right:10px;">
                                            <a href="{{ $rede['url'] }}" title="{{ $nomeRede }} da Cassia Souza"><img src="{{ url('/assets/email/email-'.$rede['name'].'.png') }}" width="36" height="36" alt="{{ $nomeRede }}" style="display:block;width:36px;height:36px;border:0;"></a>
                                        </td>
                                    @endforeach
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <tr>
                        <td class="miolo" style="padding:18px 48px 0;font-family:{{ $sans }};font-size:12px;line-height:19px;color:#6A5D68;">
                            Você recebe este e-mail porque se inscreveu na newsletter da Cassia Souza Advocacia.
                            Não quer mais receber? <a href="{{ $linkCancelar }}" style="color:#6A5D68;">Cancelar inscrição</a>.
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>
</html>
