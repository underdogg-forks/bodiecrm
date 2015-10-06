<?php

namespace App\Http\Requests\Campaign\Admin;

use Illuminate\Foundation\Http\FormRequest;

use Auth;
use App\Campaign;

class UpdateUsersRequest extends FormRequest
{
    
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        // URL route is implicitly defined as the resource
        $campaign_id = $this->route('campaigns');
        $campaign    = Campaign::findOrFail($campaign_id);

        return $campaign
            ->with('users')
                ->whereHas('users', function($q) {
                    $q->where('user_id', Auth::id())
                      ->where('role_id', config('roles.admin'));
                })
            ->exists();
    }

    /**
     * Custom validator to check role array
     * 
     * @param  Factory $factory
     * @return $object
     */
    public function validator($factory)
    { 
        $validation = $factory->make($this->all(), $this->rules());
        $validation->each('role', ['exists:roles,id']);

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
            'delete' => 'array',
            'role'   => 'array'
        ];
    }
}
