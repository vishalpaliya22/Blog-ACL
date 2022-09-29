<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class AdminUserRequest extends FormRequest
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
			'name' => 'required:max:50',
			'password' => 'min:8',
			'status' => 'required|in:Active,Inactive',
		];

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
			'password' => 'The password must be at least 8 characters',
		];
	}
}
