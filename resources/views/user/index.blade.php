@extends('layouts.home')






@section('title')
    User
@stop






@section('subtitle')
    Your Profile
@stop





@section('breadcrumb')
    <li class = "active"><a href = "{{ url('user') }}">You</a></li>
@stop





@include('partials.header')




@section('links')
    
@stop





@section('content')
    <div id = "user_profile" class = "row">
        <div id = "user_profile_sidebar" class = "small-3 columns">
            <div id = "user_profile_avatar" class = "small-12 columns">
                
                <span data-tooltip aria-haspopup = "true" class = "has-tip tip-right" title = "{{ Lang::get('user.avatar') }}">
                    <a href = "{{ url('user/' . $user->id) }}/edit">

                        @if ( is_null($user->profile_url) )
                        <img src = "{{ asset('img/default.png') }}" class = "th" />
                        @else
                        <img src = "{{ asset('img/user/' . $user->id . '/' . $user->profile_url) }}" class = "th" />
                        @endif
                    </a>
                </span>

            </div>

            <div id = "user_profile_details" class = "small-12 columns">
                <h2>{{ $user->fullname }}</h2>
                <h4>{{ $user->company }}</h4>
            </div>

            <div id = "user_profile_meta" class = "small-12 columns">
                <div>
                    <i class = "fa fa-envelope"></i>&nbsp;&nbsp;<a href = "mailto:{{ $user->email }}">{{ $user->email }}</a>
                </div>
                <div>
                    <i class = "fa fa-calendar-check-o"></i>&nbsp;&nbsp;Joined {{ $user->created_at->diffForHumans() }}
                </div>

                <div>
                    <i class = "fa fa-globe"></i>&nbsp;&nbsp;{{ str_replace('_', ' ', $user->timezone) }}
                </div>
            </div>
        </div>

        <div id = "user_profile_content" class = "small-9 columns">
            
        </div>
    </div>
@stop