<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;

use Auth;
use Carbon\Carbon;
use Datatables;

use App\Lead;


class DataTablesController extends Controller
{

    /**
     * Start and end dates
     * 
     * @var Carbon
     */
    public $start_date;
    public $end_date;

    /**
     * Constructor
     * 
     * @param Request $request
     */
    public function __construct(Request $request)
    {
        $this->user = Auth::user();

        $this->start_date = ( $request->has('start_date') ) ?
            Carbon::createFromFormat('Y-m-d', $request->get('start_date')) :
            Carbon::now()->subMonth();

        $this->end_date = ( $request->has('end_date') ) ?
            Carbon::createFromFormat('Y-m-d', $request->get('end_date')) :
            Carbon::now();
    }

    /**
     * Get all leads
     *
     * @return Datatables
     */
    public function getAllLeads()
    {
        $leads = Lead::select(
            'id',
            'first_name',
            'last_name',
            'email',
            'phone',
            'company',
            'title',
            'created_at',
            'updated_at'
        )
        ->with(['attribution' => function($q) {
            $q->select(['lead_id', 'tracking_id', 'converting_timestamp', 'original_timestamp']);
        }])
        ->orderBy('created_at', 'DESC')
        ->get();
        
        return Datatables::of($leads)
            ->addColumn('timedifference', function($lead) {

                // If no attribution data (leads should always have attribution data)
                if ( $lead->attribution->count() == 0) {
                    return '<span class = "lighter">Not available</span>';
                }

                else {
                    if ( ! is_null($lead->attribution[0]->converting_timestamp) && ! is_null($lead->attribution[0]->original_timestamp) ) {
                        return $lead->attribution[0]->converting_timestamp->diffForHumans($lead->attribution[0]->original_timestamp, true);
                    }
                    else {
                        return '<span class = "lighter">Not available</span>';
                    }
                }
            })
            ->addColumn('link', function($lead) {
                return '<a href = "' . url('leads/' . $lead->id) . '">View</a>';
            })
            ->editColumn('created_at', function($lead) {
                return $lead->created_at->timezone($this->user->timezone)->format('m/d/Y h:ia');
            })
            ->editColumn('updated_at', '{!! $created_at->diffForHumans() !!}')
            ->make(true);
    }

    /**
     * Get owner leads
     *
     * @return Datatables
     */
    public function getOwnerLeads()
    {
        $leads = Lead::select(
            'leads.id',
            'leads.first_name',
            'leads.last_name',
            'leads.email',
            'leads.phone',
            'leads.company',
            'leads.title',
            'leads.created_at',
            'leads.updated_at'
        )
        ->with(['attribution' => function($q) {
            $q->select(['lead_id', 'tracking_id', 'converting_timestamp', 'original_timestamp']);
        }])
        ->join('leads_to_users', 'leads.id', '=', 'leads_to_users.lead_id')
        ->where('leads_to_users.type', '=', 'owner')
        ->orderBy('created_at', 'DESC')
        ->get();

        return Datatables::of($leads)
            ->addColumn('timedifference', function($lead) {

                // If no attribution data (leads should always have attribution data)
                if ( $lead->attribution->count() == 0) {
                    return '<span class = "lighter">Not available</span>';
                }

                else {
                    if ( ! is_null($lead->attribution[0]->converting_timestamp) && ! is_null($lead->attribution[0]->original_timestamp) ) {
                        return $lead->attribution[0]->converting_timestamp->diffForHumans($lead->attribution[0]->original_timestamp, true);
                    }
                    else {
                        return '<span class = "lighter">Not available</span>';
                    }
                }
            })
            ->addColumn('link', function($lead) {
                return '<a href = "' . url('leads/' . $lead->id) . '">View</a>';
            })
            ->editColumn('created_at', function($lead) {
                return $lead->created_at->timezone($this->user->timezone)->format('m/d/Y h:ia');
            })
            ->editColumn('updated_at', '{!! $created_at->diffForHumans() !!}')
            ->make(true);
    }

    /**
     * Get watcher leads
     *
     * @return Datatables
     */
    public function getWatcherLeads()
    {
        $leads = Lead::select(
            'leads.id',
            'leads.first_name',
            'leads.last_name',
            'leads.email',
            'leads.phone',
            'leads.company',
            'leads.title',
            'leads.created_at',
            'leads.updated_at'
        )
        ->with(['attribution' => function($q) {
            $q->select(['lead_id', 'tracking_id', 'converting_timestamp', 'original_timestamp']);
        }])
        ->join('leads_to_users', 'leads.id', '=', 'leads_to_users.lead_id')
        ->where('leads_to_users.type', '=', 'watcher')
        ->orderBy('created_at', 'DESC')
        ->get();

        return Datatables::of($leads)
            ->addColumn('timedifference', function($lead) {

                // If no attribution data (leads should always have attribution data)
                if ( $lead->attribution->count() == 0) {
                    return '<span class = "lighter">Not available</span>';
                }

                else {
                    if ( ! is_null($lead->attribution[0]->converting_timestamp) && ! is_null($lead->attribution[0]->original_timestamp) ) {
                        return $lead->attribution[0]->converting_timestamp->diffForHumans($lead->attribution[0]->original_timestamp, true);
                    }
                    else {
                        return '<span class = "lighter">Not available</span>';
                    }
                }
            })
            ->addColumn('link', function($lead) {
                return '<a href = "' . url('leads/' . $lead->id) . '">View</a>';
            })
            ->editColumn('created_at', function($lead) {
                return $lead->created_at->timezone($this->user->timezone)->format('m/d/Y h:ia');
            })
            ->editColumn('updated_at', '{!! $created_at->diffForHumans() !!}')
            ->make(true);
    }
}
