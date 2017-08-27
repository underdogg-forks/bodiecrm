<!-- Attribution -->
<!--
<dl data-equalizer-watch>
    <dt>Tracking ID:</dt>
    <dd>{{ $lead->attribution[0]->tracking_id }}</dd>
</dl>
<dl data-equalizer-watch>
    <dt></dt>
    <dd></dd>
</dl>
-->


<dl data-equalizer-watch>
  <dt>Converting Source:</dt>
  <dd>{{ $lead->attribution[0]->converting_source }}</dd>
</dl>
<dl data-equalizer-watch>
  <dt>Converting Medium:</dt>
  <dd>{{ $lead->attribution[0]->converting_medium }}</dd>
</dl>

@if ( strtolower($lead->attribution[0]->converting_source) != 'direct' )
  <dl data-equalizer-watch>
    <dt>Converting Keyword:</dt>
    <dd>{{ $lead->attribution[0]->converting_keyword }}</dd>
  </dl>
  <dl data-equalizer-watch>
    <dt>Converting Content:</dt>
    <dd>{{ $lead->attribution[0]->converting_content }}</dd>
  </dl>
  <dl data-equalizer-watch>
    <dt>Converting Campaign:</dt>
    <dd>{{ $lead->attribution[0]->converting_campaign }}</dd>
  </dl>
@endif

<dl data-equalizer-watch>
  <dt>Converting Landing Page:</dt>
  <dd>{!! $lead->attribution[0]->converting_landing_page !!}</dd>
</dl>


<dl data-equalizer-watch>
  <dt></dt>
  <dd></dd>
</dl>
<dl data-equalizer-watch>
  <dt></dt>
  <dd></dd>
</dl>
@if ( strtolower($lead->attribution[0]->converting_source) == 'direct' )
  <dl data-equalizer-watch>
    <dt></dt>
    <dd></dd>
  </dl>
  @endif


    <!-- Original Attibution -->
  <dl data-equalizer-watch>
    <dt>Original Source:</dt>
    <dd>{{ $lead->attribution[0]->original_source }}</dd>
  </dl>
  <dl data-equalizer-watch>
    <dt>Original Medium:</dt>
    <dd>{{ $lead->attribution[0]->original_medium }}</dd>
  </dl>

  @if ( strtolower($lead->attribution[0]->original_source) != 'direct' )
    <dl data-equalizer-watch>
      <dt>Original Keyword:</dt>
      <dd>{{ $lead->attribution[0]->original_keyword }}</dd>
    </dl>
    <dl data-equalizer-watch>
      <dt>Original Content:</dt>
      <dd>{{ $lead->attribution[0]->original_content }}</dd>
    </dl>
    <dl data-equalizer-watch>
      <dt>Original Campaign:</dt>
      <dd>{{ $lead->attribution[0]->original_campaign }}</dd>
    </dl>
  @endif

  <dl data-equalizer-watch>
    <dt>Original Landing Page:</dt>
    <dd>{!! $lead->attribution[0]->original_landing_page !!}</dd>
  </dl>



  <dl data-equalizer-watch>
    <dt></dt>
    <dd></dd>
  </dl>
  <dl data-equalizer-watch>
    <dt></dt>
    <dd></dd>
  </dl>
  @if ( strtolower($lead->attribution[0]->converting_source) == 'direct' )
    <dl data-equalizer-watch>
      <dt></dt>
      <dd></dd>
    </dl>
  @endif

  <dl data-equalizer-watch>
    <dt>Referring URL:</dt>
    <dd>{!! $lead->attribution[0]->refer_url !!}</dd>
  </dl>





