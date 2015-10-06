@extends('layouts.home')





@section('title')
    Leads
@stop





@section('subtitle')
    {{ $lead->fullname }}
@stop





@section('breadcrumb')
    <li><a href = "{{ url('leads') }}">All Leads</a></li>
    <li class = "active"><a href = "{{ url('leads/' . $lead->id) }}">{{ $lead->fullname }}</a></li>
@stop





@section('dates')
    {{ $lead->created_at->timezone($user->timezone)->toDayDateTimeString() }}
@stop



@section('links')
    @include('leads.links')
@stop





@include('partials.header')




@section('comments')
    @include('leads.comments')
@stop




@section('content')

    <div id = "leads_single" class = "row">
        <div id = "leads_single_users" class = "meta small-12 columns">
            
            <div class = "small-6 columns text-left">
                @include('leads.users')
            </div>

        </div>

        <div id = "leads_single_meta" class = "small-12 columns">
            @include('leads.meta')
        </div>

        <div id = "leads_single_main" class = "small-8 columns">
            <div id = "leads_single_details" class = "small-12 columns">
                @include('leads.details')
            </div>

            @if ( $lead->attribution->count() > 0 )
            <div id = "leads_single_attribution" class = "small-12 columns">
                <h4>
                    <span data-tooltip aria-haspopup = "true" class = "has-tip tip-right" title = "{{ Lang::get('lead.attribution_label') }}">Attribution Details <i class = "fa fa-question-circle"></i></span>
                </h4>
                
                @include('leads.attribution')
            </div>
            @endif
        </div>

        <div id = "leads_single_timeline" class = "small-4 columns text-center animated fadeIn">
            @include('leads.timeline')
        </div>
        
    </div>

@stop