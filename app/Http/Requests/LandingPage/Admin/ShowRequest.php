<?php

namespace App\Http\Requests\LandingPage\Admin;

use Illuminate\Foundation\Http\FormRequest;

use App\Landing_Page,
    App\Campaign;

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
        // URL route is implicitly defined as the resource
        $landing_page_id = $this->route('landing_pages');
        
        $campaign_id     = Landing_Page::findOrFail($landing_page_id)->first()->campaign->id;
        
        return Campaign::where('id', $campaign_id)
            ->with('users')
            ->whereHas('users', function($q) {
                $q->where('user_id', Auth::id())
                    ->where('role_id', config('roles.admin'));
            })
            ->exists();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [];
    }
}