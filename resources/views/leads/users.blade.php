{{-- Lead Users view --}}

@if ( ! $lead->users->isEmpty() )
    <div class = "leads_single_users_owners inline">
        @foreach ( $owners as $owner )
            <div class = "leads_single_users_list inline">
                <div class = "inline avatar">
                    <a class = "th" href = "{{ url('users/' . $owner->id) }}">
                        @if ( is_null($owner->profile_url) )
                        <img src = "{{ asset('img/default.png') }}" class = "owner" data-tooltip aria-haspopup = "true" class = "has-tip tip-top" title = "{{ Lang::get('lead.owner') }}" />
                        @else
                        <img src = "{{ asset('img/user/' . $owner->id . '/' . $owner->profile_url) }}" class = "owner" />
                        @endif
                    </a>
                </div>

                <div class = "inline text-left">
                    <span class = "small">Owner</span>
                    <br>
                    <a href = "{{ url('users/' . $owner->id) }}">
                        <h5>{{ $owner->fullname }}</h5>
                    </a>
                </div>
            </div>
        @endforeach
    </div>

    @if ( ! $watchers->isEmpty() )
    <div class = "leads_single_users_watchers inline">
        <div class = "inline text-left">
            <span class = "small">Watchers</span>

            <div>
            @foreach ( $watchers as $watcher )
                <div class = "leads_single_users_list inline">
                    <div class = "inline avatar">
                        <a class = "th" href = "{{ url('users/' . $watcher->id) }}">
                            @if ( is_null($watcher->profile_url) )
                            <img src = "{{ asset('img/default.png') }}" class = "watcher" data-tooltip aria-haspopup = "true" class = "has-tip tip-top" title = "{{ $watcher->fullname }}" />
                            @else
                            <img src = "{{ asset('img/user/' . $watcher->id . '/' . $watcher->profile_url) }}" class = "watcher" />
                            @endif
                        </a>
                    </div>                
                </div>
            @endforeach
            </div>
        </div>
    </div>
    @endif
    
    @if ( $has_admin_access )
    <div class = "inline">
        <a href = "{{ url('leads/' . $lead->id . '/assign_lead') }}">[manage]</a>
    </div>
    @endif

@else

    @if ( $has_admin_access )
    <div class = "name inline">
        <h5>
            <strong><i class = "fa fa-exclamation red"></i>&nbsp;&nbsp;This lead is currently not assigned to anyone. Click <a href = "{{ url('leads/' . $lead->id . '/assign_lead') }}" class = "underline">here</a> to assign an owner.</strong>
        </h5>
    </div>
    @endif
@endif