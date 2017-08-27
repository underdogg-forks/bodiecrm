<?php
namespace App\Http\Requests\LandingPage;

use Illuminate\Http\Request;
use Illuminate\Foundation\Http\FormRequest;
use App\Landing_Page;
use Auth;

class ShowAuthKeyRequest extends FormRequest
{

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(Request $request)
    {
        // URL route is implicitly defined as the resource
        $landing_page_id = $request->get('id');
        $landing_page = Landing_Page::findOrFail($landing_page_id);
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
