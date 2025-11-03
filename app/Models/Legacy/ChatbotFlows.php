<?php

namespace App\Models\Legacy;

use Illuminate\Database\Eloquent\Model;

class ChatbotFlows extends Model
{
    protected $table = 'chatbot_flows';
    protected $primaryKey = 'id';
    public $timestamps = false;
    protected $guarded = [];
}
