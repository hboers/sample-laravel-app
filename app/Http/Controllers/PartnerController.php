<?php namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Zofe\Rapyd\Facades\DataEdit;
use Zofe\Rapyd\Facades\DataGrid;
use Zofe\Rapyd\Facades\DataFilter;
use Khill\Fontawesome\FontAwesomeFacade as FA;
use App\Noteable\NoteableControllerTrait;
use App\Partner;

class PartnerController extends Controller {

	use NoteableControllerTrait;

	/**
	 * Create a new controller instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
		$this->middleware('auth');
	}

	/**
	 * Show the parter list to the user.
	 *
	 * @return Response
	 */
	function getIndex()
	{
	 	$grid = DataGrid::source(new Partner);  

	    $grid->add('name','Name', true); 
	    $grid->add('contact','Ansprechpartner', true); 
	    $grid->add('address2','Ort', true); 

	 	$grid->edit(url('/partner/edit'), '','show'); 
	   	$grid->link(url('/partner/edit'),"anlegen", "TR"); 

	    $grid->paginate(10); 

	  	return view('grid', compact('grid'));
	}

	function anyEdit(Request $request) {

		$edit = DataEdit::source(new Partner);

		if ($edit->status=='show') {
			$edit->link(url('/partner/note?noteable_id='.$edit->model->id),'notiz anlegen','BR');
			$edit->link(url("/task/edit?partner_id=".$edit->model->id),"aufgabe anlegen", "BR");
			$edit->link(url("/object/edit?partner_id=".$edit->model->id),"standort anlegen", "BR");
		}

		if ($edit->status == 'create') {
			$edit->link(url('/partner'),'abbrechen','TR')->back();
		}

		if ($edit->status == 'modify') {
			$edit->link(url('/partner/edit?delete='.$edit->model->id),'löschen','TR');
		}

		$edit->add('name','Name','text')
			->attributes(['class'=>'autofocus'])
			->rule('required|unique:objects,name'.$edit->status == 'modify'?','.$edit->model->id:'') ;

		$edit->add('contact','Kontakt','text')->rule('required');

		$edit->add('email','Email','text')->rule('email');
	   	$edit->add('phone','Telefon','text');
	   	$edit->add('mobile','Mobil','text');
	   	$edit->add('website','Web','text');

	   	$edit->add('address1','Strasse Nr','text')->rule('required');
		$edit->add('address2','PLZ Ort','autocomplete')->rule('required')
			->remote('name','name',url('/01/ac/address2'));

		// Display only: Number of Objects  
		/*
		$number =  count($edit->model->objects);
		$edit->add('dummy','Standorte','text')
			->attributes(['readonly'=>'readonly']) 
			->showValue($number) 
			->updateValue($number) 
			->insertValue($number); 
		 */

	    return $edit->view('partner', compact('edit'));

	}

}
