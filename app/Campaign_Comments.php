<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Campaign_Comments extends Model
{

    protected $table = 'campaigns_comments';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id', 
        'campaign_id', 
        'comment'
    ];

    /**
     * Get the user that this comment belongs to
     * 
     * @return Object
     */
    public function user()
    {
        return $this->belongsTo('App\User');
    }

    /**
     * Get the campaign that this comment belongs to
     * 
     * @return Object
     */
    public function campaign()
    {
        return $this->belongsTo('App\Campaign');
    }
}
