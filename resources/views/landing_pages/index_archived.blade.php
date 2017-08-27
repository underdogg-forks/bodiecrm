@extends('layouts.home')





@section('title')
  Landing Pages - List
@stop





@section('subtitle')
  <i class="fa fa-lock"></i> Your Archived Landing Pages

  <p>Below are all of your archived landing pages.</p>
@stop





@section('breadcrumb')
  <li class="active"><a href="{{ url('landing_pages') }}">All Landing Pages</a></li>
@stop





@include('partials.header')






@section('links')
  <button href="#" data-dropdown="drop1" aria-controls="drop1" aria-expanded="false"
          class="button tiny radius dropdown">
    Showing: Archived
  </button>
  <ul id="drop1" data-dropdown-content class="f-dropdown" aria-hidden="true">
    <li><a href="{{ url('landing_pages') }}">Active Landing Pages</a></li>
    <li><a href="{{ url('landing_pages/archived') }}">Archived Landing Pages</a></li>
  </ul>
@stop





@section('content')
  <div id="landing_pages_list" class="row" data-equalizer>
    <div id="landing_pages_list_container" class="small-12 columns">

      @if ( ! $landing_pages->isEmpty() )
        @include('landing_pages.charts.list')
      @else
        <div id="landing_pages_list_empty" class="text-center">
          <h3>You have no archived landing pages.</h3>
        </div>
      @endif
    </div>
  </div>
@stop