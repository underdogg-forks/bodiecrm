<div id="leads_links">
  <div class="lead_follow inline">

    @if ( $watchers->contains($user->id) )
      <button class="button small unwatch" data-url="{{ url('leads/' . $lead->id . '/unwatch') }}"
              data-csrf="{!! csrf_token() !!}">
        {!! csrf_field() !!}
        <i class="fa fa-star"></i>Unwatch
      </button>
    @else
      <button class="button small watch" data-url="{{ url('leads/' . $lead->id . '/watch') }}"
              data-csrf="{!! csrf_token() !!}">
        <i class="fa fa-star"></i>Watch
      </button>
    @endif

    <button class="button small post-button">{{ $watchers->count() }}</button>
  </div>

  <div class="inline">
    <button href="#" data-dropdown="drop1" aria-controls="drop1" aria-expanded="false"
            class="button radius dropdown tiny">
      <i class="fa fa-wrench"></i>
    </button>
    <ul id="drop1" data-dropdown-content class="f-dropdown" aria-hidden="true">
      <li><a href="{{ url('campaigns/' . $lead->landing_page->campaign->id) }}">View Campaign</a></li>
      <li><a href="{{ url('landing_pages/' . $lead->landing_page->id) }}">View Landing Page</a></li>

      @if ( $has_admin_access )
        <li><a href="{{ url('leads/' . $lead->id) }}/edit">Edit lead details</a></li>
        <li><a href="{{ url('leads/' . $lead->id) }}/assign_lead">Manage lead users</a></li>
        <li class="divider"></li>
        <li><a href="{{ url('leads/' . $lead->id) }}/delete">Delete lead</a></li>
      @endif
    </ul>
  </div>

  <button class="button small radius comment-button"><i class="fa fa-commenting"></i>{{ $lead->comments->count() }}
  </button>
</div>