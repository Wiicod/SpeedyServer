<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Score extends Model
{
    //

    public function player()
    {
        return $this->belongsTo('App\Player');
    }

    public function getTypeAttribute($value){
        return Score::format_type($value);
    }
    public  static function format_type($val){
        return $val==1 ?"classic":"zen";
    }
}
