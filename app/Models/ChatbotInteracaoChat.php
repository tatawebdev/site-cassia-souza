<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Services\FcmService;
use Illuminate\Support\Facades\Log;

class ChatbotInteracaoChat extends Model
{
    protected $table = 'chatbot_interacoes_chat';

    protected $fillable = [
        'usuario_id',
        'mensagem',
        'remetente',
        'status_mensagem',
        'data_envio',
        'data_recebimento',
        'data_visualizacao',
        'data_leitura',
        'id_step',
        'data',
        'message_id',
    ];

    protected $casts = [
        'data_envio' => 'datetime',
        'data_recebimento' => 'datetime',
        'data_visualizacao' => 'datetime',
        'data_leitura' => 'datetime',
    ];

    protected static function booted()
    {
        static::created(function (self $model) {
            // Compose notification
            $title = 'Nova mensagem';
            $remetente = $model->remetente ?? 'user';
            if ($remetente === 'bot') {
                $title = 'Resposta do bot';
            }

            $body = !empty($model->mensagem) ? strip_tags(substr($model->mensagem, 0, 240)) : '';

            // Data payload to allow the client to update UI
            $data = [
                'type' => 'chat_message',
                'mensagem' => $model->mensagem,
                'usuario_id' => $model->usuario_id,
                'remetente' => $remetente,
                'id' => $model->id,
                'message_id' => $model->message_id ?? null,
            ];

            dd($data);

            try {
                $fcm = new FcmService();
                $fcm->sendNotificationToAll($title, $body, $data);
            } catch (\Exception $e) {
                Log::error('Error sending FCM from ChatbotInteracaoChat observer: ' . $e->getMessage());
            }
        });
    }
}
