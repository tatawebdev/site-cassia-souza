<?php

// Só o blog (WordPress, outro subdomínio) chama a API pelo navegador.
return [
    'paths' => ['api/newsletter', 'api/newsletter/inscrito', 'api/fcm/token'],
    'allowed_methods' => ['POST'],
    'allowed_origins' => ['https://blog.cassiasouzaadvocacia.com.br'],
    'allowed_origins_patterns' => [],
    'allowed_headers' => ['Content-Type', 'Accept', 'X-Requested-With'],
    'exposed_headers' => [],
    'max_age' => 86400,
    'supports_credentials' => false,
];
