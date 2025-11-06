<?php

namespace Models;

use PDO;

class ChatboConfigMessageInteractive extends Model
{
    protected $table = 'chatbot_config_message_interactive';
    protected $primaryKey = 'id';

    public function __construct()
    {
        parent::__construct();
        $this->setTable($this->table);
    }
}
