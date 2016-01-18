<?php namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Geodata\Zipcode;
use App\Autocomplete\Address2;

class AutocompleteController extends Controller {

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
     * Return Address2 Data as Json   
     *
	 * @return JSON	
	 */	
    function getAddress2 ( Request $request ) 
    {
        $query = $request->get("q");

        if (is_numeric($query)) {
            return Address2::where("name","like", $request->get("q")."%")->take(10)->get();
        } 

        else {
            return Address2::where("name","like", "%".$request->get("q")."%")->take(10)->get();
        }
    }

}
