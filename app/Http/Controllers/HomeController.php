<?php namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Zofe\Rapyd\Facades\DataEdit;
use App\User;

class HomeController extends Controller {

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
	 * Show the application dashboard to the user.
	 *
	 * @return Response
	 */
	function index()
	{
		return view('home');
	}

	/**
	 * Show the application dashboard to the user.
	 *
	 * @return Response
	 */
	function getIndex()
	{
		return view('home');
	}

	function anyProfile(Request $request) {

		$id = $request->user()->id;
		if (

			$id != $request->get('modify') &&
			$id != $request->get('update') &&
			$id != $request->get('show') 
		
		) {
			throw new \Exception();
		} 

		else {

 			$edit = DataEdit::source(new User);

	   		$edit->add('name','Name','text')->rule('required');
	   		$edit->add('address1','Strasse Nr','text')->rule('required');
			$edit->add('address2','PLZ Ort','autocomplete')->rule('required')
				->remote("name","name",url('/01/ac/address2'));

	   		$edit->add('phone','Telefon','text');
	   		$edit->add('mobile','Mobil','text');

		  	$edit->add('photo','Foto', 'image')
				->move(User::BasePath.$id.'/photo/')
				->fit(1024, 1024)
				->preview(256,256);

		    return $edit->view('edit', compact('edit'));

		}

	}
}
