{{-- Landing Page other details view --}}

<div class = "small-6 columns">
    <strong><span data-tooltip aria-haspopup = "true" class = "has-tip tip-right" title = "{{ Lang::get('landing_page.auth_key') }}">Authentication key <i class = "fa fa-question-circle"></i> :</span></strong>
    {{ $landing_page->auth_key }}
</div>
<div class = "small-6 columns">
    <strong><span data-tooltip aria-haspopup = "true" class = "has-tip tip-right" title = "{{ Lang::get('landing_page.return_url') }}">Return URL <i class = "fa fa-question-circle"></i> :</span></strong> <a href = "{{ $landing_page->return_url }}" target = "_blank">{{ $landing_page->return_url }}</a>
</div>
<div class = "small-6 columns">
    <strong>Sending emails:</strong> {{ ($landing_page->send_email) ? 'Yes' : 'No' }}
</div>



@if ( $landing_page->send_email )
<div class = "small-6 columns">
    <strong>Email title:</strong>
    @if ( $landing_page->email_title )
        {{ $landing_page->email_title }}
    @else
        Lead submitted for {{ $landing_page->title }}&nbsp;&nbsp;<span class = "label">default</span>
    @endif
</div>

<div id = "emailing_to" class = "small-6 columns">
    <strong>Emailing to:</strong>&nbsp;
    @foreach ($landing_page->users_to_email as $users_to_email)
        <span data-tooltip aria-haspopup = "true" class = "has-tip tip-right" title = "{{ $users_to_email->fullname }}">
            @if ( is_null($users_to_email->profile_url) )
            <img src = "{{ asset('img/default.png') }}" class = "th" />
            @else
            <img src = "{{ asset('img/user/' . $users_to_email->id . '/' . $users_to_email->profile_url) }}" class = "th" />
            @endif
        </span>
    @endforeach
</div>
@endif