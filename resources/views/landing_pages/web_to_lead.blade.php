@extends('layouts.home')




@section('title')
    Landing Pages - Web to Lead
@stop




@section('subtitle')
    <a href = "{{ url('landing_pages/' . $landing_page->id) }}">{{ $landing_page->title }}</a>
@stop




@section('breadcrumb')
    <li><a href = "{{ url('campaigns') }}">All Campaigns</a></li>
    <li><a href = "{{ url('campaigns/' . $landing_page->campaign->id) }}">{{ $landing_page->campaign->title }}</a></li>
    <li><a href = "{{ url('landing_pages/' . $landing_page->id) }}">{{ $landing_page->title }}</a></li>
    <li class = "active"><a href = "{{ url('landing_pages/' . $landing_page->id . '/web_to_lead') }}">Web-to-Lead</a></li>
@stop






@include('partials.header')






@section('links')
    
@stop





@section('content')
    <div id = "landing_page_single_web_to_lead" class = "row">
        <div class = "small-12 columns">
            <p>
                The <span data-tooltip aria-haspopup = "true" class = "has-tip tip-right" title = "{{ Lang::get('landing_page.w2l') }}">web to lead <i class = "fa fa-question-circle"></i></span> form code to be placed on your web page, in order to capture lead submissions.
            </p>

            <p>
                Please note: Lead submissions will be validated after submission, but you should always implement some checks before allowing users to submit as well.
            </p>



            <div>
                <pre><code class = "language-markup">
&lt;form id="{{ $landing_page->auth_key }}" method="POST" action="{{ url('submit') }}">
    &lt;input type="hidden" name="landing_page_id" value="{{ $landing_page->id }}" />
    &lt;input type="hidden" name="auth_key" value="{{ $landing_page->auth_key }}" />
&lt;/form></code></pre>
            </div>

            <div>
                <pre><code class = "language-markup">
&lt;!--
     GOOGLE UNIVERSAL ANALYTICS                                                             
     Place the below code at the bottom of your page, right before the closing &lt;/body> tag 
-->
&lt;script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-68533912-1', { 'cookieDomain': 'none' });
  ga('require', 'Attribution', {
    form_id:            '{{ $landing_page->auth_key }}',
    landing_page_id:    'landing_page_id',
    auth_key:           'auth_key',
    email:              'email',
    hours:              0,
    minutes:            30,
    months:             6,
    days:               0
  });

  ga('send', 'pageview');
&lt;/script>
&lt;script async src = "{{ asset('js/attribution.min.js') }}">&lt;/script></code></pre>
            </div>
        </div>
    </div>
@stop
    