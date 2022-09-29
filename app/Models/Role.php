<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Role extends Model
{
	use SoftDeletes, HasFactory;

	protected $table = 'roles';

	protected $fillable = [
		'name',
		'display_order',
		'status',
		'created_by',
		'updated_by',
		'deleted_by',
	];

	protected static function booted()
	{
		static::creating(function($country) {
			$country->created_by = auth()->id();
			$country->updated_at = '0000-00-00 00:00:00';
		});

		static::updating(function($country) {
			$country->updated_by = auth()->id();
		});
	}
}
