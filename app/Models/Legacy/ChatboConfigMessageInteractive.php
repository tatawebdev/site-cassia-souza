<?php

namespace App\Models\Legacy;

use Illuminate\Database\Eloquent\Model;

class ChatboConfigMessageInteractive extends Model
{
    // Modelo Laravel para a tabela antiga
    protected $table = 'chatbot_config_message_interactive';
    protected $primaryKey = 'id';
    public $timestamps = false;
    protected $guarded = [];
}
