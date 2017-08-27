<?php
namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use DB;
use Auth;
use App\Lead;

class Landing_Page extends Model
{

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'landing_pages';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'campaign_id',
        'title',
        'description',
        'return_url',
        'auth_key',
        'active',
        'send_email',
        'email_to',
        'email_title'
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
        'active' => 'boolean',
        'send_email' => 'boolean',
        'email_to' => 'array'
    ];

    /**
     * Get the campaign associated with this landing page
     *
     * @return Object
     */
    public function campaign()
    {
        return $this->belongsTo('App\Campaign');
    }

    /**
     * Get the leads associated with this landing page
     *
     * @return Object
     */
    public function leads()
    {
        return $this->hasMany('App\Lead', 'landing_page_id', 'id');
    }

    /**
     * Get users to email for this landing page
     *
     * @return Object
     */
    public function users_to_email()
    {
        return $this->belongsToMany('App\User', 'users_to_landing_page_email', 'landing_page_id', 'user_id');
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
     * Get the comments associated with this landing page
     *
     * @return Object
     */
    public function comments()
    {
        return $this->hasMany('App\Landing_Page_Comments', 'landing_page_id', 'id');
    }

    /**
     * Get leads
     *
     * @param  String $length
     * @return Collection
     */
    public function getLeads($length)
    {
        $landing_pages = [$this->id];
        $lists = collect();
        $date = ($length == 'month') ?
            Carbon::today()->subMonth() :
            Carbon::today()->subWeek();
        $leads = Lead::select(
            array(
                'created_at',
                DB::raw('COUNT(*) AS count')
            ))
            ->where('created_at', '>', $date)
            ->whereIn('landing_page_id', $landing_pages)
            ->groupBy('created_at')
            ->orderBy('created_at', 'DESC')
            ->get();
        if (!$leads->isEmpty()) {
            // Can't use lists() as it destroys date Carbon object
            foreach ($leads as $lead) {
                $d = $lead->created_at->timezone(Auth::user()->timezone)->toDateString();
                if ($lists->has($d)) {
                    $lists[$d] += $lead->count;
                } else {
                    $lists[$d] = $lead->count;
                }
            }
            return $lists;
        }
        return collect();
    }

    /**
     * Check whether user is admin for this landing page's campaign
     *
     * @return Boolean
     */
    public function isAdmin()
    {
        if ($this->campaign->users()->where('user_id', Auth::id())->first()->pivot->role_id == config('roles.admin')) {
            return true;
        }
        return false;
    }

    /**
     * Get the landing page title
     *
     * @param  String $title
     * @return String
     */
    public function getTitleAttribute($title)
    {
        return ucwords($title);
    }
}
