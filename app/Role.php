<?php
namespace App;

use Illuminate\Database\Eloquent\Model;
use Auth;

class Role extends Model
{

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'roles';

    // Accessors
    /**
     * Get the role title
     *
     * @param  String $title
     * @return String
     */
    public function getTitleAttribute($title)
    {
        return ucwords($title);
    }
}