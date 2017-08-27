<div id="leads_single_default_fields" class="row">
  <dl data-equalizer-watch>
    <dt>Address:</dt>
    <dd>{{ $lead->address }}</dd>
  </dl>
  <dl data-equalizer-watch>
    <dt>City:</dt>
    <dd>{{ $lead->city }}</dd>
  </dl>
  <dl data-equalizer-watch>
    <dt>State:</dt>
    <dd>{{ $lead->state }}</dd>
  </dl>
  <dl data-equalizer-watch>
    <dt>Zip Code:</dt>
    <dd>{{ $lead->zip }}</dd>
  </dl>
  <dl data-equalizer-watch>
    <dt>Country:</dt>
    <dd>{{ $lead->country }}</dd>
  </dl>
</div>

@if ( count($lead->custom) > 0 )
  <div id="leads_single_other_fields" class="row">
    @foreach ( $lead->custom as $key => $value )
      <dl data-equalizer-watch>
        <dt>{{ ucwords($key) }}:</dt>
        <dd>{{ $value }}</dd>
      </dl>
    @endforeach
  </div>
@endif