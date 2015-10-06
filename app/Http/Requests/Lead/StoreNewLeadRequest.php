<?php

namespace App\Http\Requests\Lead;

use App\Landing_Page;
use Auth;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;

class StoreNewLeadRequest extends FormRequest
{
    
    /**
     * Determine if the user is authorized to make this request.
     *
     * @param  Request $request
     * @return bool
     */
    public function authorize(Request $request)
    {
        $landing_page_id = $request->get('landing_page_id');
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
    public function rules(Request $request)
    {
        $landing_page_id = $request->get('landing_page_id');

        return [
            'landing_page_id'         => 'required|integer|exists:landing_pages,id',
            'auth_key'                => 'required|string|exists:landing_pages,auth_key,id,' . $landing_page_id,
            'email'                   => 'email'
        ];
    }
}
