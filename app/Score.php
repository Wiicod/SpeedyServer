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
        return $value==1 ?"classic":"zen";
    }
    public  static function format_type($val){
        return $val=="classic"?true:false;
    }
}
