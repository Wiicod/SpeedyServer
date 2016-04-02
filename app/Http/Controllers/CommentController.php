<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Comment;
use App\Player;
use Response;
use Illuminate\Support\Facades\Input;


class CommentController extends Controller
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
                'comments'=>  Comment::with('player')->orderBy('id', 'asc')->get() ,
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
        if(Input::get('player')&&Input::get('title')&&Input::get('description')){



            $c = new Comment();
            $c->title= Input::get('title');
            $c->description= Input::get('description');
            $c->player()->associate($p);
            $c->save();

            return Response::json(array(
                'comment'=>  $c ,
            ), 200);
        }else{
            return Response::json(array(
                'error'=>  'Veuillez renseigner le titre (title) la description (description)  et l\id du  jouer (player)' ,
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
        $c= Comment::find($id);
        if($c){
            return Response::json(array(
                'comment'=>  $c ,
            ), 200);
        }else{
            return Response::json(array(
                'error'=>  'commentaire non trouve' ,
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
        $c = Comment::find($id);
        if($c==null){
            return Response::json(array(
                'error'=>  'commentaire non trouve' ,
            ), 404);
        }

        $c->delete();
        return Response::json(array(
            'msg'=>  'commentaire supprimer avec succes' ,
        ), 200);
    }
}
