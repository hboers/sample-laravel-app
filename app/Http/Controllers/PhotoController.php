<?php namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Zofe\Rapyd\Facades\DataEdit;
use Zofe\Rapyd\Facades\DataSet;
use Zofe\Rapyd\Facades\DataFilter;
use Khill\Fontawesome\FontAwesomeFacade as FA;
use App\Noteable\NoteableControllerTrait;
use App\Photo;
use App\Object;
use App\Noteable\Note;

class PhotoController extends Controller {

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
	 	$set = DataSet::source(Photo::with('Object'));  

	 	$set->link(url('/photo/edit'), '','show'); 
	   	$set->link(url('/photo/edit'),"anlegen", "TR"); 

	    $set->paginate(10); 
		$set->build();

	  	return view('set.photo', compact('set'));
	}

	function anyEdit(Request $request) {

		$object = null;

		$edit = DataEdit::source(new Photo);


		if ($edit->status == 'show') {
			$edit->link(url('/photo/note?noteable_id='.$edit->model->id),'notiz anlegen','BR');
		}

		// Add Object reference
		if ($request->has('object_id')) {

			$object =  Object::find($request->get('object_id'));
			if ($object instanceOf Object) {
				$edit->model->object_id = $object->id;
			}

			else {
				throw new \Exception("Invalid call to create photo");
			}

		} 
		
		else {
			$object = $edit->model->object;
		}


		$edit->link(url('/object/edit?show='.$object->id),'abbrechen','TR')->back();

		$edit->add('photo','Foto', 'image')
			->move(Object::BasePath.$object->id.'/photo/')
			->fit(1024, 1024)
			->preview(256,256);

		$edit->add('dummy1','Standort','text')
			->insertValue($object?$object:null)
			->updateValue($object?$object:null)
			->showValue($object?$object:null)
			->attributes(['readonly'=>'readonly']);

	    return $edit->view('edit.photo', compact('edit'));

	}

}
