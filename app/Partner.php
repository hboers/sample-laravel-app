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

class Partner extends Model {

	use LocatableTrait;
	use NoteableTrait;
	use SoftDeletes;
	use CreatedBy; 
	use UpdatedBy;
	use DeletedBy;

	protected $blameable = array('created', 'updated', 'deleted');

	protected $table = 'partners';

	/**
	 *
	 */
	function objects()
	{
	  return $this->hasMany('App\Object','partner_id');
	}

	/**
	 *
	 */
	function __toString() {
		return $this->name;
	}
}                          
Partner::observe(new BlameableObserver);
