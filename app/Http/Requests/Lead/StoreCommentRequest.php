<?php

namespace App\Http\Requests\Lead;

use Illuminate\Foundation\Http\FormRequest;

use App\Lead;

use Auth;

class StoreCommentRequest extends FormRequest
{
    
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $lead_id    = $this->route('leads');
        $lead       = Lead::findOrFail($lead_id);

        return $lead
            ->first()
            ->campaign()
            ->users
            ->contains(Auth::id());
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [];
        
        return [
            'comment'   => 'required'
        ];
    }
}
