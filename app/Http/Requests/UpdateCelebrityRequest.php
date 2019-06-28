<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCelebrityRequest extends FormRequest
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
	    if($this->name != Auth::user()->name) {
		    $uniqueUser = 'unique:celebrities';
	    } else {
		    $uniqueUser = '';
	    }
	    return [
		    'name' => 'required|max:255|'.$uniqueUser,
	    ];
    }
}
