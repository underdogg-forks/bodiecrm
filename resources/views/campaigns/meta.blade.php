{{-- Campaign single meta details --}}

<div id = "owner" class = "small-3 columns">
    <div class = "inline">
        <a class = "th" href = "{{ url('user/' . $user->id) }}">

            @if ( is_null($campaign->user->profile_url) )
            <img src = "{{ asset('img/default.png') }}" />
            @else
            <img src = "{{ asset('img/user/' . $campaign->user->id . '/' . $campaign->user->profile_url) }}" />
            @endif
        </a>
    </div>

    <div class = "name inline top">
        <h5>
            <strong>Owner</strong>: <a href = "{{ url('user/' . $user->id) }}">{{ $campaign->user->fullname }}</a></h5>
        <p>{{ $campaign->user->company }}</p>
    </div>
</div>

<div id = "followers" class = "small-3 columns">

    <h5>
        <strong>{{ $campaign->users->count() }}</strong>

        @if ( $campaign->users->count() == 1 )
            {{ str_singular('person') }}
        @else
            {{ str_plural('person') }}
        @endif
        
        with access
    </h5>

    @foreach ( $campaign->users as $follower )

        <span data-tooltip aria-haspopup = "true" class = "has-tip tip-right" title = "{{ $follower->fullname }}">
            @if ( is_null($follower->profile_url) )
            <img src = "{{ asset('img/default.png') }}" class = "th" />
            @else
            <img src = "{{ asset('img/user/' . $follower->id . '/' . $follower->profile_url) }}" class = "th" />
            @endif
        </span>

    @endforeach

    @if ( $has_admin_access )
        &nbsp;&nbsp;<a href = "{{ url('campaigns/' . $campaign->id) }}/add_users">[manage]</a>
    @endif
</div>


<div id = "landing_page_counts" class = "small-2 columns">
    <h5>Total landing pages</h5>
    <h3>{{ $campaign->landing_pages->count() }}
</div>



<div id = "lead_counts" class = "small-4 columns">
    <div class = "small-6 columns">
        <h5>Total leads, past month</h5>
        <h3>{{ number_format($campaign->landing_pages->sum('leads_sum')) }}</h3>
    </div>
    <div class = "small-6 columns">
        <h5>Total leads, lifetime</h5>
        <h3>{{ number_format($campaign->leads->count()) }}</h3>
    </div>
</div>