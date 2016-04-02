<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    //
    public function player()
    {
        return $this->belongsTo('App\Player');
    }
}
