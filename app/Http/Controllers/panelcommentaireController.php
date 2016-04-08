<?php 

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use \Serverfireteam\Panel\CrudController;

use App\Comment;
use Illuminate\Http\Request;

class panelcommentaireController extends CrudController{

	protected  $status = null;

	public function all($entity){
		$this->status=Comment::$opstatus;
		parent::all($entity);

		//** Simple code of  filter and grid part , List of all fields here : http://laravelpanel.com/docs/master/crud-fields


		$this->filter = \DataFilter::source(new Comment());
		$this->filter->add('title', 'Titre', 'text');
		$this->filter->add('status','Status','select')->options($this->status);
		$this->filter->add('player_id','Joueur','select')->options(\App\Player::lists("username", "id")->all());
		$this->filter->submit('search');
		$this->filter->reset('reset');
		$this->filter->build();

		$this->grid = \DataGrid::source($this->filter);
		$this->grid->add('title', 'Titre',true);
		$this->grid->add('status', 'Status');
		$this->grid->add('created_at', 'Date de creation');
		$this->grid->add('updated_at', 'Date de modification');
		$this->grid->add('description', 'Description');
		$this->addStylesToGrid();

		$this->grid->paginate(10);
		//$this->grid->add('nom', 'Nom', true); // allow ordering by this column





		return $this->returnView();
	}

	public function  edit($entity){

		$this->status=Comment::$opstatus;
		$opts=$this->status;

		parent::edit($entity);

		/* Simple code of  edit part , List of all fields here : http://laravelpanel.com/docs/master/crud-fields

            $this->edit = \DataEdit::source(new \App\Category());

            $this->edit->label('Edit Category');

            $this->edit->add('name', 'Name', 'text');

            $this->edit->add('code', 'Code', 'text')->rule('required');


        */
		$this->edit = \DataEdit::source(new \App\Comment());
		$this->edit->label('Detail commentaire');
		$this->edit->add('title','Titre du commentaire', 'text')->rule('required|min:2');
		$this->edit->add('player_id','Auteur','select')->options(\App\Player::lists("username", "id")->all());
		$this->edit->add('status','Status du commentaire', 'select')->options($opts);
		$this->edit->add('description','Description du commentaire', 'textarea')->rule('required');
		$this->edit->add('description', 'Description', 'textarea')->rule('required');


		return $this->returnEditView();

	}
}
