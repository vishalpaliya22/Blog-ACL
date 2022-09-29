<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\CanResetPassword;
use App\Notifications\LinkForResettingPassword;

class Admin extends Authenticatable implements CanResetPassword
{
	use SoftDeletes, HasFactory, Notifiable;

	protected $guard = 'admin';
	protected $table = 'admins';

	protected $fillable = [
		'name',
		'email',
		'password',
		'status',
		'created_by',
		'updated_by',
		'deleted_by',
	];

	protected $hidden = [
		'password',
		'remember_token',
	];

	/**
	* The "booted" method of the model.
	*
	* @return void
	*/
	protected static function booted()
	{
		static::creating(function($adminUser) {
			$adminUser->password = \Hash::make($adminUser->password);
			$adminUser->created_by = auth()->id();
// have to set updated_at to db's default value
// because laravel is setting it when inserting record if it is NOT NULL column
			$adminUser->updated_at = '0000-00-00 00:00:00';
		});

		static::updating(function($adminUser) {
			if(!empty(request('password')))
				$adminUser->password = \Hash::make(request('password'));

			$adminUser->updated_by = auth()->id();
		});

	}

	public function sendPasswordResetNotification($token)
	{
		$this->notify(new LinkForResettingPassword($token));
	}
}
