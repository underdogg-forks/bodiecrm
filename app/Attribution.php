<?php
namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;

class Attribution extends Model
{

    /**
     * The database table used by the model.
     *
     * @var String
     */
    protected $table = 'attribution';

    /**
     * The attributes that aren't mass assignable.
     *
     * @var Array
     */
    protected $guarded = [];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var Array
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
        'converting_timestamp',
        'original_timestamp'
    ];

    /**
     * Get the lead for this attribution data
     *
     * @return Object
     */
    public function lead()
    {
        return $this->hasOne('App\Lead');
    }

    /**
     * Get converting medium
     *
     * @param  String $value
     * @return String
     */
    public function getConvertingMediumAttribute($value)
    {
        return ucwords($value);
    }

    /**
     * Get original medium
     *
     * @param  String $value
     * @return String
     */
    public function getOriginalMediumAttribute($value)
    {
        return ucwords($value);
    }

    /**
     * Get converting source
     *
     * @param  String $value
     * @return String
     */
    public function getConvertingSourceAttribute($value)
    {
        return ucwords($value);
    }

    /**
     * Get original source
     *
     * @param  String $value
     * @return String
     */
    public function getOriginalSourceAttribute($value)
    {
        return ucwords($value);
    }

    /**
     * Get converting landing page
     *
     * @param  String $value
     * @return URL
     */
    public function getConvertingLandingPageAttribute($value)
    {
        return '<a href = "' . $value . '">' . $value . '</a>';
    }

    /**
     * Get converting landing page
     *
     * @param  String $value
     * @return URL
     */
    public function getOriginalLandingPageAttribute($value)
    {
        return '<a href = "' . $value . '">' . $value . '</a>';
    }

    /**
     * Get refer URL
     *
     * @param  String $value
     * @return URL
     */
    public function getReferUrlAttribute($value)
    {
        return '<a href = "' . $value . '">' . $value . '</a>';
    }

    /**
     * Get total lead counts by attribution columns
     *
     * @param  Array $landing_pages | array of landing page IDs
     * @return Collection
     */
    public static function getLeadCountSplit($landing_pages)
    {
        return collect([
            'converting_medium' => Attribution::getLeadCount($landing_pages, 'converting_medium'),
            'original_medium' => Attribution::getLeadCount($landing_pages, 'original_medium'),
            'converting_source' => Attribution::getLeadCount($landing_pages, 'converting_source'),
            'original_source' => Attribution::getLeadCount($landing_pages, 'original_source')
        ]);
    }

    /**
     * Get lead count by attribution column
     *
     * @param  Array $landing_pages
     * @param  String $column
     * @return Collection
     */
    private static function getLeadCount($landing_pages, $column)
    {
        $medium = Attribution::select(
            DB::raw("IFNULL($column, 'None') AS label"),
            DB::raw("COUNT('id') AS total")
        )
            ->whereIn('landing_page_id', $landing_pages)
            ->groupBy($column)
            ->orderBy('total', 'desc')
            ->lists('total', 'label');
        if (!$medium->isEmpty()) {
            return $medium;
        }
        return collect();
    }
}



