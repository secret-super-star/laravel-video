<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

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
	    $nameValidation = '';
    	if (isset($this->oldname)) {
		    if ($this->oldname == $this->tag) {
			    $nameValidation = 'required';
		    } else {
			    $nameValidation = 'required|unique:tags,tag';
		    }
	    } else {
		    $nameValidation = 'required|unique:tags,tag';
	    }
	    return [
		    'tag' => $nameValidation
	    ];
    }
}
