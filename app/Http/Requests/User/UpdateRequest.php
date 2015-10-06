<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;

use Auth;

class UpdateRequest extends FormRequest
{

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return ( Auth::id() == $this->route('user') ) ? true : false;
    }
   
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'first_name' => 'required|max:255',
            'last_name'  => 'required|max:255',
            'company'    => 'max:255',
            'email'      => 'required|email|max:255|unique:users,email,' . Auth::id(),
            'timezone'   => 'required'
        ];
    }
}
