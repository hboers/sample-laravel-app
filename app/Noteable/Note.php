<?php namespace App\Noteable;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use Culpa\BlameableObserver;
use Culpa\CreatedBy; 
use Culpa\UpdatedBy;
use Culpa\DeletedBy;

class Note extends Model {

	use SoftDeletes;
	use CreatedBy; 
	use UpdatedBy;
	use DeletedBy;

	protected $table = 'notes';

	protected $fillable = ['text'];

    function noteable()
	{
	       return $this->morphTo();
	}

}
Note::observe(new BlameableObserver);
