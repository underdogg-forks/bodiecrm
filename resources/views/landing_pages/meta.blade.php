{{-- Landing Page meta details --}}

<div id="owner" class="small-6 columns">
  <div class="inline">
    <a class="th" href="{{ url('user/' . $user->id) }}">

      @if ( is_null($landing_page->user->profile_url) )
        <img src="{{ asset('img/default.png') }}"/>
      @else
        <img src="{{ asset('img/user/' . $landing_page->user->id . '/' . $landing_page->user->profile_url) }}"/>
      @endif
    </a>
  </div>

  <div class="name inline top">
    <h5>
      <strong>Owner</strong>: <a href="{{ url('user/' . $user->id) }}">{{ $landing_page->user->fullname }}</a></h5>
    <p>{{ $landing_page->user->company }}</p>
  </div>
</div>


<div id="lead_counts" class="small-6 columns">
  <div class="small-6 columns">
    <h5>Total leads, past month</h5>
    <h3>{{ is_null($landing_page->leads_sum) ? '0' : number_format($landing_page->leads_sum) }}</h3>
  </div>
  <div class="small-6 columns">
    <h5>Total leads, lifetime</h5>
    <h3>{{ number_format($landing_page->leads->count()) }}</h3>
  </div>
</div>