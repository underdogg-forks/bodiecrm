@extends('layouts.home')





@section('title')
    Landing Pages - View
@stop





@section('subtitle')
    <a href = "{{ url('landing_pages/' . $landing_page->id) }}">{{ $landing_page->title }}</a>

    <p>{{ $landing_page->description }}</p>
@stop




@section('breadcrumb')
    <li><a href = "{{ url('campaigns') }}">All Campaigns</a></li>
    <li><a href = "{{ url('campaigns/' . $landing_page->campaign->id) }}">{{ $landing_page->campaign->title }}</a></li>
    <li class = "active"><a href = "{{ url('landing_pages/' . $landing_page->id) }}">{{ $landing_page->title }}</a></li>
@stop





@section('dates')
    {{ $landing_page->created_at->toFormattedDateString() }}
@stop






@include('partials.header')





@section('comments')
    @include('landing_pages.comments')
@stop




@section('links')
    <button href = "#" data-dropdown = "drop1" aria-controls = "drop1" aria-expanded = "false" class = "button radius dropdown">
        <i class = "fa fa-wrench"></i>
    </button>
    <ul id = "drop1" data-dropdown-content class = "f-dropdown" aria-hidden = "true">
        <li><a href = "{{ url('landing_pages/' . $landing_page->id) }}/web_to_lead">Show Web-to-lead code</a></li>

        @if ( $has_admin_access )
            <li><a href = "{{ url('landing_pages/' . $landing_page->id) }}/edit">Edit details</a></li>
        @endif
    </ul>

    <button class = "button small radius comment-button"><i class = "fa fa-commenting"></i>{{ $landing_page->comments->count() }}</button>
@stop



@section('content')

    <div id = "landing_page_single" class = "row">
        <div id = "landing_page_single_meta" class = "meta small-12 columns">
            @include('landing_pages.meta')
        </div>
        
        <div id = "landing_page_single_other_details" class = "small-12 columns">
            <div class = "row bg-gray">
                @include('landing_pages.other')
            </div>
        </div>

        <div id = "landing_page_charts_main" class = "small-12 columns">
            @include('landing_pages.charts.main')
        </div>

        <div id = "landing_page_single_charts_attribution" class = "small-12 columns">
            @include('landing_pages.charts.attribution')
        </div>
    </div>

@stop