<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Tag extends Model
{
	use SoftDeletes, HasFactory;

	protected $fillable = [
		'name',
		'description',
		'created_by',
		'updated_by',
		'updated_by_user_type',
		'deleted_by',
		'deleted_by_user_type',
	];

	protected static function booted()
	{
		static::creating(function($blogOperator) {
			$blogOperator->created_by = auth()->id();
			$blogOperator->updated_at = '0000-00-00 00:00:00';
		});

		static::updating(function($blogOperator) {
			$blogOperator->updated_by = auth()->id();
			$blogOperator->updated_by_user_type = session('userType');
		});
	}
}
