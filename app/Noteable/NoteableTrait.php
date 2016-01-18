<?php namespace App\Noteable;

trait NoteableTrait {

	function notes()
	{
		return $this->morphMany('App\Noteable\Note', 'noteable');
	}

}

