@extends('layouts.home')



@section('title')
    Campaign - Add Landing Page
@stop





@section('subtitle')
    Add a landing page
@stop




@section('breadcrumb')
    <li><a href = "{{ url('campaigns') }}">All Campaigns</a></li>
    <li><a href = "{{ url('campaigns/' . $campaign->id) }}">{{ $campaign->title }}</a></li>
    <li class = "active"><a href = "{{ url('campaigns/' . $campaign->id . '/add_landing_page') }}">Add Landing Page</a></li>
@stop






@include('partials.header')






@section('links')
    
@stop




@section('content')
    <div id = "campaign_landing_page_create" class = "small-12 columns">
        <p>Create a landing page to capture lead submissions for this campaign.</p>

        <form method = "POST" action = "{{ url('campaigns/' . $campaign->id . '/add_landing_page') }}" class = "row" data-abide>

            {!! csrf_field() !!}

            <div class = "small-12 columns">
                <label for = "title">Title <span class = "label right">Required</span></label>
                <input type = "text" name = "title" required />
                <small class = "error">Title is required.</small>
            </div>

            <div class = "small-12 columns">
                <label for = "description">Short Description</label>
                <input type = "text" name = "description" />
            </div>

            <div class = "small-12 columns">
                <label for = "return_url">Return URL <span class = "label right">Required</span></label>
                <input type = "url" name = "return_url" required />
                <small class = "error">Return URL is required.</small>
            </div>

            <div id = "send_email_radio" class = "small-12 columns">
                <label for = "send_email">Send notification email when a lead is submitted?</label>
                <input type = "radio" name = "send_email" value = 1 id = "send_email_yes" data-target = "send_email_yes_details" data-action = "unhide" /><label for = "send_email_yes">Yes</label>
                <input type = "radio" name = "send_email" value = 0 id = "send_email_no" data-target = "send_email_yes_details" data-action = "hide" checked /><label for = "send_email_no">No</label>
                <br><br>
            </div>

            <div id = "send_email_yes_details" class = "small-12 columns hide">
                <div>
                    <label for = "email_title">Email title</label>
                    <input type = "text" name = "email_title" placeholder = "Default email title: Lead submitted for [Landing Page Title]" />
                </div>
                <div>
                    <label for = "email_to">Send notification mail to</label>
                    <select class = "chosen-select" name = "add_user_email_notification[]" multiple>
                        @foreach ( $campaign->users as $campaign_user )
                            <option value = "{{ $campaign_user->id }}">
                                {{ $campaign_user->fullname }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class = "small-12 columns">
                <input type = "submit" value = "Create Landing Page" class = "button large radius small-4 columns" />
            </div>
        </form>
    </div>
@stop