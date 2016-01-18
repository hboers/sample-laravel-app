<?php namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Zofe\Rapyd\Facades\DataEdit;
use Zofe\Rapyd\Facades\DataGrid;
use Zofe\Rapyd\Facades\DataFilter;
use Khill\Fontawesome\FontAwesomeFacade as FA;
use App\Noteable\NoteableControllerTrait;
use App\Task;
use App\Object;
use App\Partner;
use App\User;
use App\Noteable\Note;

class TaskController extends Controller {

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
	 	$grid = DataGrid::source(new Task);  

	    $grid->add('name','Name', true); 
		$grid->add('finishDate','Endtermin', true); 
		$grid->add('assignedTo','Verantwortlich', false); 

		//$grid->add('createdBy','Angelegt von', true); 
	 	$grid->edit(url('/task/edit'), '','show'); 
	   	$grid->link(url('/task/edit'),"anlegen", "TR"); 

	    $grid->paginate(10); 

	  	return view('grid', compact('grid'));
	}

	function anyEdit(Request $request) {

		$partner = null;
		$object = null;

		$edit = DataEdit::source(new Task);

		if ($edit->status == 'create') {
			$edit->link(url('/task'),'abbrechen','TR')->back();
		}

		if ($edit->status == 'show') {
			$edit->link(url('/task/note?noteable_id='.$edit->model->id),'notiz anlegen','BR');
		}

		if ($edit->status == 'modify') {
			$edit->link(url('/task/edit?delete='.$edit->model->id),'löschen','TR');
		}

		// Add Partner reference
		if ($request->has('partner_id')) {
			$partner =  Partner::find($request->get('partner_id'));
			if ($partner instanceOf Partner) {
				$edit->model->partner_id = $partner->id;
			}
		} 

		// Add Object reference
		else if ($request->has('object_id')) {
			$object =  Object::find($request->get('object_id'));
			if ($object instanceOf Object) {
				$edit->model->object_id = $object->id;
				$edit->model->partner_id = $object->partner_id;
				$partner = $object->partner;

			}
		} else {
			$partner = $edit->model->partner;
			$object = $edit->model->object;
		}

		$edit->add('name','Aufgabe','text')
			->attributes(['class'=>'autofocus'])
			->rule('required');

		$edit->add('assigned_to','Verantwortlich','select')
			->options([null => '-- Nicht zugeordnet --']+User::lists("name", "id"));

		if ($edit->status == 'create') {
			$edit->add('note','Details','textarea');
		}

		else if ($edit->status == 'modify') {
			$edit->add('is_finished','Erledigt','checkbox');
		}

		else if ($edit->status == 'show') {
			// Display Partner
			$edit->add('dummy3','Erledigt','text')
				->showValue($edit->model->is_finished?'ja':'nein')
				->attributes(['readonly'=>'readonly']);
		}

		$begin_at = date('Y-m-d');
		$edit->add('begin_at','Start','date')
			->format('Y-m-d')
			->insertValue($begin_at)
			->showValue($begin_at)
			->rule('required');

		$finish_at = date('Y-m-d',strtotime('+1 week'));
		$edit->add('finish_at','Ende','date')
			->format('Y-m-d')
			->insertValue($finish_at)
			->showValue($finish_at)
			->rule('required');

		$duration = $edit->model->duration;
		$edit->add('dummy4','Dauer','text')
				->showValue($duration)
				->attributes(['readonly'=>'readonly']);

		$duein = $edit->model->duein;
		$edit->add('dummy5','Fällig','text')
				->showValue($duein)
				->attributes(['readonly'=>'readonly']);

		// Display Partner
		$edit->add('dummy1','Partner','text')
			->insertValue($partner?$partner:null)
			->updateValue($partner?$partner:null)
			->showValue($partner?$partner:null)
			->attributes(['readonly'=>'readonly']);

		// Display Object
		$edit->add('dummy2','Standort','text')
			->insertValue($object?$object:null)
			->updateValue($object?$object:null)
			->showValue($object?$object:null)
			->attributes(['readonly'=>'readonly']);

		$edit->saved(function() use ($edit){

			// Create a note for details
			if ($edit->status == 'create') {
				$text = isset($edit->fields['note'])?trim($edit->fields['note']->value):'';
				if (strlen($text) > 0) {
					$note = new Note(['text'=>$text]);
					$edit->model->notes()->save($note);
				}
			}

		});

	    return $edit->view('task', compact('edit'));

	}

}
