<?php

namespace App;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;

use Auth;

class User extends Model implements AuthenticatableContract, CanResetPasswordContract {
    use Authenticatable, CanResetPassword;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'users';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'first_name', 
        'last_name', 
        'company', 
        'email', 
        'password'
    ];


    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [
        'password', 
        'remember_token', 
        'verified', 
        'active'
    ];





    /**
     * Get the campaigns associated to this user
     *
     * Checks if user has any role permissions on the campaign
     * 
     * @return Collection
     */
    public function campaigns()
    {
        return $this->belongsToMany('App\Campaign', 'user_has_roles', 'user_id', 'campaign_id');
    }

    /**
     * Get the active landing pages associated to this user
     * 
     * @return Collection
     */
    public function landing_pages_active()
    {
        $campaigns      = Auth::user()
            ->campaigns()
            ->where('active', 1)
            ->with(['landing_pages' => function($q) {
                $q->orderBy('created_at', 'DESC');
            }])
            ->get();

        $landing_pages  = collect();

        // Get active landing pages
        foreach ( $campaigns as $campaign ) {
            $landing_pages = $landing_pages->merge($campaign->landing_pages()->where('active', 1)->get());
        }

        return $landing_pages;
    }

    /**
     * Get the archived landing pages associated to this user
     * 
     * @return Collection
     */
    public function landing_pages_archived()
    {
        $campaigns      = Auth::user()
            ->campaigns()
            ->where('active', 0)
            ->with(['landing_pages' => function($q) {
                $q->orderBy('created_at', 'DESC');
            }])
            ->get();

        $landing_pages  = collect();

        foreach ( $campaigns as $campaign ) {
            $landing_pages = $landing_pages->merge($campaign->landing_pages);
        }

        return $landing_pages;
    }

    /**
     * Get all user leads
     * 
     * @return Collection
     */
    public function all_leads()
    {
        $landing_pages  = Auth::user()
            ->landing_pages();

        $leads          = collect();

        foreach ( $landing_pages as $landing_page ) {
            $leads = $leads->merge($landing_page->leads);
        }

        return $leads;
    }

    /**
     * Get leads where user is owner
     * 
     * @return Collection
     */
    public function your_leads()
    {
        return $this->belongsToMany('App\Lead', 'leads_to_users', 'user_id', 'lead_id');
    }

    /**
     * Get the roles associated to this user
     * 
     * @return Collection
     */
    public function roles()
    {
        return $this->belongsToMany('App\Role', 'user_has_roles', 'user_id', 'role_id');
    }


    /**
     * Get the campaign comments associated to this user
     * 
     * @return Collection
     */
    public function campaign_comments()
    {
        return $this->hasMany('App\Campaign_Comments', 'user_id', 'id');
    }


    /*************
     * Accessors
     *************/

    /**
     * Get user first name
     * 
     * @param  String $title
     * @return String
     */
    public function getFirstNameAttribute($first_name)
    {
        return ucwords($first_name);
    }

    /**
     * Get user last name
     * 
     * @param  String $title
     * @return String
     */
    public function getLastNameAttribute($last_name)
    {
        return ucwords($last_name);
    }

    /**
     * Accessor to get fullname
     * 
     * @param  String $value | null
     * @return String
     */
    public function getFullNameAttribute($value)
    {
        return ucwords($this->attributes['first_name']) . ' ' . ucwords($this->attributes['last_name']);
    }
}
