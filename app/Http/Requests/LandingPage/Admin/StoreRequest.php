<?php
namespace App\Http\Requests\LandingPage\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Auth;
use App\Landing_Page,
    App\Campaign;
use Illuminate\Http\Request;

class StoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        // URL route is implicitly defined as the resource
        $landing_page_id = $this->route('landing_pages');
        $campaign_id = Landing_Page::findOrFail($landing_page_id)->first()->campaign->id;
        return Campaign::where('id', $campaign_id)
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
        $landing_page_id = $this->route('landing_pages');
        $campaign_id = Landing_Page::where('id', $landing_page_id)->first()->campaign->id;
        // Validate email users are part of campaign
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
            'add_user' => 'array',
            'send_email' => 'boolean',
            'email_to' => 'string',
            'email_title' => 'string',
            'add_user_email_notification' => 'array'
        ];
    }
}
