<?php

namespace App\Http\Requests\Common;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StaffRequest extends FormRequest
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
			'first_name' => 'max:50',
			'last_name' => 'max:50',
			'phone_number' => 'max:30',
			'status' => 'required|in:Active,Inactive',
		];

		if($this->routeIs('blog-operator.staff.store')) {
			$rules += [
				'password' => 'required|min:8',
				'role' => 'required|array',
				'role.*' => 'integer|min:1',
			];

			$rules['email'] = [
				'bail',
				'required',
				'email',
				'max:50',
				Rule::unique('tour_operator_staff')->where(function($qry) {
					return $qry->where('deleted_by', 0);
				})
			];
		} else {
			$rules['email'] = [
				'bail',
				'required',
				'email',
				'max:50',
				Rule::unique('tour_operator_staff')->where(function($qry) {
					return $qry->where('deleted_by', 0)
						->where('id', '!=', $this->route()->parameter('id'));
				}),
			];

			if(request('password') !== '')
				$rules['password'] = 'min:8';
		}

		return $rules;
	}

	/**
	* Get custom attributes for validator errors.
	*
	* @return array
	*/
	public function attributes()
	{
		return [
			'email' => 'email address',
		];
	}
}
