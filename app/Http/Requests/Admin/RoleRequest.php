<?php

namespace App\Http\Requests\Admin;

use App\Rules\NonExponential;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class RoleRequest extends FormRequest
{
	/**
	* Determine if the user is authorized to make this request.
	*
	* @return bool
	*/
	public function authorize()
	{
		return (session('userType') == 'Admin');
	}

	/**
	* Get the validation rules that apply to the request.
	*
	* @return array
	*/
	public function rules()
	{
		$rules = [
			'display_order' => [
				'required',
				'numeric',
				'integer',
				'between:0,255',
				new NonExponential,
			],
			'status' => 'required|in:Active,Inactive',
		];


		if($this->routeIs('admin.role.store'))
			$rules['name'] = 'bail|required|max:30|unique:roles';
		else {
			$rules['name'] = [
				'bail',
				'required',
				'max:30',
				Rule::unique('roles')->ignore($this->route()->parameter('role'))
			];
		}

		return $rules;
	}

	/**
	* Get the error messages for the defined validation rules.
	*
	* @return array
	*/
	public function messages()
	{
		return [
			'name.unique' => 'This role is already added.',
		];
	}
}
