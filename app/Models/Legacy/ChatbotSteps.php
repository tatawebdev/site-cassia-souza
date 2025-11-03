<?php

namespace App\Models\Legacy;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class ChatbotSteps extends Model
{
    protected $table = 'chatbot_steps';
    protected $primaryKey = 'id';
    public $timestamps = false;
    protected $guarded = [];

    public static function getAllSteps()
    {
        return self::all()->toArray();
    }

    public static function getStepById($id)
    {
        $step = self::where('id', $id)->first();
        if ($step) {
            $options = DB::table('chatbot_options')->where('id_step', $id)->get()->toArray();
            $stepArray = $step->toArray();
            $stepArray['options'] = $options;
            return $stepArray;
        }
        return null;
    }

    public static function addStep($data)
    {
        return self::create($data)->id;
    }

    public static function updateStep($id, $data)
    {
        return self::where('id', $id)->update($data);
    }
}
