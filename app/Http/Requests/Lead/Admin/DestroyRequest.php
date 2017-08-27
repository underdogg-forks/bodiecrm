<?php
/**
 * Request validation
 *
 * User must be owner of the lead
 *
 * OR
 *
 * User must be an admin on the parent Campaign
 */
namespace App\Http\Requests\Lead\Admin;

use App\Lead;
use Auth;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;

class DestroyRequest extends FormRequest
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
        // Check if user is admin on campaign
        $is_admin_for_campaign = $lead
            ->campaign()
            ->with('users')
            ->whereHas('users', function ($q) {
                $q->where('user_id', Auth::id())
                    ->where('role_id', config('roles.admin'));
            })
            ->exists();
        // Check if user is owner of lead
        $is_owner_of_lead = $lead
            ->users()
            ->wherePivot('type', 'owner')
            ->where('user_id', Auth::id())
            ->exists();
        if ($is_admin_for_campaign || $is_owner_of_lead) {
            return true;
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
        return [
            'fullname' => 'required'
        ];
    }
}