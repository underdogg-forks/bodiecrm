{{-- Lead meta details --}}

<ul class = "small-block-grid-4">
    <li class = "">
        <h5>Title</h5>

        @if ( $lead->title != '' )
        <h4>{{ $lead->title }}</h4>
        @else
        <h4><span class = "lighter">Not available</span></h4>
        @endif
    </li>

    <li class = "">
        <h5>Email</h5>

        @if ( $lead->email != '' )
        <h4><a href = "mailto:{{ $lead->email }}">{{ $lead->email }}</a></h4>
        @else
        <h4><span class = "lighter">Not available</span></h4>
        @endif
    </li>

    <li class = "">
        <h5>Phone</h5>

        @if ( $lead->phone != '' )
        <h4>{{ $lead->phone }}</h4>
        @else
        <h4><span class = "lighter">Not available</span></h4>
        @endif
    </li>

    <li class = "">
        <h5>Company</h5>

        @if ( $lead->phone != '' )
        <h4>{{ $lead->company }}</h4>
        @else
        <h4><span class = "lighter">Not available</span></h4>
        @endif
    </li>
</ul>