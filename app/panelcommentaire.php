<?php 

namespace App;

use Illuminate\Database\Eloquent\Model;

class panelcommentaire extends Model {

    protected $table = 'comments';


    public function player()
    {
        return $this->belongsTo('App\Player');
    }

}
