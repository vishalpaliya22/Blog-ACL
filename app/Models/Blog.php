<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Blog extends Model
{
	use SoftDeletes, HasFactory;

	protected $fillable = [
		'name',
		'short_description',
		'long_description',
		'tag',
		'status',
		'created_by',
		'created_by_user_type',
		'updated_by',
		'updated_by_user_type',
		'deleted_by',
		'deleted_by_user_type',
	];

	public static function fillableFields()
	{
		return (new self)->fillable;
	}

	protected static function booted()
	{
		static::creating(function($tourPackage) {
			 
			$tourPackage->created_by = auth()->id();
			$tourPackage->created_by_user_type = session('userType');
			$tourPackage->tag = fromTagifyToDb($tourPackage->tag);
			$tourPackage->updated_at = '0000-00-00 00:00:00';
		});

		static::retrieved(function($tourPackage) {
			$tourPackage->tag = fromDbToTagify($tourPackage->tag);
		});
	}

	/*protected function serializeDate(\DateTimeInterface $date)
	{
		return $date->format('Y-m-d H:i:s');
	}*/
}
