<?php
namespace App;

use Illuminate\Database\Eloquent\Model;

class Lead_Comments extends Model
{
    protected $table = 'leads_comments';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'lead_id',
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
    public function lead()
    {
        return $this->belongsTo('App\Lead');
    }
}
