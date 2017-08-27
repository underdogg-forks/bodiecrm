<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;
use Carbon\Carbon;
use App\Campaign,
    App\Campaign_Comments,
    App\Landing_Page,
    App\User;
// Basic user requests
use App\Http\Requests\Campaign\ShowRequest,
    App\Http\Requests\Campaign\StoreRequest,
    App\Http\Requests\Campaign\StoreCommentRequest;
// Admin requests
use App\Http\Requests\Campaign\Admin\ShowRequest as AdminShowRequest,
    App\Http\Requests\Campaign\Admin\AddUsersRequest as AdminAddUsersRequest,
    App\Http\Requests\Campaign\Admin\UpdateUsersRequest as AdminUpdateUsersRequest,
    App\Http\Requests\Campaign\Admin\StoreLandingPageRequest as AdminStoreLandingPageRequest;
use App\Helpers\Contracts\ChartContract;

class CampaignController extends Controller
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
        $this->length = 'month';
        $this->start_date = ($this->length == 'month') ?
            Carbon::today()->subMonth() :
            Carbon::today()->subWeek();
        $this->end_date = Carbon::today();
    }

    /**
     * Display a listing of the resource.
     *
     * @param  ChartContract $chart
     * @return Response
     */
    public function index(ChartContract $chart)
    {
        $campaigns = $this->user
            ->campaigns()
            ->where('active', 1)
            ->orderBy('created_at', 'DESC')
            ->get();
        // Get campaign specific details
        foreach ($campaigns as $campaign) {
            // Get campaign leads, grouped by day
            $campaign->leads_data = $campaign->getLeads($this->length);
            // Set dates and dataset
            $chart->init($this->start_date, $this->end_date);
            $chart->setLineBarDataSet($campaign->leads_data, $campaign->title);
            // Get JSON for chart
            $campaign->leads_graph = $chart->getLineBarChart();
        }
        return view('campaigns.index')
            ->with('user', $this->user)
            ->with('campaigns', $campaigns);
    }

    /**
     * Display a listing of the resource
     *
     * Archived campaigns
     *
     * @param  ChartContract $chart
     * @return Response
     */
    public function getIndexArchived(ChartContract $chart)
    {
        $campaigns = $this->user
            ->campaigns()
            ->where('active', 0)
            ->orderBy('created_at', 'DESC')
            ->get();
        // Get campaign specific details
        foreach ($campaigns as $campaign) {
            // Get campaign leads, grouped by day
            $campaign->leads_data = $campaign->getLeads($this->length);
            // Set dates and dataset
            $chart->init($this->start_date, $this->end_date);
            $chart->setLineBarDataSet($campaign->leads_data, $campaign->title);
            // Get JSON for chart
            $campaign->leads_graph = $chart->getLineBarChart();
        }
        return view('campaigns.index_archived')
            ->with('user', $this->user)
            ->with('archived', true)
            ->with('campaigns', $campaigns);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return view('campaigns.create')
            ->with('user', $this->user);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  StoreRequest $request
     * @return Response
     */
    public function store(StoreRequest $request)
    {
        $campaign = Campaign::create([
            'user_id' => $this->user->id,
            'title' => $request->get('title'),
            'description' => $request->get('description')
        ]);
        // Add user role to campaign
        $this->user->roles()->attach(config('roles.admin'), ['campaign_id' => $campaign->id]);
        // Add additional users roles to campaign
        if ($request->has('add_users_to_campaign')) {
            $emails = $request->get('add_users_to_campaign');
            $emails = get_array_from_string(',', $emails);
            $users = User::whereIn('email', $emails)
                ->where('id', '!=', $this->user->id)
                ->get();
            foreach ($users as $user) {
                $user->roles()->attach(config('roles.user'), ['campaign_id' => $campaign->id]);
            }
        }
        return redirect('campaigns/' . $campaign->id)
            ->with('status', \Lang::get('campaign.created_campaign', ['campaign_title' => $campaign->title]));

    }

    /**
     * Display the specified resource.
     *
     * @param  ShowRequest $request
     * @param  Integer $id
     * @return Response
     */
    public function show(ShowRequest $request, ChartContract $chart, $id)
    {
        $campaign = Campaign::where('id', $id)
            ->with(['landing_pages' => function ($q) {
                $q->orderBy('created_at', 'DESC');
            }])
            ->with(['comments' => function ($q) {
                $q->orderBy('created_at', 'DESC');
            }])
            ->first();
        // Instantiate campaign leads collection
        $campaign->leads_data = collect();
        // Set chart date
        $chart->init($this->start_date, $this->end_date);
        // Add an iterator loop for different chart colors
        foreach ($campaign->landing_pages as $i => $landing_page) {
            // Get total lead count for date range
            $landing_page->leads_sum = $landing_page
                ->leads()
                ->where('created_at', '>', $this->start_date)
                ->count();
            // Get landing page leads, grouped by day
            $landing_page->leads_data = $landing_page->getLeads($this->length);
            // Set dataset
            $chart->setLineBarDataSet($landing_page->leads_data, $landing_page->title, $i);
            // Push landing page dataset into campaign dataset
            $campaign->leads_data->push($chart->getDataSet());
            $landing_page->leads_graph = $chart->getLineBarChart();
        }
        $campaign->leads_graph = $chart->getLineBarChart($campaign->leads_data);
        // Get attribution data
        $campaign->attribution_data = \App\Attribution::getLeadCountSplit($campaign->landing_pages->lists('id'));
        $campaign->attribution = $chart->getPieChart($campaign->attribution_data);
        return view('campaigns.single')
            ->with('has_admin_access', $campaign->isAdmin())
            ->with('user', $this->user)
            ->with('campaign', $campaign);
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
        $campaign = Campaign::find($id);
        return view('campaigns.edit')
            ->with('user', $this->user)
            ->with('campaign', $campaign);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  AdminShowRequest $request
     * @param  Integer $id
     * @return Response
     */
    public function update(AdminShowRequest $request, $id)
    {
        $campaign = Campaign::find($id);
        $campaign->title = $request->get('title');
        $campaign->description = $request->get('description');
        $campaign->save();
        return redirect('campaigns/' . $campaign->id)
            ->with('status', \Lang::get('campaign.updated_campaign'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Integer $id
     * @return Response
     */
    public function destroy($id)
    {
        //
    }

    /**
     * Show add users to campaign form
     *
     * @param ShowRequest $request
     * @param Integer $id
     * @param Response
     */
    public function getAddUsers(AdminShowRequest $request, $id)
    {
        $campaign = Campaign::find($id);
        return view('campaigns.add_users')
            ->with('user', $this->user)
            ->with('campaign', $campaign);
    }

    /**
     * Add users to campaign
     *
     * @param  AddUsersRequest $request
     * @param  Integer $id
     * @return Redirect
     */
    public function putAddUsers(AdminAddUsersRequest $request, $id)
    {
        $flash_message = [];
        $emails = $request->get('email');
        $emails = get_array_from_string(',', $emails);
        $campaign = Campaign::find($id);
        // Get current users and users to add
        $users_new = User::whereIn('email', $emails)->get();
        // Get only un-added users
        $users = $users_new->diff($campaign->users);
        // Attach
        foreach ($users as $user) {
            $user->roles()->attach(config('roles.user'), ['campaign_id' => $campaign->id]);
            $flash_message[] = $user->email;
        }
        return redirect('campaigns/' . $campaign->id . '/add_users')
            ->with('status', \Lang::get('campaign.added_users', ['users' => rtrim(implode(', ', $flash_message), ',')]));
    }

    /**
     * Update users for campaign
     *
     * @param  AdminUpdateUsersRequest $request
     * @param  Integer $id
     * @return Redirect
     */
    public function putUpdateUsers(AdminUpdateUsersRequest $request, $id)
    {
        // Update roles
        if ($request->has('role')) {
            $roles = $request->get('role');
            $users = User::whereIn('id', array_keys($roles))
                ->where('id', '!=', Auth::id())
                ->get();
            foreach ($users as $user) {
                $role_id = (int)$roles[$user->id];
                $current_role_id = $user->roles()->where('campaign_id', $id)->first()->id;
                if ($role_id != $current_role_id) {
                    $user->roles()->updateExistingPivot($user->id, ['role_id' => $role_id]);
                }
            }
        }
        // Update deletes
        if ($request->has('delete')) {
            $users = User::whereIn('id', array_keys($request->get('delete')))
                ->where('id', '!=', Auth::id())
                ->get();
            // Remove user pivots as necessary
            foreach ($users as $user) {
                $role_id = $user->roles()->where('campaign_id', $id)->first()->id;
                $user->roles()->newPivotStatementForId($role_id)->where('campaign_id', $id)->delete();
            }
        }
        return redirect('campaigns/' . $id . '/add_users')
            ->with('status', \Lang::get('campaign.updated_users'));
    }

    /**
     * Show the form for adding landing page
     *
     * @param  AdminShowRequest $request
     * @param  Integer $id
     * @return Response
     */
    public function getAddLandingPage(AdminShowRequest $request, $id)
    {
        $campaign = Campaign::find($id);
        return view('campaigns.add_landing_page')
            ->with('user', $this->user)
            ->with('campaign', $campaign);
    }

    /**
     * Add landing page to campaign
     *
     * @param  AdminStoreLandingPageRequest $request
     * @param  Integer $id
     * @return Response
     */
    public function postAddLandingPage(AdminStoreLandingPageRequest $request, $id)
    {
        $landing_page = Landing_Page::create([
            'user_id' => $this->user->id,
            'campaign_id' => $id,
            'title' => $request->get('title'),
            'description' => $request->get('description'),
            'return_url' => $request->get('return_url'),
            'auth_key' => str_random(40),
            'send_email' => $request->has('send_email') ? $request->get('send_email') : 0,
            'email_title' => $request->has('email_title') ? $request->get('email_title') : ''
        ]);
        // Attach users to email
        if ($request->has('add_user_email_notification')) {
            $landing_page->users_to_email()->sync($request->get('add_user_email_notification'));
        }
        return redirect('landing_pages/' . $landing_page->id)
            ->with('status', \Lang::get('campaign.created_landing_page', ['landing_page_title' => $landing_page->title]));
    }

    /**
     * Add a comment
     *
     * @param  StoreCommentRequest $request
     * @param  Integer $id
     * @return void
     */
    public function postAddComment(StoreCommentRequest $request, $id)
    {
        $comment = Campaign_Comments::create([
            'user_id' => $this->user->id,
            'campaign_id' => $id,
            'comment' => trim($request->get('comment'))
        ]);
        $comment->formatted_date = $comment->created_at->timezone($this->user->timezone)->toFormattedDateString();
        $comment->user->fullname = $comment->user->first_name . ' ' . $comment->user->last_name;
        $comment->comment = nl2br($comment->comment);
        // Send a full URL to the profile image asset 
        if (!$comment->user->profile_url) {
            $comment->user->profile_url = asset('img/default.png');
        } else {
            $comment->user->profile_url = asset('img/user/' . $comment->user->id . '/' . $comment->user->profile_url);
        }
        return response()->json(['user' => $comment->user, 'comment' => $comment]);
    }

    /**
     * Get the archive campaign form
     *
     * @param  AdminShowRequest $request
     * @param  Integer $id
     * @return Response
     */
    public function getArchiveCampaign(AdminShowRequest $request, $id)
    {
        $campaign = Campaign::findOrFail($id);
        return view('campaigns.archive')
            ->with('user', $this->user)
            ->with('campaign', $campaign);
    }

    /**
     * Archive the campaign
     *
     * @param  AdminShowRequest $request
     * @param  Integer $id
     * @return Redirect
     */
    public function putArchiveCampaign(AdminShowRequest $request, $id)
    {
        $campaign = Campaign::findOrFail($id);
        if (strtolower($request->get('title')) == strtolower($campaign->title)) {
            $campaign->active = 0;
            $campaign->save();
            return redirect('campaigns/' . $campaign->id)
                ->with('status', \Lang::get('campaign.archive.successful', ['title' => $campaign->title]));
        } else {
            return redirect('campaigns/' . $campaign->id . '/archive')
                ->with('status', \Lang::get('campaign.archive.unsuccessful', ['title' => $campaign->title]));
        }
    }

    /**
     * Get the unarchive campaign form
     *
     * @param  AdminShowRequest $request
     * @param  Integer $id
     * @return Response
     */
    public function getUnarchiveCampaign(AdminShowRequest $request, $id)
    {
        $campaign = Campaign::findOrFail($id);
        return view('campaigns.unarchive')
            ->with('user', $this->user)
            ->with('campaign', $campaign);
    }

    /**
     * Unarchive the campaign
     *
     * @param  AdminShowRequest $request
     * @param  Integer $id
     * @return Redirect
     */
    public function putUnarchiveCampaign(AdminShowRequest $request, $id)
    {
        $campaign = Campaign::findOrFail($id);
        if (strtolower($request->get('title')) == strtolower($campaign->title)) {
            $campaign->active = 1;
            $campaign->save();
            return redirect('campaigns/' . $campaign->id)
                ->with('status', \Lang::get('campaign.unarchive.successful', ['title' => $campaign->title]));
        } else {
            return redirect('campaigns/' . $campaign->id . '/unarchive')
                ->with('status', \Lang::get('campaign.unarchive.unsuccessful', ['title' => $campaign->title]));
        }
    }
}