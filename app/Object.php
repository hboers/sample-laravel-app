<?php namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Noteable\NoteableTrait;
use App\Geodata\LocatableTrait;
use App\Geodata\Zipcode;
use Culpa\BlameableObserver;
use Culpa\CreatedBy; 
use Culpa\UpdatedBy;
use Culpa\DeletedBy;

class Object extends Model {

	use LocatableTrait;
	use NoteableTrait;
	use SoftDeletes;
	use CreatedBy; 
	use UpdatedBy;
	use DeletedBy;

	protected $blameable = array('created', 'updated', 'deleted');

	protected $table = 'objects';

	const BasePath = '../storage/Object/';


    /**
     * List of photos
     */
    function photos()
   	{
      	return $this->hasMany('App\Photo','object_id');
   	}

	/**
	/**
     * Connect to Partner
     */
    function partner()
   	{
      	return $this->belongsTo('App\Partner');
   	}

	/**
     * Connect to Zipcode
     */
    function zipcode()
   	{
      	return $this->belongsTo('App\Geodata\Zipcode');
   	}

	/**
	 *
	 */
	function __toString() {
		return $this->name;
	}

}
Object::observe(new BlameableObserver);
