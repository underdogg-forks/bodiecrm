@extends('layouts.home')





@section('title')
  Campaign - View
@stop




@section('subtitle')
  @if ( ! $campaign->active )
    <span data-tooltip aria-haspopup="true" class="has-tip tip-right" title="{{ Lang::get('campaign.archived') }}"><i
        class="fa fa-lock"></i></span>
  @endif

  <a href="{{ url('campaigns/' . $campaign->id) }}">{{ $campaign->title }}</a>

  <p>{{ $campaign->description }}</p>
@stop




@section('breadcrumb')
  <li><a href="{{ url('campaigns') }}">All Campaigns</a></li>
  <li class="active"><a href="{{ url('campaigns/' . $campaign->id) }}">{{ $campaign->title }}</a></li>
@stop





@section('dates')



  {{ $campaign->created_at->timezone($user->timezone)->toDayDateTimeString() }}
@stop





@include('partials.header')







@section('links')
  @if ( $has_admin_access )
    <button href="#" data-dropdown="drop1" aria-controls="drop1" aria-expanded="false" class="button radius dropdown">
      <i class="fa fa-wrench"></i>
    </button>
    <ul id="drop1" data-dropdown-content class="f-dropdown" aria-hidden="true">

      @if ( $campaign->active )
        <li><a href="{{ url('campaigns/' . $campaign->id) }}/edit">Edit campaign details</a></li>
        <li><a href="{{ url('campaigns/' . $campaign->id) }}/add_landing_page">Add landing page</a></li>
        <li class="divider"></li>
      @endif

      @if ( $campaign->active )
        <li><a href="{{ url('campaigns/' . $campaign->id) }}/archive">Archive campaign</a></li>
      @else
        <li><a href="{{ url('campaigns/' . $campaign->id) }}/unarchive">Un-archive campaign</a></li>
      @endif
    </ul>
  @endif

  <button class="button small radius comment-button"><i class="fa fa-commenting"></i>{{ $campaign->comments->count() }}
  </button>
@stop





@section('comments')
  @include('campaigns.comments')
@stop





@section('content')

  <div id="campaign_single" class="row">

    <div id="campaign_single_meta" class="meta small-12 columns">
      @include('campaigns.meta')
    </div>


    <div id="campaign_single_charts_main" class="small-12 columns">
      @include('campaigns.charts.main')
    </div>


    <div id="campaign_single_charts_attribution" class="small-12 columns">
      @include('campaigns.charts.attribution')
    </div>


    <div id="campaign_single_landing_pages" class="small-12 columns" data-equalizer>
      @include('campaigns.landing_pages')
    </div>

  </div>
@stop