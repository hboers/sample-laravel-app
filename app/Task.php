<?php namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Noteable\NoteableTrait;
use Culpa\BlameableObserver;
use Culpa\CreatedBy; 
use Culpa\UpdatedBy;
use Culpa\DeletedBy;

class Task extends Model {

	use NoteableTrait;
	use SoftDeletes;
	use CreatedBy; 
	use UpdatedBy;
	use DeletedBy;

	protected $blameable = array('created', 'updated', 'deleted');

	protected $table = 'tasks';

	function partner() {
		return $this->belongsTo('App\Partner','partner_id');
	}

	function object() {
		return $this->belongsTo('App\Object','object_id');
	}

	function assignedTo() {
		return $this->belongsTo('App\User','assigned_to');
	}

	function getDueinAttribute() {
		$finish = new \DateTime($this->finish_at);
		$begin = new \DateTime(date('Y-m-d'));
		$interval = $begin->diff($finish);
		return $interval->format('%R%a Tage');
	}

	function getDurationAttribute() {
		$finish = new \DateTime($this->finish_at);
		$begin = new \DateTime($this->begin_at);
		$interval = $begin->diff($finish);
		return $interval->format('%R%a Tage');
	}

	function getIsAssignedAttribute() {
		return $this->assigned_to instanceOf App\User;
	}

	function getfinishDateAttribute() {
		return date('Y-m-d',strtotime($this->finish_at));
	}

	function getbeginDateAttribute() {
		return date('Y-m-d',strtotime($this->begin_at));
	}

	function __toString() {
		return $this->name;
	}

}
Task::observe(new BlameableObserver);
