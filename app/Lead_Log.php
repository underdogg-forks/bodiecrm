<?php
namespace App;

use Illuminate\Database\Eloquent\Model;

class Lead_Log extends Model
{
    protected $table = 'leads_log';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'lead_id',
        'user_id',
        'activity'
    ];
}