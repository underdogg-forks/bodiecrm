@extends('layouts.home')






@section('title')
  Campaigns
@stop






@section('subtitle')
  Your Campaigns

  <p>Below are all of your campaigns.</p>
@stop





@section('breadcrumb')
  <li class="active"><a href="{{ url('campaigns') }}">All Campaigns</a></li>
@stop





@include('partials.header')











@section('links')
  <a href="{{ url('campaigns/create') }}" class="button radius small">Add Campaign</a>

  <button href="#" data-dropdown="drop1" aria-controls="drop1" aria-expanded="false"
          class="button tiny radius dropdown">
    Showing: Active
  </button>
  <ul id="drop1" data-dropdown-content class="f-dropdown" aria-hidden="true">
    <li><a href="{{ url('campaigns') }}">Active Campaigns</a></li>
    <li><a href="{{ url('campaigns/archived') }}">Archived Campaigns</a></li>
  </ul>
@stop





@section('content')
  <div id="campaigns_list" class="row" data-equalizer>
    <div id="campaigns_list_container" class="small-12 columns">

      @if ( ! $campaigns->isEmpty() )
        @include('campaigns.charts.list')
      @else
        <div id="campaigns_list_empty" class="text-center">
          <h3>You have no active campaigns!<br>Create one above or ask an admin to add you.</h3>
        </div>
      @endif
    </div>
  </div>
@stop