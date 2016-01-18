<?php namespace App;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use Zizaco\Entrust\Traits\EntrustUserTrait;
use App\Geodata\LocatableTrait;
use App\Geodata\Zipcode;

class User extends Model implements AuthenticatableContract, CanResetPasswordContract {

	use Authenticatable;
	use CanResetPassword;
	use EntrustUserTrait;
	use LocatableTrait;
	use SoftDeletes;

	const BasePath = '../storage/User/';
	const NoPhoto = 'photo/nophoto.jpg';

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'users';

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = ['name', 'email', 'password'];

	/**
	 * The attributes excluded from the model's JSON form.
	 *
	 * @var array
	 */
	protected $hidden = ['password', 'remember_token'];


	function __toString() {
		return $this->name;
	}

	/**
     * Get Path to Photo
	 *
	 * @return string  path to users photo file
   	 */	 
	function getPhotoPathAttribute() 
	{

		$path = self::BasePath() ;

		if ($this->photo) {
			$path .= $this->id.'/photo/'.$this->photo;
		}

		else {
			$path .= self::NoPhoto;
		}

		return $path;
	}	

	/**
     * Real Path to User storage BasePath
     *
	 * @return string  BasePath  of user storage
   	 */	 
	static function BasePath() {
		return realpath(self::BasePath).'/' ; 
	}
}
