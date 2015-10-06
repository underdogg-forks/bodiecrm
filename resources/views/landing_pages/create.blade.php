@extends('layouts.home')



@section('title')
    Landing Pages
@stop





@section('subtitle')
    Create a landing page
@stop





@include('partials.header')






@section('links')
    <a href = "{{ url('landing_pages/create') }}" class = "button radius small">Add Landing Page</a>
@stop




@section('content')
    <div id = "landing_page_create" class = "small-12 columns">
        <p>Create a new landing page to capture lead submissions.</p>

        <form method = "POST" action = "{{ url('landing_pages') }}" class = "row" data-abide>

            {!! csrf_field() !!}

            <div class = "small-12 columns">
                <label for = "title">Title <span class = "label right">Required</span></label>
                <input type = "text" name = "title" required />
                <small class = "error">Title is required.</small>
            </div>

            <div class = "small-12 columns">
                <label for = "return_url">Return URL <span class = "label right">Required</span></label>
                <input type = "url" name = "return_url" required />
                <small class = "error">Return URL is required.</small>
            </div>

            <div class = "small-12 columns">
                <label for = "campaign_association">Create for which Campaign? <span class = "label right">Required</span></label>
                
                <select name = "campaign_id" required>
                    <option value = "">-- Select one --</option>
                    @foreach ( $campaigns as $campaign )
                    <option value = "{{ $campaign->id }}">{{ $campaign->title }}</option>
                    @endforeach
                </select>

                <small class = "error">Campaign is required.</small>
            </div>

            <div id = "send_email_radio" class = "small-12 columns">
                <label for = "send_email">Send notification email when a lead is submitted?</label>
                <input type = "radio" name = "send_email" value = 1 id = "send_email_yes" data-target = "send_email_yes_details" data-action = "unhide" /><label for = "send_email_yes">Yes</label>
                <input type = "radio" name = "send_email" value = 0 id = "send_email_no" data-target = "send_email_yes_details" data-action = "hide" checked /><label for = "send_email_no">No</label>
            </div>

            <div id = "send_email_yes_details" class = "small-12 columns hide">
                <div>
                    <label for = "email_title">Email title</label>
                    <input type = "text" name = "email_title" placeholder = "Default email title: Lead submitted for [Landing Page Title]" />
                </div>
                <div>
                    <label for = "email_to">Add users to send notification mail to - separate emails by commas</label>
                    <select>
                        @foreach ( $campaign->users as $campaign_user )
                            {{ $campaign_user->fullname }}
                        @endforeach
                    </select>
                    <textarea name = "email_to" placeholder = "email@email.com, email2@email.com"></textarea>
                </div>
            </div>

            <div class = "small-12 columns">
                <input type = "submit" value = "Create Landing Page" class = "button large radius success medium-4 columns" />
            </div>
        </form>
    </div>
@stop