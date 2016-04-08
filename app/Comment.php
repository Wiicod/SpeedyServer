<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    //
    public static $opstatus =["new"=>"Nouveau","seen"=>"Vue","traited"=>"Traitte"];

    public function player()
    {
        return $this->belongsTo('App\Player');
    }

    public function getStatusAttribute($val){

        if($val)
        return self::$opstatus[$val];
    }
}
