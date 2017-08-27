@extends('layouts.home')





@section('title')
  User
@stop




@section('subtitle')
  Change Your Password
@stop




@section('breadcrumb')
  <li><a href="{{ url('user') }}">You</a></li>
  <li class="active"><a href="{{ url('user/' . $user->id . '/change_password') }}">Change Password</a></li>
@stop






@include('partials.header')





@section('content')
  <div id="user_profile_change_password" class="row">
    <div class="small-12 columns">
      <p>Note: You will be logged out.</p>

      <form method="POST" action="{{ url('user/' . $user->id . '/change_password') }}" class="row" data-abide>

        {!! csrf_field() !!}

        <input type="hidden" name="_method" value="PUT"/>

        <div class="small-12 columns">
          <label for="current_password">Current Password</label>
          <input type="password" name="current_password" required pattern="[a-zA-Z]+"/>
          <small class="error">Your current password is required</small>
        </div>

        <div class="small-12 columns">
          <label for="password">
            New Password
            <div class="right">
              <span class="label">Minimum 8 characters</span>
            </div>
          </label>
          <input type="password" name="password" required pattern="[a-zA-Z]+"/>
          <small class="error">New password is required.</small>
        </div>

        <div class="small-12 columns">
          <label for="password_confirmation">Current Password</label>
          <input type="password" name="password_confirmation" required pattern="[a-zA-Z]+" data-equalto="password"/>
          <small class="error">The password did not match.</small>
        </div>

        <div class="small-12 columns">
          <input type="submit" value="Update Password" class="button large radius success large-4 columns"/>
        </div>
      </form>
    </div>
  </div>
@stop