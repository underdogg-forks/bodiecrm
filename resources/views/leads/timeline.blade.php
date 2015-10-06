{{-- Attribution visits --}}
@if ( $lead->attribution->count() > 0 )
<div class = "timeline-block row">
    <div class = "date">{{ $lead->attribution[0]->original_timestamp->timezone($user->timezone)->toDayDateTimeString() }}</div>

    <div class = "timeline-image">
        <i class = "fa fa-circle red"></i>
    </div>

    <div class = "timeline-content text-right" data-tooltip aria-haspopup = "true" class = "has-tip tip-top" title = "{{ Lang::get('lead.original_visit') }}">
        <span class = "activity">Original Visit</span>
        {{ $lead->attribution[0]->original_medium }}
    </div>
</div>

<div class = "timeline-block row">
    <div class = "date">{{ $lead->attribution[0]->converting_timestamp->timezone($user->timezone)->toDayDateTimeString() }}</div>

    <div class = "timeline-image">
        <i class = "fa fa-circle blue"></i>
    </div>

    <div class = "timeline-content text-left" data-tooltip aria-haspopup = "true" class = "has-tip tip-top" title = "{{ Lang::get('lead.converting_visit') }}">
        
        <span class = "activity">Converting Visit</span>
        {{ $lead->attribution[0]->converting_medium }}
    </div>
</div>
@endif




{{-- Other actions --}}
<div class = "timeline-block row">
    <div class = "date">{{ $lead->created_at->timezone($user->timezone)->toDayDateTimeString() }}</div>

    <div class = "timeline-image">
        <i class = "fa fa-circle green"></i>
    </div>

    <div class = "timeline-content text-right" data-tooltip aria-haspopup = "true" class = "has-tip tip-top" title = "{{ Lang::get('lead.submitted_lead') }}">
        
        <span class = "activity">Action</span>
        Submitted form
    </div>
</div>