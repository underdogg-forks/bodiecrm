<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use Carbon\Carbon;
use DB;
use Auth;

use App\Lead;

class Campaign extends Model {

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'campaigns';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id', 
        'title', 
        'description', 
        'active'
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [];



    /**
     * Casts
     * 
     * @var array
     */
    protected $casts = [
        'active'    => 'boolean'
    ];






    /**
     * Get the landing pages associated with this campaign
     * 
     * @return Object
     */
    public function landing_pages()
    {
        return $this->hasMany('App\Landing_Page');
    }

    /**
     * Get user owner
     * 
     * @return Object
     */
    public function user()
    {
        return $this->belongsTo('App\User');
    }
    
    /**
     * Get the leads associated with this landing page
     * 
     * @return Object
     */
    public function users()
    {
        return $this->belongsToMany('App\User', 'user_has_roles', 'campaign_id', 'user_id')->withPivot('role_id');
    }

    /**
     * Get campaign leads through landing pages
     * 
     * @return Object
     */
    public function leads()
    {
        return $this->hasManyThrough('App\Lead', 'App\Landing_Page', 'campaign_id', 'landing_page_id');
    }

    /**
     * Get the comments associated with this landing page
     * 
     * @return Object
     */
    public function comments()
    {
        return $this->hasMany('App\Campaign_Comments', 'campaign_id', 'id');
    }





    /**
     * Check whether user is admin for this campaign
     * 
     * @return Boolean
     */
    public function isAdmin()
    {
        if ( $this->users()->where('user_id', Auth::id())->first()->pivot->role_id == config('roles.admin') ) {
            return true;
        }

        return false;
    }


    /**
     * Get leads
     * 
     * @param  String $length
     * @return Collection
     */
    public function getLeads($length)
    {
        $landing_pages = $this->landing_pages()->lists('id');
        $lists         = collect();
        
        $date          = ( $length == 'month' ) ?
            Carbon::today()->subMonth() :
            Carbon::today()->subWeek();

        $leads         = Lead::select(
            array(
                'created_at',
                DB::raw('COUNT(*) AS count')
            ))
            ->where('created_at', '>', $date)
            ->whereIn('landing_page_id', $landing_pages)
            ->groupBy('created_at')
            ->orderBy('created_at', 'DESC')
            ->get();

        if ( ! $leads->isEmpty() ) {

            // Can't use lists() as it destroys date Carbon object
            foreach ( $leads as $lead ) {
                $d = $lead->created_at->timezone(Auth::user()->timezone)->toDateString();

                if ( $lists->has($d) ) {
                    $lists[$d] += $lead->count;    
                }
                else {
                    $lists[$d] = $lead->count;
                }
            }

            return $lists;
        }

        return collect();
    }
}