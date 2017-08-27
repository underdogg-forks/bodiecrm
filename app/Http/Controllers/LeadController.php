<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Auth;
use App\Attribution,
    App\Landing_Page,
    App\Lead,
    App\Lead_Comments,
    App\User;
use App\Events\LeadSubmitted,
    App\Events\LogLeadActivity;
// Basic user requests
use App\Http\Requests\Lead\ShowRequest,
    App\Http\Requests\Lead\StoreRequest,
    App\Http\Requests\Lead\StoreNewLeadRequest,
    App\Http\Requests\Lead\StoreCommentRequest;
// Admin requests
use App\Http\Requests\Lead\Admin\ShowRequest as AdminShowRequest,
    App\Http\Requests\Lead\Admin\AddUsersRequest as AdminAddUsersRequest,
    App\Http\Requests\Lead\Admin\UpdateRequest as AdminUpdateRequest,
    App\Http\Requests\Lead\Admin\DestroyRequest as AdminDestroyRequest;

class LeadController extends Controller
{
    public function __construct()
    {
        $this->user = Auth::user();
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        return view('leads/index')
            ->with('user', $this->user)
            ->with('api', url(config("datatables.endpoints.all_leads")));
    }

    /**
     * Display leads by owner
     *
     * @return Response
     */
    public function getIndexOwner()
    {
        return view('leads/index_owner')
            ->with('user', $this->user)
            ->with('api', url(config("datatables.endpoints.owner_leads")));
    }

    /**
     * Display leads by watcher
     *
     * @return Response
     */
    public function getIndexWatcher()
    {
        return view('leads/index_watcher')
            ->with('user', $this->user)
            ->with('api', url(config("datatables.endpoints.watcher_leads")));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param  CreateRequest $request
     * @return Response
     */
    public function create()
    {
        return view('leads.create')
            ->with('user', $this->user);
    }

    /**
     * Store a newly created resource in storage.
     *
     * This function is publicly accessible
     *
     * @param  StoreRequest $request
     * @return Response
     */
    public function store(StoreRequest $request)
    {
        $landing_page_id = $request->get('landing_page_id');
        $landing_page = Landing_Page::find($landing_page_id);
        // Get any custom fields
        $custom = array_where($request->all(), function ($k, $v) {
            return !in_array($k, config('lead.fields'));
        });
        $lead = Lead::create([
            'landing_page_id' => $landing_page_id,
            'first_name' => $request->get('first_name', ''),
            'last_name' => $request->get('last_name', ''),
            'email' => $request->get('email', ''),
            'company' => $request->get('company', ''),
            'title' => $request->get('title', ''),
            'phone' => $request->get('phone', ''),
            'zip' => $request->get('zip', ''),
            'address' => $request->get('address', ''),
            'city' => $request->get('city', ''),
            'state' => $request->get('state', ''),
            'country' => $request->get('country', ''),
            'custom' => json_encode($custom)
        ]);
        // Send emails
        if ($landing_page->send_email) {
            foreach ($landing_page->users_to_email as $user) {
                \Mail::queue('emails.leads.create',
                    ['lead' => $lead, 'landing_page' => $landing_page],
                    function ($message) use ($user, $landing_page) {
                        if (!$landing_page->email_title) {
                            $landing_page->email_title = \Lang::get('lead.email.new_lead', ['title' => $landing_page->title]);
                        }
                        $message->to($user->email)->subject($landing_page->email_title);
                    }
                );
            }
        }
        // Link lead to attribution entry
        \Event::fire(new LeadSubmitted($lead));
        // Redirect override
        if ($request->has('_redirect')) {
            return redirect($request->get('_redirect'));
        }
        return redirect($landing_page->return_url);
    }

    /**
     * Store a new lead (internal)
     *
     * @param  StoreNewLeadRequest $request
     * @return Redirect
     */
    public function postStoreLead(StoreNewLeadRequest $request)
    {
        $landing_page_id = $request->get('landing_page_id');
        $landing_page = Landing_Page::find($landing_page_id);
        // Get any custom fields
        $custom = array_where($request->all(), function ($k, $v) {
            return !in_array($k, config('lead.fields'));
        });
        $lead = Lead::create([
            'landing_page_id' => $landing_page_id,
            'first_name' => $request->get('first_name', ''),
            'last_name' => $request->get('last_name', ''),
            'email' => $request->get('email', ''),
            'company' => $request->get('company', ''),
            'title' => $request->get('title', ''),
            'phone' => $request->get('phone', ''),
            'zip' => $request->get('zip', ''),
            'address' => $request->get('address', ''),
            'city' => $request->get('city', ''),
            'state' => $request->get('state', ''),
            'country' => $request->get('country', ''),
            'custom' => json_encode($custom)
        ]);
        // Send emails
        if ($landing_page->send_email) {
            foreach ($landing_page->users_to_email as $user) {
                \Mail::queue('emails.leads.create',
                    ['lead' => $lead, 'landing_page' => $landing_page],
                    function ($message) use ($user, $landing_page) {
                        if (!$landing_page->email_title) {
                            $landing_page->email_title = \Lang::get('lead.email.new_lead', ['title' => $landing_page->title]);
                        }
                        $message->to($user->email)->subject($landing_page->email_title);
                    }
                );
            }
        }
        // Link lead to attribution entry
        \Event::fire(new LeadSubmitted($lead));
        return redirect('leads')
            ->with('status', \Lang::get('lead.lead_created', ['landing_page' => $landing_page->title]));
    }

    /**
     * Display the specified resource.
     *
     * @param  ShowRequest $request
     * @param  Integer $id
     * @return Response
     */
    public function show(ShowRequest $request, $id)
    {
        $lead = Lead::find($id);
        $owners = $lead->users()->wherePivot('type', 'owner')->get();
        $watchers = $lead->users()->wherePivot('type', 'watcher')->get();
        return view('leads.single')
            ->with('user', $this->user)
            ->with('lead', $lead)
            ->with('has_admin_access', $lead->hasAdminAccess())
            ->with('owners', $owners)
            ->with('watchers', $watchers);
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
        $lead = Lead::find($id);
        $owners = $lead->users()->wherePivot('type', 'owner')->get();
        $watchers = $lead->users()->wherePivot('type', 'watcher')->get();
        return view('leads.edit')
            ->with('user', $this->user)
            ->with('lead', $lead);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  AdminUpdateRequest $request
     * @param  Integer $id
     * @return Response
     */
    public function update(AdminUpdateRequest $request, $id)
    {
        $lead = Lead::find($id);
        $lead->first_name = $request->get('first_name', $lead->first_name);
        $lead->last_name = $request->get('last_name', $lead->last_name);
        $lead->email = $request->get('email', $lead->email);
        $lead->company = $request->get('company', $lead->company);
        $lead->title = $request->get('title', $lead->title);
        $lead->phone = $request->get('phone', $lead->phone);
        $lead->zip = $request->get('zip', $lead->zip);
        $lead->address = $request->get('address', $lead->address);
        $lead->city = $request->get('city', $lead->city);
        $lead->state = $request->get('state', $lead->state);
        $lead->country = $request->get('country', $lead->country);
        if ($request->has('custom')) {
            $lead->other = json_encode($request->get('custom'));
        }
        $lead->save();
        return redirect('leads/' . $lead->id)
            ->with('status', \Lang::get('lead.updated_lead'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  AdminDestroyRequest $request
     * @param  Integer $id
     * @return Response
     */
    public function destroy(AdminDestroyRequest $request, $id)
    {
        $lead = Lead::findOrFail($id);
        if (strtolower($request->get('fullname')) == strtolower($lead->fullname)) {
            $lead->delete();
            Attribution::where('lead_id', $id)->delete();
            return redirect('leads')
                ->with('status', \Lang::get('lead.destroy.successful', ['fullname' => $lead->fullname]));
        } else {
            return redirect('leads/' . $lead->id . '/delete')
                ->with('status', \Lang::get('lead.destroy.unsuccessful', ['fullname' => $lead->fullname]));
        }
    }

    /**
     * Show the form to remove the specific resource from storage
     *
     * @param  AdminShowRequest $request
     * @param  Integer $id
     * @return Response
     */
    public function getDestroyLead(AdminShowRequest $request, $id)
    {
        $lead = Lead::findOrFail($id);
        return view('leads.destroy')
            ->with('user', $this->user)
            ->with('lead', $lead);
    }

    /**
     * Show the form to assign a lead
     *
     * @param  AdminAddUsersRequest $request
     * @param  Integer $id
     * @return Response
     */
    public function getAssignLead(AdminShowRequest $request, $id)
    {
        $lead = Lead::find($id);
        // Get campaign users not already added as owners
        $campaign_users = $lead
            ->campaign()
            ->users()
            ->whereNotIn('users.id', $lead->users()->wherePivot('type', 'owner')->lists('user_id'))
            ->get();
        return view('leads.assign')
            ->with('user', $this->user)
            ->with('lead', $lead)
            ->with('has_admin_access', $lead->hasAdminAccess())
            ->with('campaign_users', $campaign_users);
    }

    /**
     * Add user to lead
     *
     * @param  AdminAddUserRequest $request
     * @param  Integer $id
     * @return Redirect
     */
    public function putAssignLead(AdminAddUsersRequest $request, $id)
    {
        $lead = Lead::find($id);
        $emails = $request->get('email');
        $users_new = User::whereIn('email', $emails)->get();
        $users = $users_new->diff($lead->users()->wherePivot('type', 'owner'));
        // Attach
        foreach ($users as $user) {
            $lead->users()->attach($user->id, ['type' => 'owner']);
            $flash_message[] = $user->fullname;
            \Mail::queue('emails.leads.assign',
                ['lead' => $lead],
                function ($message) use ($user) {
                    $message->to($user->email)->subject(\Lang::get('lead.email.assigned_lead'));
                }
            );
        }
        // Log lead activity
        \Event::fire(new LogLeadActivity($lead, 'Assigned lead to users', $users));
        return redirect('leads/' . $lead->id . '/assign_lead')
            ->with('status', \Lang::get('lead.added_users', ['users' => rtrim(implode(', ', $flash_message), ',')]));
    }

    /**
     * Update users to lead
     *
     * @param  AdminShowRequest $request
     * @param  Integer $id
     * @return Redirect
     */
    public function putUpdateLeadUsers(AdminShowRequest $request, $id)
    {
        $lead = Lead::find($id);
        // Update roles
        if ($request->has('role')) {
            $roles = $request->get('role');
            $users = User::whereIn('id', array_keys($roles))
                ->where('id', '!=', Auth::id())
                ->get();
            foreach ($users as $user) {
                $role = strtolower($roles[$user->id]);
                $current_role = $lead->users()->where('user_id', $user->id)->first()->pivot->type;
                if ($role != $current_role) {
                    $lead->users()->updateExistingPivot($user->id, ['lead_id' => $lead->id, 'type' => $role]);
                }
            }
        }
        // Update deletes
        if ($request->has('delete')) {
            $users = User::whereIn('id', array_keys($request->get('delete')))->get();
            // Remove user pivots as necessary
            foreach ($users as $user) {
                $role = $lead->users()->where('user_id', $user->id)->first()->pivot->type;
                $lead->users()->newPivotStatementForId($user->id)->where('lead_id', $id)->delete();
            }
        }
        return redirect('leads/' . $id . '/assign_lead')
            ->with('status', \Lang::get('lead.updated_users'));
    }

    /**
     * Watch a lead
     *
     * @param  ShowRequest $request
     * @param  Integer $id
     * @return String
     */
    public function getWatchLead(ShowRequest $request, $id)
    {
        $lead = Lead::find($id);
        if (is_null($lead->users()->where('user_id', $this->user->id)->where('type', 'watcher')->first())) {
            $lead->users()->attach($this->user->id, ['type' => 'watcher']);
        }
        return 'true';
    }

    /**
     * Unwatch a lead
     *
     * @param  ShowRequest $request
     * @param  Integer $id
     * @return String
     */
    public function getUnwatchLead(ShowRequest $request, $id)
    {
        $lead = Lead::find($id);
        if (!is_null($lead->users()->where('user_id', $this->user->id)->where('type', 'watcher')->first())) {
            $lead->users()->newPivotStatementForId($this->user->id)->where('lead_id', $id)->where('type', 'watcher')->delete();
        }
        return 'true';
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
        $comment = Lead_Comments::create([
            'user_id' => $this->user->id,
            'lead_id' => $id,
            'comment' => trim($request->get('comment'))
        ]);
        // Set properties to display
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
}