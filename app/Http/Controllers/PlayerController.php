<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use App\Http\Requests;
use App\Player;
use App\Score;
use Response;
use GeoIP;

class PlayerController extends Controller
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
                'players'=>  Player::with('scores')->orderBy('id', 'asc')->get() ,
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

        if(Input::get('username')&&Input::get('email')){

            $p = new Player();
            $p->username= Input::get('username');
            $p->email= Input::get('email');
            if(Input::get('telephone')){
                $p->telephone=Input::get('telephone');
            }
            $location = GeoIP::getLocation();
            $p->country=$location["country"];
            $p->isocode=$location["isoCode"];
            $p->save();

            return Response::json(array(
                'player'=>  $p ,
            ), 200);
        }else{
            return Response::json(array(
                'error'=>  'Veuillez renseigner le username et l\'email du jouer' ,
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

        $p= Player::find($id);
        if($p){
            return Response::json(array(
                'player'=>  $p ,
            ), 200);
        }else{
            return Response::json(array(
                'error'=>  'jouer non trouve' ,
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
        if(Input::get('username')&&Input::get('email')){

            $p = Player::find($id);
            if($p==null){
                return Response::json(array(
                    'error'=>  'jouer non trouve' ,
                ), 404);
            }
            $p->username= Input::get('username');
            $p->email= Input::get('email');
            if(Input::get('telephone')){
                $p->telephone=Input::get('telephone');
            }
            $location = GeoIP::getLocation();
            $p->country=$location["country"];
            $p->isocode=$location["isoCode"];
            $p->save();
            return Response::json(array(
                'player'=>  $p ,
            ), 200);
        }else{
            return Response::json(array(
                'error'=>  'Veuillez renseigner le username et l\'email du jouer' ,
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
        $p = Player::find($id);
        if($p==null){
            return Response::json(array(
                'error'=>  'jouer non trouve' ,
            ), 404);
        }

        $p->destroy();
        return Response::json(array(
            'msg'=>  'jouer supprimer avec succes' ,
        ), 200);
    }
}
