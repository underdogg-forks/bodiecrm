<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Controllers\Controller;

use Auth;
use Carbon\Carbon;

use App\Attribution,
    App\Campaign,
    App\Landing_Page,
    App\Landing_Page_Comments;

// Basic user requests
use App\Http\Requests\LandingPage\ShowRequest,
    App\Http\Requests\LandingPage\ShowAuthKeyRequest,
    App\Http\Requests\LandingPage\StoreCommentRequest;

// Admin requests
use App\Http\Requests\LandingPage\Admin\ShowRequest as AdminShowRequest,
    App\Http\Requests\LandingPage\Admin\StoreRequest as AdminStoreRequest;

use App\Helpers\Contracts\ChartContract;

class LandingPageController extends Controller
{

    /**
     * Start and end dates for charts
     * 
     * @var Carbon
     */
    public $start_date;
    public $end_date;

    /**
     * Time length
     * 
     * @var String
     */
    public $length;

    
    public function __construct()
    {
        $this->user = Auth::user();

        $this->length     = 'month';
        $this->start_date = ( $this->length == 'month' ) ?
            Carbon::today()->subMonth() :
            Carbon::today()->subWeek();

        $this->end_date   = Carbon::today();
    }

    /**
     * Display a listing of the resource.
     *
     * @param  ChartContract $chart
     * @return Response
     */
    public function index(ChartContract $chart)
    {
        $landing_pages = $this->user->landing_pages_active();
       
        foreach ( $landing_pages as $landing_page ) {

            // Get leads, grouped by day
            $landing_page->leads_data = $landing_page->getLeads($this->length);
            
            // Get total lead count for date range
            $landing_page->leads_sum  = $landing_page
                ->leads()
                ->where('created_at', '>', $this->start_date)
                ->count();

            $chart->init($this->start_date, $this->end_date);
            $chart->setLineBarDataSet($landing_page->leads_data, $landing_page->title);

            $landing_page->leads_graph = $chart->getLineBarChart();
        }
        
        return view('landing_pages.index')
            ->with('user', $this->user)
            ->with('landing_pages', $landing_pages)
            ->with('start_date', $this->start_date)
            ->with('end_date', $this->end_date);
    }

    /**
     * Display a listing of the resource.
     *
     * Show archived landing pages
     * 
     * @param  ChartContract $chart
     * @return Response
     */
    public function getIndexArchived(ChartContract $chart)
    {
        $landing_pages = $this->user->landing_pages_archived();
       
        foreach ( $landing_pages as $landing_page ) {

            // Get leads, grouped by day
            $landing_page->leads_data = $landing_page->getLeads($this->length);
            
            // Get total lead count for date range
            $landing_page->leads_sum  = $landing_page
                ->leads()
                ->where('created_at', '>', $this->start_date)
                ->count();

            $chart->init($this->start_date, $this->end_date);
            $chart->setLineBarDataSet($landing_page->leads_data, $landing_page->title);

            $landing_page->leads_graph = $chart->getLineBarChart();
        }
        
        return view('landing_pages.index_archived')
            ->with('user', $this->user)
            ->with('landing_pages', $landing_pages)
            ->with('start_date', $this->start_date)
            ->with('end_date', $this->end_date);
    }

    /**
     * Display the specified resource.
     *
     * @param  ShowRequest $request
     * @param  ChartContract $chart
     * @param  Integer $id
     * @return Response
     */
    public function show(ShowRequest $request, ChartContract $chart, $id)
    {
        $landing_page             = Landing_Page::find($id);
        
        // Get leads, grouped by day
        $landing_page->leads_data = $landing_page->getLeads($this->length);
        
        // Get total lead count for date range
        $landing_page->leads_sum  = $landing_page->leads()->where('created_at', '>', $this->start_date)->count();

        $chart->init($this->start_date, $this->end_date);
        $chart->setLineBarDataSet($landing_page->leads_data, $landing_page->title);
        
        $landing_page->leads_graph = $chart->getLineBarChart();

        // Get attribution data
        $landing_page->attribution_data = Attribution::getLeadCountSplit([$landing_page->id]);
        $landing_page->attribution      = $chart->getPieChart($landing_page->attribution_data);

        return view('landing_pages.single')
            ->with('has_admin_access', $landing_page->isAdmin())
            ->with('user', $this->user)
            ->with('landing_page', $landing_page);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  AdminShowRequest $request
     * @param  Integer $id
     * @return Response
     */
    public function edit(AdminShowRequest $request, $id)
    {
        $landing_page   = Landing_Page::find($id);
        
        $users_to_email = $landing_page
            ->users_to_email()
            ->lists('user_id');

        return view('landing_pages.edit')
            ->with('user', $this->user)
            ->with('users_to_email', $users_to_email)
            ->with('landing_page', $landing_page);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  AdminStoreRequest  $request
     * @param  Integer  $id
     * @return Redirect
     */
    public function update(AdminStoreRequest $request, $id)
    {
        $landing_page              = Landing_Page::find($id);
        
        $landing_page->title       = $request->get('title', $landing_page->title);
        $landing_page->description = $request->get('description', $landing_page->description);
        $landing_page->return_url  = $request->get('return_url', $landing_page->return_url);
        $landing_page->send_email  = $request->get('send_email', $landing_page->send_email);
        $landing_page->email_title = $request->get('email_title', $landing_page->email_title);
        
        $landing_page->save();

        // Attach users to email
        if ( $request->has('add_user_email_notification') ) {
            $landing_page->users_to_email()->sync($request->get('add_user_email_notification'));
        }

        return redirect('landing_pages/' . $landing_page->id)
            ->with('status', \Lang::get('landing_page.updated_landing_page'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Integer  $id
     * @return Response
     */
    public function destroy($id)
    {
        //
    }

    /**
     * Display the web to lead form
     * 
     * @param  ShowRequest $request
     * @param  Integer $id
     * @return Response
     */
    public function getWebToLead(ShowRequest $request, $id)
    {
        $landing_page = Landing_Page::find($id);

        return view('landing_pages.web_to_lead')
            ->with('user', $this->user)
            ->with('landing_page', $landing_page);
    }

    /**
     * Add a comment
     * 
     * @param  StoreCommentRequest $request
     * @param  Integer $id
     * @return JSON
     */
    public function postAddComment(StoreCommentRequest $request, $id)
    {
        $comment  = Landing_Page_Comments::create([
            'user_id'         => $this->user->id,
            'landing_page_id' => $id,
            'comment'         => trim($request->get('comment'))
        ]);

        $comment->formatted_date = $comment->created_at->timezone($this->user->timezone)->toFormattedDateString();
        $comment->user->fullname = $comment->user->first_name . ' ' . $comment->user->last_name;
        $comment->comment        = nl2br($comment->comment);
        
        // Send a full URL to the profile image asset 
        if ( ! $comment->user->profile_url ) {
            $comment->user->profile_url = asset('img/default.png');
        }
        else {
            $comment->user->profile_url = asset('img/user/' . $comment->user->id . '/' . $comment->user->profile_url);
        }

        return response()->json(['user' => $comment->user, 'comment' => $comment]);
    }
}