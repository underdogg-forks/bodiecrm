<?php
namespace App\Http\Requests\Campaign\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Auth;
use App\Campaign;

class StoreLandingPageRequest extends FormRequest
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
        $campaign = Campaign::findOrFail($campaign_id);
        return $campaign
            ->with('users')
            ->whereHas('users', function ($q) {
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
        $campaign_id = $this->route('campaigns');
        $validation = $factory->make($this->all(), $this->rules());
        $validation->each('add_user_email_notification', ['exists:user_has_roles,user_id,campaign_id,' . $campaign_id]);
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
            'title' => 'required|max:100',
            'description' => 'string',
            'return_url' => 'required|url',
            'send_email' => 'boolean',
            'email_to' => 'string',
            'email_title' => 'string',
            'add_user_email_notification' => 'array'
        ];
    }
}
