<?php namespace App\Noteable;

use Illuminate\Http\Request;
use Zofe\Rapyd\Facades\DataEdit;
use App\Noteable\Note;

trait NoteableControllerTrait 
{

	/**
	 *
	 * return @string  current Controller class 
	 */
	private static function controller() {

		$parts = array_reverse(explode('\\',__CLASS__));

		if (isset($parts[0])) {
			return $parts[0];
		}

		else {
			// TODO Better error handling
			throw new \Exception('Invalid Name Convention');
		}
	}


	/**
	 *
	 * return @string  current Controller class 
	 */
	private static function model() {
		return 'App\\'.str_replace('Controller','',self::controller());
	}


	/**
	 *
	 * return @string  base route
	 */
	private static function base($noteable) 
	{

		$parts = array_reverse(explode('\\',get_class($noteable)));

		if (isset($parts[0])) {
			return '/'.strtolower($parts[0]);
		}

		else {

			// TODO Better error handling
			throw new \Exception('Invalid Route');
		}
	}

	/**
	 *
	 * return @string  back route
	 */
	private static function back($noteable) 
	{
		return self::base($noteable).'/edit?show='.$noteable->id;
	}

	/**
	 * Edit a note
	 */
	function anyNote(Request $request) 
	{

		$noteable = null;

		// deletion of note
		if ($request->has('do_delete')) {

			$note = Note::find($request->get('do_delete'));
			if ($note instanceOf Note) {

				$back = self::back($note->noteable);
				$note->delete();

				return redirect($back);	
			}

			else {
				// TODO Find Better handling
				throw new \Exception('Invalid delete note call');
			}
		}

		$edit = DataEdit::source(new Note);

	    // Create a new node for a noteable class
		if ($edit->status == 'create') {
			if ($request->has('noteable_id')) {
			
				$Noteable = self::model();

				$noteable = $Noteable::find($request->get('noteable_id'));
			
				if ($noteable instanceOf $Noteable) {
					$edit->model->noteable_id = $noteable->id;
					$edit->model->noteable_type = $Noteable;

				}

				// Class not found
				else {
				
					throw new \Exception('Invalid create note call');
				}

			}	

			// on create noteable_id ist required
			else {
				throw new \Exception('Invalid create note call');
			}
		}


		// all other status have noteable in model 
		else {

			$noteable = $edit->model->noteable;

		}

		// This is not working as expected in Rapyd, if necessay patch rapyd
		//$edit->back('insert|update',self::base($noteable).'/edit?show='.$noteable->id);

		//TODO $edit->add('note','Notiz', 'redactor')
		$edit->add('text','Notiz', 'textarea')
			->attributes(['class'=>'autofocus'])
			->rule('required|min:2');


		$about = (string) $noteable;
		$edit->add('dummy','zu','text') 
			->attributes(['readonly'=>'readonly']) 
			->showValue($about) 
			->updateValue($about) 
			->insertValue($about); 
 
		$edit->saved(function() use ($noteable) {
				return redirect(self::base($noteable).'/edit?show='.$noteable->id);
		});


    	return $edit->view('edit', compact('edit'));

	}

}

