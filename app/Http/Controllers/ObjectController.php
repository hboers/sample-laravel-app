<?php namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Zofe\Rapyd\Facades\DataEdit;
use Zofe\Rapyd\Facades\DataGrid;
use Zofe\Rapyd\Facades\DataFilter;
use App\Object;
use App\Partner;

class ObjectController extends Controller {

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
	 * Show the object list to the user.
	 *
	 * @return Response
	 */
	function getIndex()
	{
	 	$grid = DataGrid::source(Object::with('partner'));  

	    $grid->add('name','Name', true); 
	    $grid->add('{{ (string)$partner }}','Partner'); 
	    $grid->add('address2','Ort', true); 
	    $grid->add('address1','Strasse', true); 

	 	$grid->edit(url('/object/edit'), '','show'); 

	    $grid->paginate(10); 

	  	return view('grid', compact('grid'));
	}

	/**
	 *
	 * @return Response
	 */
	function anyEdit(Request $request) {

		$edit = DataEdit::source(new Object);

		// Return to partner on create abort
		if ($edit->status == 'create') {

			$partner = Partner::find($request->get('partner_id',0));

		   	if ($partner instanceOf Partner) {	
				$edit->link(url("/partner/edit?show=".$partner->id),"abbrechen", "TR")->back();
				$edit->model->partner_id = $partner->id;
			}

			else {
				// TODO Flash Error
				return redirect(url('/partner'));
			}

		} 

		else  {
			
			$partner = $edit->model->partner;
			if ($edit->status == 'show') {
				$edit->link(url('/object/note?noteable_id='.$edit->model->id),'notiz anlegen','BR');
				$edit->link(url("/task/edit?object_id=".$edit->model->id),"aufgabe anlegen", "BR");
				$edit->link(url("/photo/edit?object_id=".$edit->model->id),"photo anlegen", "BR");
				$edit->link(url("/partner/edit?show=".$partner->id),(string)$partner, "TR")->back();
			}

			else if ($edit->status == 'modify') {
				$edit->link(url("/partner/edit?show=".$partner->id),(string)$partner, "TR")->back();
				$edit->link(url("/partner/edit?delete=".$partner->id),(string)$partner, "TR");
			}
		}

		// Display only: Partner name
		$edit->add('dummy','Partner','text')
			->attributes(['readonly'=>'readonly']) 
			->showValue((string)$partner) 
			->updateValue((string)$partner) 
			->insertValue((string)$partner); 

	   	$edit->add('name','Name','text')
			// Ignore existing record on modify
			->attributes(['class'=>'autofocus'])
			->rule('required|unique:objects,name'.$edit->status == 'modify'?','.$edit->model->id:'')
			->insertValue($partner->shortname); 

		$edit->add('address1','Strasse Nr','text')
			->rule('required')
			->insertValue($partner->address1); 

		$edit->add('address2','PLZ Ort','autocomplete')
			->rule('required')
			->insertValue($partner->address2) 
			->remote("name","name",url('/01/ac/address2'));

	    return $edit->view('object', compact('edit'));

	}
}
