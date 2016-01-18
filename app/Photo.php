<?php namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Noteable\NoteableTrait;
use Culpa\CreatedBy; 
use Culpa\UpdatedBy;
use Culpa\DeletedBy;
use App\Object;

class Photo extends Model {

	use NoteableTrait;
	use SoftDeletes;
	use CreatedBy; 
	use UpdatedBy;
	use DeletedBy;


	protected $table = 'photos';

	function object() 
	{
		return $this->belongsTo('App\Object','object_id');
	}

	function image() 
	{

	}
	/**
     * Get Path to Photo
	 *
	 * @return string  path to objects photo file
   	 */	 
	function getPathAttribute() 
	{

		$path = self::BasePath() ;

		if ($this->photo) {
			$path .= $this->object_id.'/photo/'.$this->photo;
		}

		else {
			throw new \Exception('Invalid photo path');
		}

		return $path;
	}	

	/**
     * Real Path to User storage BasePath
     *
	 * @return string  BasePath  of user storage
   	 */	 
	static function BasePath() {
		return realpath(Object::BasePath).'/' ; 
	}

}
