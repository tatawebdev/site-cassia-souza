<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\WebhookController;

Route::get('/', function (Request $request) {
    return response()->json(['message' => 'Hello, API!']);
});



Route::prefix('webhook/whatsapp')->group(function () {
    Route::post('/', [WebhookController::class, 'handle']);

    Route::get('/', function () {
        $webhookData = [
            'query' => $_GET,
            'headers' => getallheaders(),
        ];

        file_put_contents(storage_path('app/webhook_data.json'), json_encode($webhookData, JSON_PRETTY_PRINT));
        return response($_REQUEST['hub_challenge'] ?? '');
    });
    Route::get('/teste', [WebhookController::class, 'teste']);


});




Route::get('send-whatsapp', function (Request $request, \App\Services\WhatsAppService $whatsapp) {

    $data = [
        'to' => 11951936777,
        'message' => 'Olá! Esta é uma mensagem de teste enviada via API do WhatsApp.',
    ];
    $result = $whatsapp->sendMessageText($data['to'], $data['message'], $data['preview_url'] ?? true);

    return response()->json($result);
});