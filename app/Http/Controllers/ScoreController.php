<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Score;
use App\Player;
use Response;
use Illuminate\Support\Facades\Input;

class ScoreController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id=null)
    {
        //
        if ($id == null) {

            return Response::json(array(
                'scores'=>  Score::with('player')->orderBy('id', 'asc')->get() ,
            ), 200);
        } else {
            return $this->show($id);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        $p = Player::find(Input::get('player'));
        if($p==null){
            return Response::json(array(
                'error'=>  'jouer non trouve' ,
            ), 404);
        }
        if(Input::get('player')&&Input::get('click')&&Input::get('type')&&Input::get('speed')){

            $s = Score::where('player_id','=',Input::get('player'))->where('type','=',Input::get('type'))->first();
            if($s !=null){
                return $this->update($request,$s->id);
            }

            $s = new Score();
            $s->click= Input::get('click');
            $s->speed= Input::get('speed');
            $s->type=Input::get('type')=="classic"?true:false;
            $s->player()->associate($p);
            $s->save();

            return Response::json(array(
                'score'=>  $s ,
            ), 200);
        }else{
            return Response::json(array(
                'error'=>  'Veuillez renseigner le nombre de click (click) la vitesse (speed) le type (type valeur :classic ou zen ) et l\id du  jouer (player) et l\'email du jouer' ,
            ), 405);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
        $s= Score::find($id);
        if($s){
            return Response::json(array(
                'score'=>  $s ,
            ), 200);
        }else{
            return Response::json(array(
                'error'=>  'score non trouve' ,
            ), 404);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
        $p = Player::find(Input::get('player'));
        if($p==null){
            return Response::json(array(
                'error'=>  'jouer non trouve' ,
            ), 404);
        }
        if(Input::get('player')&&Input::get('click')&&Input::get('type')&&Input::get('speed')){

            $s = Score::find($id);
            if($s==null){
                return Response::json(array(
                    'error'=>  'score non trouve' ,
                ), 404);
            }
            $s->click= Input::get('click');
            $s->speed= Input::get('speed');
            $s->type=Input::get('type')=="classic"?true:false;
            $s->player()->associate($p);
            $s->save();
            return Response::json(array(
                'score'=>  $s ,
            ), 200);
        }else{
            return Response::json(array(
                'error'=>  'Veuillez renseigner le nombre de click (click)
                 la vitesse (speed) le type (classic ou zen ) et l\id du  jouer (player) et l\'email du jouer' ,
            ), 405);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
