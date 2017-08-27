@extends('layouts.home')



@section('title')
  Campaigns - Create
@stop




@section('subtitle')
  Create a New Campaign
@stop



@section('breadcrumb')
  <li><a href="{{ url('campaigns') }}">All Campaigns</a></li>
  <li class="active"><a href="{{ url('campaigns/create') }}">Create a Campaign</a></li>
@stop



@include('partials.header')





@section('content')
  <div id="campaigns_create" class="small-12 columns">
    <p>Create a new campaign.</p>

    <form method="POST" action="{{ url('campaigns') }}" class="row" data-abide>

      {!! csrf_field() !!}

      <div class="small-12 columns">
        <label for="title">Title <span class="label right">Required</span></label>
        <input type="text" name="title" required/>
        <small class="error">Title is required.</small>
      </div>

      <div class="small-12 columns">
        <label for="description">Short Description</label>
        <input type="text" name="description"/>
      </div>

      <div class="small-12 columns">
        <label for="add_users_to_campaign">Add Users to this campaign</label>
        <input type="text" name="add_users_to_campaign"
               placeholder="Separate emails with commas (e.g. email@email.com, email2@email.com)"
               class="small-8 columns"/>
      </div>
      <div class="small-12 columns">
        <input type="submit" value="Create Campaign" class="button large radius success small-4 columns"/>
      </div>
    </form>
  </div>
@stop