<?php
namespace App;

use Illuminate\Database\Eloquent\Model;

class Landing_Page_Comments extends Model
{
    protected $table = 'landing_page_comments';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'landing_page_id',
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
}
