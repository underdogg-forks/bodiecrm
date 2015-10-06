@extends('layouts.home')





@section('title')
    Leads - Delete
@stop





@section('subtitle')
    Delete lead - {{ $lead->fullname }}
@stop





@section('breadcrumb')
    <li><a href = "{{ url('leads') }}">All Leads</a></li>
    <li><a href = "{{ url('leads/' . $lead->id) }}">{{ $lead->fullname }}</a></li>
    <li class = "active"><a href = "{{ url('leads/' . $lead->id . '/delete') }}">Delete Lead</a></li>
@stop





@section('dates')
    {{ $lead->created_at->timezone($user->timezone)->toDayDateTimeString() }}
@stop



@section('links')

@stop





@include('partials.header')








@section('content')

    <div id = "leads_single_edit" class = "row">
        <div class = "small-12 columns">
            <p>If you would like to delete this lead, enter in the lead's full name below.</p>

            <form method = "POST" action = "{{ url('leads/' . $lead->id) }}" class = "row" autocomplete = "off" data-abide>
                {!! csrf_field() !!}

                <input type = "hidden" name = "_method" value = "DELETE">

                <div class = "small-12 columns">
                    <input type = "text" name = "fullname" required placeholder = "{{ $lead->fullname }}" />
                    <small class = "error">Full name is required.</small>
                </div>

                <div class = "small-12 columns">
                    <input type = "submit" value = "Delete Lead" class = "button alert large radius small-4 columns" />
                </div>
            </form>
        </div>
    </div>

@stop