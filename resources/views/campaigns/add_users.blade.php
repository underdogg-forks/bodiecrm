@extends('layouts.home')



@section('title')
    Campaigns - Add Users
@stop



@section('subtitle')
    Add Users to Campaign
@stop




@section('breadcrumb')
    <li><a href = "{{ url('campaigns') }}">All Campaigns</a></li>
    <li><a href = "{{ url('campaigns/' . $campaign->id) }}">{{ $campaign->title }}</a></li>
    <li class = "active"><a href = "{{ url('campaigns/' . $campaign->id . '/add_users') }}">Add Users</a></li>
@stop





@include('partials.header')






@section('links')
    
@stop





@section('content')
    <div id = "campaign_add_users" class = "row">
        <div class = "small-12 columns">
            <p>Add registered users to this campaign. <br><br>FUTURE: Users who are already registered will be added, and any users who are not registered will receive an email to register.</p>

            <div id = "campaign_users_add" class = "small-12 columns">
                <form id = "campaign_add_users_form" method = "POST" action = "{{ url('campaigns/' . $campaign->id . '/add_users') }}" class = "row" data-abide>

                    {!! csrf_field() !!}

                    <input type = "hidden" name = "_method" value = "PUT" />

                    <div class = "small-12 columns">
                        <div class = "row">
                            <div class = "small-10 columns">
                                <input type = "text" name = "email" placeholder = "Separate emails with commas (e.g. email@email.com, email2@email.com)" class = "small-8 columns" required />
                                <div class = "clearfix"></div>
                                <small class = "error">A minimum of one email is required</small>
                            </div>
                            <div class = "small-2 columns">
                                <input type = "submit" value = "Share" class = "button success postfix" />
                            </div>
                        </div>
                    </div>
                </form>
            </div>

            <div id = "campaign_users_current" class = "small-12 columns">
                <h5>
                    <strong>{{ $campaign->users->count() }}</strong>

                    @if ( $campaign->users->count() == 1 )
                        person
                    @else
                        people
                    @endif
                    
                    with access
                </h5>

                <form method = "POST" action = "{{ url('campaigns/' . $campaign->id . '/update_users') }}">

                    {!! csrf_field() !!}

                    <input type = "hidden" name = "_method" value = "PUT" />

                    <table>
                        <thead>
                            <tr>
                                <th class = "text-center"><i class = "fa fa-times"></i></th>
                                <th>User</th>
                                <th>
                                    <span data-tooltip aria-haspopup = "true" class = "has-tip tip-right" title = "{{ Lang::get('campaign.role') }}">Role <i class = "fa fa-question-circle"></i>
                                    </span>
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ( $campaign->users as $campaign_user )
                                <tr>
                                    <td class = "text-center">

                                        @if ( $campaign_user->id != $user->id )
                                        <input type = "checkbox" name = "delete[{{ $campaign_user->id }}]" value = 1 />
                                        @endif
                                    </td>
                                    <td>
                                        <a href = "#" class = "th">
                                            @if ( is_null($campaign_user->profile_url) )
                                            <img src = "{{ asset('img/default.png') }}" />
                                            @else
                                            <img src = "{{ asset('img/user/' . $campaign_user->id . '/' . $campaign_user->profile_url) }}" />
                                            @endif
                                        </a>

                                        <h5 class = "inline">{{ $campaign_user->fullname }}</h5>

                                        @if ( $campaign_user->id == $user->id )
                                            <span class = "label">This is you!</label>
                                        @endif
                                    </td>
                                    <td>
                                        @if ( $campaign_user->id != $user->id )
                                            <?php $title = $campaign_user->roles()->where('campaign_id', $campaign->id)->first()->title; ?>

                                            <select name = "role[{{ $campaign_user->id }}]">
                                                <option value = "{{ config('roles.admin') }}" {{ ($title == 'Admin') ? 'selected' : '' }}>Admin</option>
                                                <option value = "{{ config('roles.user') }}" {{ ($title == 'User') ? 'selected' : '' }}>User</option>
                                            </select>
                                        @else
                                            {{ $campaign_user->roles->first()->title }}
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                            </form>
                        </tbody>
                    </table>

                    <input type = "submit" class = "button radius small-12 columns" value = "Update Users" />
                </form>
            </div>
        </div>
    </div>
@stop






