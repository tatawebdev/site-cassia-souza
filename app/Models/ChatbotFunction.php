<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ChatbotFunction extends Model
{
    protected $table = 'chatbot_functions';

    protected $fillable = [
        'name',
        'description',
    ];
}
