<?php

namespace App\Http\Requests\Common;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class BlogRequest extends FormRequest
{
	/**
	* Determine if the user is authorized to make this request.
	*
	* @return bool
	*/
	public function authorize()
	{
		return true;
	}

	/**
	* Get the validation rules that apply to the request.
	*
	* @return array
	*/
	public function rules()
	{
		$rules = [
			'name' => 'required|min:0|max:100',
			'status' => 'required|in:Active,Inactive',
		];

		if($this->routeIs('blog.store')) {
			$rules += [
				'name' => [
					'bail',
					'required',
					'max:100',
					Rule::unique('tour_packages')->where(function($qry) {
						return $qry->where('deleted_by', 0);
					}),
				],
				'photos' => 'array',
				'photos.*' => 'image',
			];
		} else { // edit-update
			$t = $this;

			$rules += [
				'name' => [
					'bail',
					'required',
					'max:100',
					Rule::unique('tour_packages')->where(function($qry) use($t) {
						return $qry->where('deleted_by', 0)
							->where('id', '!=', $t->route()->parameter('id'));
					}),
				],
			];
		}

		return $rules;
	}
}
