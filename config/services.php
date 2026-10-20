<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for third party services such
    | as Mailgun, Postmark, AWS and more. This file provides the de facto
    | location for this type of information, allowing packages to have
    | a conventional file to locate the various service credentials.
    |
    */

    'postmark' => [
        'token' => env('POSTMARK_TOKEN'),
    ],

    'resend' => [
        'key' => env('RESEND_KEY'),
    ],

    'ses' => [
        'key' => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
    ],

    'slack' => [
        'notifications' => [
            'bot_user_oauth_token' => env('SLACK_BOT_USER_OAUTH_TOKEN'),
            'channel' => env('SLACK_BOT_USER_DEFAULT_CHANNEL'),
        ],
    ],

    'google' => [
        'client_id' => env('GOOGLE_CLIENT_ID'),
        'client_secret' => env('GOOGLE_CLIENT_SECRET'),
        'redirect' => env('GOOGLE_REDIRECT_URI'),
    ],
    'places' => [
        'key' => env('GOOGLE_PLACES_KEY'),
    ],

    // Google Indexing API (google:indexing-sync). As credenciais são o JSON da
    // conta de serviço, que precisa ser proprietária da propriedade no Search Console.
    'google_indexing' => [
        'enabled' => env('GOOGLE_INDEXING_ENABLED', false),
        'credentials_path' => env('GOOGLE_INDEXING_CREDENTIALS', storage_path('app/private/google-indexing.json')),
        'base_url' => env('GOOGLE_INDEXING_BASE_URL', 'https://cassiasouzaadvocacia.com.br'),
    ],

    // Notificações no navegador (Firebase Cloud Messaging). As credenciais são o
    // JSON da conta de serviço do projeto chat-cassia-souza-adv. A chave de avisos
    // é a que o blog manda ao publicar um post (functions.php do tema).
    'fcm' => [
        'credentials_path' => env('FCM_SERVICE_ACCOUNT', storage_path('app/private/fcm.json')),
        'chave_avisos' => env('FCM_CHAVE_AVISOS'),
    ],

    // reCAPTCHA v2 ("Não sou um robô") do formulário de contato.
    // Sem a chave do site, o formulário funciona sem reCAPTCHA.
    'recaptcha' => [
        'site_key' => env('RECAPTCHA_SITE_KEY'),
        'secret_key' => env('RECAPTCHA_SECRET_KEY'),
    ],

    'deploy' => [
        'host' => env('DEPLOY_SSH_HOST'),
        'user' => env('DEPLOY_SSH_USER'),
        'port' => env('DEPLOY_SSH_PORT', 22),
        'key' => env('DEPLOY_SSH_KEY'),
        'path' => env('DEPLOY_SERVER_PATH'),
        'branch' => env('DEPLOY_BRANCH', 'main'),
        // O `php` padrão do servidor é a versão 5.6 (legado, pra sites antigos
        // na mesma conta). O Laravel roda com o binário alternativo abaixo.
        'php_bin' => env('DEPLOY_PHP_BIN', 'php'),
        // Não há `composer` no PATH do servidor; usa-se um composer.phar já
        // instalado manualmente na conta.
        'composer_path' => env('DEPLOY_COMPOSER_PATH'),
    ],
];
