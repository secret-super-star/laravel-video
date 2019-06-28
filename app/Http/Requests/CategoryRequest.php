<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CategoryRequest extends FormRequest
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
			    $nameValidation = 'required|unique:categories,category_title';
		    }
	    } else {
		    $nameValidation = 'required|unique:categories,category_title';
	    }
	    return [
		    'category_title' => $nameValidation
	    ];
    }
}
