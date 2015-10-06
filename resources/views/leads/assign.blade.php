@extends('layouts.home')





@section('title')
    Leads
@stop





@section('subtitle')
    {{ $lead->first_name . ' ' .  $lead->last_name }}
@stop





@section('breadcrumb')
    <li><a href = "{{ url('leads') }}">All Leads</a></li>
    <li><a href = "{{ url('leads/' . $lead->id) }}">{{ $lead->fullname }}</a></li>
    <li class = "active"><a href = "{{ url('leads') }}">Assign Lead</a></li>
@stop





@section('dates')
    {{ $lead->created_at->timezone($user->timezone)->toDayDateTimeString() }}
@stop






@include('partials.header')





@section('links')
    
@stop





@section('content')

    <div id = "leads_single" class = "row">
        <div id = "leads_single_meta" class = "small-12 columns">
            @include('leads.meta')
        </div>

        <div id = "leads_single_main" class = "small-12 columns">
            <div id = "leads_single_users_add" class = "small-12 columns">
                <p>Assign users as owners for this lead. Only registered users of this campaign may be added.</p>

                <form id = "leads_single_add_users_form" method = "POST" action = "{{ url('leads/' . $lead->id . '/add_users') }}" class = "row" data-abide>

                    {!! csrf_field() !!}

                    <input type = "hidden" name = "_method" value = "PUT" />

                    <div class = "small-12 columns">
                        <div class = "row">
                            <div class = "small-10 columns">
                                <select name = "email[]" class = "chosen-select small-8 columns" data-placeholder = "Select users" multiple>

                                    @foreach ( $campaign_users as $campaign_user )
                                    <option value = "{{ $campaign_user->email }}">{{ $campaign_user->fullname }}</option>
                                    @endforeach

                                </select>
                            </div>
                            <div class = "small-2 columns">
                                <input type = "submit" value = "Assign to Users" class = "button success postfix" />
                            </div>
                        </div>
                    </div>
                </form>
            </div>

            <div id = "leads_single_users_current" class = "small-12 columns">
                <h5>
                    <strong>{{ $lead->users->count() }}</strong>

                    @if ( count($lead->users) == 1 )
                        owner/watcher
                    @else
                        owners/watchers
                    @endif

                </h5>

                <form method = "POST" action = "{{ url('leads/' . $lead->id . '/update_users') }}">

                    {!! csrf_field() !!}

                    <input type = "hidden" name = "_method" value = "PUT" />

                    <table>
                        <thead>
                            <tr>
                                <th class = "text-center"><i class = "fa fa-times"></i></th>
                                <th>User</th>
                                <th>Role</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ( $lead->users as $lead_user )
                                <tr>
                                    <td class = "text-center">

                                        @if ( $lead_user->id != $user->id || $has_admin_access )
                                        <input type = "checkbox" name = "delete[{{ $lead_user->id }}]" value = 1 />
                                        @endif
                                    </td>
                                    <td>
                                        <a href = "#" class = "th">
                                            @if ( is_null($lead_user->profile_url) )
                                            <img src = "{{ asset('img/default.png') }}" />
                                            @else
                                            <img src = "{{ asset('img/user/' . $lead_user->id . '/' . $lead_user->profile_url) }}" />
                                            @endif
                                        </a>

                                        <h5 class = "inline">{{ $lead_user->fullname }}</h5>

                                        @if ( $lead_user->id == $user->id )
                                            <span class = "label">This is you!</label>
                                        @endif
                                    </td>
                                    <td>
                                        @if ( $lead_user->id != $user->id )
                                            <select name = "role[{{ $lead_user->id }}]">
                                                <option value = "Owner" {{ ($lead_user->pivot->type == 'owner') ? 'selected' : '' }}>Owner</option>
                                                <option value = "Watcher" {{ ($lead_user->pivot->type == 'watcher') ? 'selected' : '' }}>Watcher</option>
                                            </select>
                                        @else
                                            {{ ucwords($lead_user->pivot->type) }}
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                            </form>
                        </tbody>
                    </table>

                    <input type = "submit" class = "button radius small-12 columns" value = "Update Lead Users" />
                </form>
            </div>

        </div>
    </div>

@stop


@push('scripts')
<script>
    $(function() {
        $('.chosen-select').chosen();
    });
</script>
@stop