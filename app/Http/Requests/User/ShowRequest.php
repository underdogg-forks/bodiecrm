<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;

use Auth;

class ShowRequest extends FormRequest
{

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return ( Auth::id() == $this->route('user')) ? true : false;
    }
   
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [

        ];
    }
}
