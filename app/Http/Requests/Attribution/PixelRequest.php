<?php
namespace App\Http\Requests\Attribution;

use App\Attribution;
use Auth;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;

class PixelRequest extends FormRequest
{

    public function __construct()
    {
        // Set the redirect URL if validation fails
        $this->redirect = url();
    }

    /**
     * Determine if the user is authorized to make this request.
     *
     * @param  Request $request
     * @return bool
     */
    public function authorize(Request $request)
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(Request $request)
    {
        $landing_page_id = $request->get('lp');
        return [
            'lp' => 'required|integer|exists:landing_pages,id',        // landing page id
            'ak' => 'required|string|exists:landing_pages,auth_key,id,' . $landing_page_id,    // authentication key
            'em' => 'required|email',          // email
            't' => 'integer',                 // tracking id,
            'cs' => 'string',                  // converting source
            'cm' => 'string',                  // converting medium
            'ck' => 'string',                  // converting keyword
            'ccn' => 'string',                  // converting content
            'cc' => 'string',                  // converting campaign
            'cl' => 'url',                     // converting landing page
            'ct' => 'integer',                 // converting date
            'os' => 'string',                  // original source
            'om' => 'string',                  // original medium
            'ok' => 'string',                  // original keyword
            'ocn' => 'string',                  // original content
            'oc' => 'string',                  // original campaign
            'ol' => 'url',                     // original landing page
            'ot' => 'integer',                 // original date
            'r' => 'url'                      // refer url
        ];
    }
}
