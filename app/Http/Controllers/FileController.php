<?php namespace App\Http\Controllers;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Symfony\Component\HttpFoundation\File\File as Mime;
use Illuminate\Http\Request;
use App\User;
use App\Photo;

class FileController  extends Controller {

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
     * Get profile photo of user
     */
    function getPp( Request $request ) {
        
        $user = User::find($request->get('id'));

        if ($user instanceOf User) {
            return self::respond($user->photo_path);
        } 
        
        else {
            throw new \Exception();
        }


    }
    
    /**
     * Get profile photo of user
     */
    function getOp( Request $request ) {
        
        $photo = Photo::find($request->get('id'));

        if ($photo instanceOf Photo) {
            return self::respond($photo->path);
        } 
        
        else {
            throw new \Exception();
        }

    }
    
    private static function respond($path)
    {
        $mime = new Mime($path);
        return response()->make(  File::get($path) )
            ->header( 'Content-type', $mime->getMimeType());
    }


}
