<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\CanResetPassword;
use App\Notifications\LinkForResettingPassword;

class Staff extends Authenticatable implements CanResetPassword
{
	use SoftDeletes, HasFactory, Notifiable;

	protected $guard = 'tour_operator_staff';
	protected $table = 'tour_operator_staff';
	protected $appends = [ 'name' ];

	protected $fillable = [
		'first_name',
		'last_name',
		'email',
		'password',
		'phone_number',
		'status',
		'created_by',
		'created_by_user_type',
		'updated_by',
		'updated_by_user_type',
		'deleted_by',
		'deleted_by_user_type',
	];

	protected $hidden = [
		'password',
		'remember_token',
	];

	public function getNameAttribute()
	{
		return $this->first_name . ' ' . $this->last_name;
	}

	protected static function booted()
	{
		static::creating(function($staff) {
			$staff->created_by = auth()->id();
			$staff->created_by_user_type = session('userType');
			$staff->password = \Hash::make($staff->password);
			$staff->updated_at = '0000-00-00 00:00:00';
		});

		static::updating(function($staff) {
			if(!empty(request('password')))
				$staff->password = \Hash::make(request('password'));
			
			$staff->updated_by = auth()->id();
			$staff->updated_by_user_type = session('userType');
		});
	}
}
