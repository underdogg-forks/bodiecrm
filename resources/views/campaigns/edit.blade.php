@extends('layouts.home')





@section('title')
    Campaigns - Edit
@stop






@section('subtitle')
    Edit campaign details
@stop



@section('breadcrumb')
    <li><a href = "{{ url('campaigns') }}">All Campaigns</a></li>
    <li><a href = "{{ url('campaigns/' . $campaign->id) }}">{{ $campaign->title }}</a></li>
    <li class = "active"><a href = "{{ url('campaigns/' . $campaign->id . '/edit') }}">Edit Campaign</a></li>
@stop



@include('partials.header')





@section('links')
    
@stop






@section('content')

    <div id = "campaign_edit" class = "small-12 columns">
        <p>Edit campaign details.</p>

        <form method = "POST" action = "{{ url('campaigns/' . $campaign->id) }}" class = "row" data-abide>

            {!! csrf_field() !!}

            <input type = "hidden" name = "_method" value = "PUT">

            <div class = "small-12 columns">
                <label for = "title">Title</label>
                <input type = "text" name = "title" required pattern = '[a-zA-Z]+' value = "{{ $campaign->title }}" />
                <small class = "error">Campaign title is required.</small>
            </div>

            <div class = "small-12 columns">
                <label for = "title">Description</label>
                <input type = "text" name = "description" value = "{{ $campaign->description }}" />
                <br>
            </div>

            <div class = "small-12 columns">
                <input type = "submit" value = "Update Campaign" class = "button large radius small-4 columns" />
            </div>
        </form>
    </div>

@stop