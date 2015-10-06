<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    protected $table = 'comments';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'landing_page_id', 
        'lead_id', 
        'user_id', 
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
     * Get the landing page that this comment belongs to
     * 
     * @return Object
     */
    public function landing_page()
    {
        return $this->belongsTo('App\Landing_Page');
    }

    /**
     * Get the lead that this comment belongs to
     * 
     * @return Object
     */
    public function lead()
    {
        return $this->belongsTo('App\Lead');
    }
}
