<?php
namespace App;

use Illuminate\Database\Eloquent\Model;
use Auth;
use Carbon\Carbon;
use DateTime;
use DB;

class Lead extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'leads';

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var Array
     */
    protected $dates = [
        'created_at',
        'updated_at',
        'converted_date',
        'closed_date'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'has_attribution' => 'boolean'
    ];

    /**
     * Get the campaign for this lead
     *
     * @return Collection
     */
    public function campaign()
    {
        return $this->landing_page->campaign->first();
    }

    /**
     * Get the landing page for this lead
     *
     * @return Collection
     */
    public function landing_page()
    {
        return $this->belongsTo('App\Landing_Page');
    }

    /**
     * Get the comments associated with this lead
     *
     * @return Collection
     */
    public function comments()
    {
        return $this->hasMany('App\Lead_Comments', 'lead_id', 'id');
    }

    /**
     * Get the attribution data associated to this lead
     *
     * @return Collection
     */
    public function attribution()
    {
        return $this->hasMany('App\Attribution');
    }

    /**
     * Get lead users
     *
     * @return Collection
     */
    public function users()
    {
        return $this->belongsToMany('App\User', 'leads_to_users', 'lead_id', 'user_id')->withPivot('type');
    }

    /**
     * Get activity log
     *
     * @return Collection
     */
    public function log()
    {
        return $this->hasMany('App\Lead_Log');
    }

    /**
     * Check whether user has admin access to this lead
     *
     * The user has to be an owner of the lead, or is an admin on the parent Campaing
     *
     * @return Boolean
     */
    public function hasAdminAccess()
    {
        // Check if user is admin on campaign
        $is_admin_for_campaign = $this
            ->campaign()
            ->with('users')
            ->whereHas('users', function ($q) {
                $q->where('user_id', Auth::id())
                    ->where('role_id', config('roles.admin'));
            })
            ->exists();
        // Check if user is owner of lead
        $is_owner_of_lead = $this
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
     * Set the lead's first name
     *
     * @param String $value
     */
    public function setFirstNameAttribute($value)
    {
        $this->attributes['first_name'] = ucfirst($value);
    }

    /**
     * Set the lead's last name
     *
     * @param String $value
     */
    public function setLastNameAttribute($value)
    {
        $this->attributes['last_name'] = ucfirst($value);
    }

    /**
     * Set the lead's title
     *
     * @param String $value
     */
    public function setTitleAttribute($value)
    {
        $this->attributes['title'] = ucfirst($value);
    }

    /**
     * Accessor to get fullname
     *
     * @param  String $value | null
     * @return String
     */
    public function getFullNameAttribute($value)
    {
        return $this->attributes['first_name'] . ' ' . $this->attributes['last_name'];
    }

    /**
     * Get Custom attribute
     *
     * @param  JSON $value
     * @return Array
     */
    public function getCustomAttribute($value)
    {
        if (!is_null($value)) {
            return json_decode($value);
        }
        return [];
    }
}