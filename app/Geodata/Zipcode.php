<?php namespace App\Geodata;

use Illuminate\Database\Eloquent\Model;

class Zipcode extends Model {

	protected $table = 'zipcode';

	public function city()
    	{
        	return $this->belongsTo('App\Geodata\City');
    	}

	public function district()
    	{
        	return $this->belongsTo('App\Geodata\District');
    	}
}
