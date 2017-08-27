@extends('layouts.home')





@section('title')
  Leads - Edit
@stop





@section('subtitle')
  Edit lead details - {{ $lead->fullname }}
@stop





@section('breadcrumb')
  <li><a href="{{ url('leads') }}">All Leads</a></li>
  <li><a href="{{ url('leads/' . $lead->id) }}">{{ $lead->fullname }}</a></li>
  <li class="active"><a href="{{ url('leads/' . $lead->id . '/edit') }}">Edit Lead</a></li>
@stop





@section('dates')
  {{ $lead->created_at->timezone($user->timezone)->toDayDateTimeString() }}
@stop



@section('links')

@stop





@include('partials.header')








@section('content')

  <div id="leads_single_edit" class="row">
    <div class="small-12 columns" data-equalizer>
      <p>Edit this lead's details.</p>

      <form method="POST" action="{{ url('leads/' . $lead->id) }}" class="row" data-abide>
        {!! csrf_field() !!}

        <input type="hidden" name="_method" value="PUT">

        <div id="leads_single_edit_defaults">
          <div class="small-6 columns" data-equalizer-watch>
            <label for="first_name">First name</label>
            <input type="text" name="first_name" pattern='alpha' value="{{ $lead->first_name }}" placeholder="John"/>
            <small class="error">First name is required.</small>
          </div>

          <div class="small-6 columns" data-equalizer-watch>
            <label for="last_name">Last name</label>
            <input type="text" name="last_name" pattern='alpha' value="{{ $lead->last_name }}" placeholder="Doe"/>
            <small class="error">Last name is required.</small>
          </div>

          <div class="small-6 columns" data-equalizer-watch>
            <label for="email">Email</label>
            <input type="email" name="email" value="{{ $lead->email }}" placeholder="email@email.com"/>
            <small class="error">Email is required.</small>
          </div>

          <div class="small-6 columns" data-equalizer-watch>
            <label for="company">Company</label>
            <input type="text" name="company" value="{{ $lead->company }}" placeholder="Acme Company"/>
          </div>

          <div class="small-6 columns" data-equalizer-watch>
            <label for="title">Title</label>
            <input type="text" name="title" value="{{ $lead->title }}" placeholder="CEO"/>
          </div>

          <div class="small-6 columns" data-equalizer-watch>
            <label for="phone">Phone</label>
            <input type="text" name="phone" value="{{ $lead->phone }}" placeholder="(123) 456-7890"/>
          </div>

          <div class="small-6 columns" data-equalizer-watch>
            <label for="zip">Zip code</label>
            <input type="text" name="zip" pattern='number' value="{{ $lead->zip }}" placeholder="94102"/>
          </div>

          <div class="small-6 columns" data-equalizer-watch>
            <label for="address">Address</label>
            <textarea name="address" placeholder="345 Spear Street, Floor 4">{{ $lead->address }}</textarea>
          </div>

          <div class="small-6 columns" data-equalizer-watch>
            <label for="city">City</label>
            <input type="text" name="city" value="{{ $lead->city }}" placeholder="San Francisco"/>
          </div>

          <div class="small-6 columns" data-equalizer-watch>
            <label for="state">State</label>
            <input type="text" name="state" value="{{ $lead->state }}" placeholder="CA"/>
          </div>

          <div class="small-6 columns" data-equalizer-watch>
            <label for="country">Country</label>
            <input type="text" name="country" value="{{ $lead->country }}" placeholder="USA"/>
          </div>
        </div>

        @if ( $lead->other )
          <div id="leads_single_edit_custom">
            <div class="small-12 columns">
              <h4>Other details</h4>
            </div>

            @foreach ( $lead->other as $key => $value )
              <div class="small-6 columns" data-equalizer-watch>
                <label for="{{ $key }}">{{ ucwords($key) }}</label>
                <input type="text" name="custom[{{ $key }}]" value="{{ $value }}"/>
              </div>
            @endforeach
          </div>
        @endif

        <div class="small-12 columns">
          <input type="submit" value="Update Lead" class="button large radius small-4 columns"/>
        </div>
      </form>
    </div>
  </div>

@stop