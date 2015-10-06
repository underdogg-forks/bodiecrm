<?php

namespace App\Http\Requests\LandingPage;

use Illuminate\Foundation\Http\FormRequest;

use App\Landing_Page;

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
        $landing_page    = Landing_Page::findOrFail($landing_page_id);

        // Check that user is part of campaign users
        return $landing_page
            ->first()
            ->campaign
            ->users
            ->contains(Auth::id()) ? true : false;
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
