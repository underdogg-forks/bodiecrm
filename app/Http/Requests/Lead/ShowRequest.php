<?php
namespace App\Http\Requests\Lead;

use App\Lead;
use Auth;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;

class ShowRequest extends FormRequest
{

    /**
     * Determine if the user is authorized to make this request.
     *
     * @param  Request $request
     * @return bool
     */
    public function authorize()
    {
        $lead_id = $this->route('leads');
        $lead = Lead::findOrFail($lead_id);
        if (!is_null($lead)) {
            return $lead
                ->first()
                ->campaign()
                ->users
                ->contains(Auth::id());
        }
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(Request $request)
    {
        return [];
    }
}
