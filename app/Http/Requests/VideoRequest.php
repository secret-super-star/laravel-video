<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class VideoRequest extends FormRequest
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
	{   // ahsan hussain
		// ahsan hussain mughal


		$nameValidation = '';
		if ($this->method() == 'POST') {
			$link = preg_replace('/[^a-zA-Z0-9]+/', ' ', $this->name);
			if ($this->oldname == $this->name) {
				$nameValidation = 'required';
			} else {
				$nameValidation = 'required|unique:series,link,' . $link;
			}
		} else {
			$nameValidation = 'required|unique:series,name';
		}
		return [
			'name' => $nameValidation,
			'description' => 'required',
			'category' => 'required',
			'tags' => 'required',
		];
	}

}
