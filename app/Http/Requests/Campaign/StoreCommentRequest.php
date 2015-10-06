<?php

namespace App\Http\Requests\Campaign;

use Illuminate\Foundation\Http\FormRequest;
use App\Campaign;
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
        // URL route is implicitly defined as the resource
        $campaign_id    = $this->route('campaigns');
        $campaign       = Campaign::findOrFail($campaign_id);

        return $campaign
            ->with('users')
            ->whereHas('users', function($q) {
                $q->where('user_id', Auth::id());
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
        return [
            'comment'   => 'required'
        ];
    }
}
