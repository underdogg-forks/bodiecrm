@extends('layouts.home')





@section('title')
    Campaigns - Archive
@stop






@section('subtitle')
    Archive campaign
@stop



@section('breadcrumb')
    <li><a href = "{{ url('campaigns') }}">All Campaigns</a></li>
    <li><a href = "{{ url('campaigns/' . $campaign->id) }}">{{ $campaign->title }}</a></li>
    <li class = "active"><a href = "{{ url('campaigns/' . $campaign->id . '/archive') }}">Archive Campaign</a></li>
@stop



@include('partials.header')





@section('links')
    
@stop






@section('content')

    <div id = "campaign_edit" class = "small-12 columns">
        <p>If you would like to archive this campaign, enter in the campaign's title below.</p>
        <p>Please note that archiving a campaign will stop all landing page submissions.</p>

        <form method = "POST" action = "{{ url('campaigns/' . $campaign->id . '/archive') }}" class = "row" autocomplete = "off" data-abide>

            {!! csrf_field() !!}

            <input type = "hidden" name = "_method" value = "PUT">

            <div class = "small-12 columns">
                <input type = "text" name = "title" required placeholder = "{{ $campaign->title }}" />
                <small class = "error">Campaign title is required.</small>
            </div>

            <div class = "small-12 columns">
                <input type = "submit" value = "Archive Campaign" class = "button large alert radius small-4 columns" />
            </div>
        </form>
    </div>

@stop