<?php

/**
 * Request validation
 *
 * User must be an admin on the parent Campaign
 * 
 */

namespace App\Http\Requests\Lead\Admin;

use Illuminate\Foundation\Http\FormRequest;

use Auth;
use App\Lead;

class AddUsersRequest extends FormRequest
{
    
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $lead_id = $this->route('leads');
        $lead    = Lead::findOrFail($lead_id);

        return $lead
            ->first()
            ->campaign()
            ->with('users')
            ->whereHas('users', function($q) {
                $q->where('user_id', Auth::id())
                    ->where('role_id', config('roles.admin'));
            })
            ->exists();
    }

    /**
     * Custom validator to check email array
     * 
     * @param  Factory $factory
     * @return $object
     */
    public function validator($factory)
    { 
        $validation = $factory->make($this->all(), $this->rules()); 
        $validation->each('email', ['email', 'exists:users,email']);

        return $validation;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'email' => 'required|array'
        ];
    }
}
