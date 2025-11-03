<?php

namespace App\Models\Legacy;

use Illuminate\Database\Eloquent\Model;

class Users extends Model
{
    protected $table = 'users';
    protected $primaryKey = 'id';
    public $timestamps = false;
    protected $guarded = [];

    public static function getTokens()
    {
        return self::whereNotNull('tokenFCM')->where('tokenFCM', '!=', '')->pluck('tokenFCM')->toArray();
    }
}
