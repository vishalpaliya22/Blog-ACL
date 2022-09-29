<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class TagRequest extends FormRequest
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
			'name' => 'required',
		];

		if($this->routeIs('admin.tag.store')) {
			$rules['name'] = 'bail|required|max:100|unique:tags';
			
		} else { // edit-update
			$rules['name'] = [
				'bail',
				'required',
				'max:100',
				Rule::unique('tags')->ignore($this->route()->parameter('id')),
			];
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
			'name' => 'name added',
		];
	}
}
