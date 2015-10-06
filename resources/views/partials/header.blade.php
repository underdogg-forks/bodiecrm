{{-- General header --}}

@section('meta')
    <div id = "meta" class = "row">
        
        <div id = "title" class = "breadcrumb left">
            
        </div>

        <div id = "me" class = "right">
            <div class = "inline">
                <a class = "th" href = "{{ url('user') }}">

                    @if ( is_null($user->profile_url) )
                    <img src = "{{ asset('img/default.png') }}" >
                    @else
                    <img src = "{{ asset('img/user/' . $user->id . '/' . $user->profile_url) }}" />
                    @endif
                </a>
            </div>

            <a href = "{{ url('user') }}">{{ $user->fullname }}</a>
        </div>
    </div>
@stop