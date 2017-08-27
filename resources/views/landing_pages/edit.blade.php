@extends('layouts.home')




@section('title')
  Landing Page - Edit
@stop




@section('subtitle')
  Edit landing page details
@stop





@section('breadcrumb')
  <li><a href="{{ url('campaigns') }}">All Campaigns</a></li>
  <li><a href="{{ url('campaigns/' . $landing_page->campaign->id) }}">{{ $landing_page->campaign->title }}</a></li>
  <li><a href="{{ url('landing_pages/' . $landing_page->id) }}">{{ $landing_page->title }}</a></li>
  <li class="active"><a href="{{ url('landing_pages/' . $landing_page->id . '/edit') }}">Edit Landing Page</a></li>
@stop





@include('partials.header')




@section('content')
  <div id="landing_page_single_edit" class="row">
    <div class="small-12 columns">
      <p>Edit this landing page details.</p>

      <form method="POST" action="{{ url('landing_pages/' . $landing_page->id) }}" class="row" data-abide>

        {!! csrf_field() !!}

        <input type="hidden" name="_method" value="PUT">

        <div class="small-12 columns">
          <label for="title">Title</label>
          <input type="text" name="title" required pattern='[a-zA-Z]+' value="{{ $landing_page->title }}"/>
          <small class="error">Landing Page Title is required.</small>
        </div>

        <div class="small-12 columns">
          <label for="title">Short Description</label>
          <input type="text" name="description" value="{{ $landing_page->description }}"/>
        </div>

        <div class="small-12 columns">
          <label for="auth_key">Authentication Key</label>
          <input type="text" name="auth_key" required disabled value="{{ $landing_page->auth_key }}"/>
        </div>

        <div class="small-12 columns">
          <label for="return_url">Return URL</label>
          <input type="url" name="return_url" required value="{{ $landing_page->return_url }}"/>
          <small class="error">Return URL is required.</small>
        </div>

        <div id="send_email_radio" class="small-12 columns">
          <label for="send_email">Send notification email when a lead is submitted? <span data-tooltip
                                                                                          aria-haspopup="true"
                                                                                          class="has-tip tip-right"
                                                                                          title="{{ Lang::get('landing_page.send_notification_email') }}"><i
                class="fa fa-question-circle"></i></span></label>
          <input type="radio" name="send_email" value=1 id="send_email_yes" data-target="send_email_yes_details"
                 data-action="unhide" {{ $landing_page->send_email ? 'checked' : '' }} /><label
            for="send_email_yes">Yes</label>
          <input type="radio" name="send_email" value=0 id="send_email_no" data-target="send_email_yes_details"
                 data-action="hide" {{ ! $landing_page->send_email ? 'checked' : '' }} /><label
            for="send_email_no">No</label>
          <br><br>
        </div>

        <div id="send_email_yes_details" class="small-12 columns {{ ! $landing_page->send_email ? 'hide' : '' }}">
          <div>
            <label for="email_title">Email title</label>
            <input type="text" name="email_title"
                   placeholder="Default email title: Lead submitted for [Landing Page Title]"
                   value="{{ $landing_page->email_title }}"/>
          </div>
          <div>
            <label for="email_to">Send notification mail to <span data-tooltip aria-haspopup="true"
                                                                  class="has-tip tip-right"
                                                                  title="{{ Lang::get('landing_page.send_notification_email_users') }}"><i
                  class="fa fa-question-circle"></i></span></label>
            <select class="chosen-select" name="add_user_email_notification[]" multiple>
              @foreach ( $landing_page->campaign->users as $campaign_user )
                <option
                  value="{{ $campaign_user->id }}" {{ $users_to_email->contains($campaign_user->id) ? 'selected' : '' }}>
                  {{ $campaign_user->fullname }}
                </option>
              @endforeach
            </select>
          </div>
        </div>
        <div class="small-12 columns">
          <input type="submit" value="Update Landing Page" class="button large radius small-4 columns"/>
        </div>
      </form>
    </div>
  </div>
@stop