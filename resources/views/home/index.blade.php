@extends('layouts.home')



@section('title')
    Dashboard
@stop





@section('meta')
    <div id = "meta" class = "meta row">

        <div id = "owner" class = "small-4 columns">
            <div class = "inline">
                <a class = "th" href = "{{ url('user') }}">

                    @if ( is_null($user->profile_url) )
                    <img src = "{{ asset('img/default.png') }}">
                    @else
                    <img src = "{{ asset('img/user/' . $user->id . '/' . $user->profile_url) }}" />
                    @endif
                    
                </a>
            </div>

            <div class = "name inline top">
                <h4>{{ $user->first_name . ' ' . $user->last_name }}</h4>
                <p>{{ $user->company }}</p>
            </div>
        </div>

        <div id = "followers" class = "small-6 columns">
            <h5><strong>3</strong> people in your group</h5>

            <a class = "th">
                <img src = "{{ asset('img/default.png') }}">
            </a>
            <a class = "th">
                <img src = "{{ asset('img/default.png') }}">
            </a>
            <a class = "th">
                <img src = "{{ asset('img/default.png') }}">
            </a>

            <a href = "#">[+ invite more]</a>
        </div>
    </div>
@stop







@section('content')
    <div class = "small-12 medium-6 columns">
        <h3>ONE</h3>
        <p>Latest leads</p>
    </div>

    <div class = "small-12 medium-6 columns">
        <h3>TWO</h3>
        <p>Lead volume in past week</p>
    </div>

    <div class = "small-12 medium-6 columns">
        <h3>THREE</h3>
        <p>Lead volume in past week by medium</p>
    </div>

    <div class = "small-12 medium-6 columns">
        <h3>FOUR</h3>
        <p>Lead with most activity in past week</p>
    </div>

    <div class = "small-12 medium-6 columns">
        <h3>FIVE</h3>
        <p>Best performing landing page</p>
    </div>

    <div class = "small-12 medium-6 columns">
        <h3>SIX</h3>
        <p>Worst performing landing page</p>
    </div>

    <div class = "small-12 medium-6 columns">
        <h3>SEVEN</h3>
        <p>Best performing medium</p>
    </div>

    <div class = "small-12 medium-6 columns">
        <h3>EIGHT</h3>
        <p>Worst performing medium</p>
    </div>
@stop



