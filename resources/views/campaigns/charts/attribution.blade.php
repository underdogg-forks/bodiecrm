{{-- Campaign Attribution Charts --}}

@foreach ( $campaign->attribution as $key => $value )
  <div id="campaign_single_{{ $key }}" class="small-3 columns text-center">
    <h5>
      <span data-tooltip aria-haspopup="true" class="has-tip tip-top" title="{{ Lang::get('landing_page.' . $key) }}">{{ ucwords(str_replace('_', ' ', $key)) }}
        <i class="fa fa-question-circle"></i></span>
    </h5>

    @if ( ! $value->isEmpty() )
      <canvas id="campaign_single_{{ $key }}_chart_{{ $campaign->id }}"></canvas>
      <div id="campaign_single_{{ $key }}_chart_{{ $campaign->id }}_legend" class="donut_legend"></div>


      <script>
        $(function () {
          var data_{{ $key }}     = {!! $value->toJson() !!};
          var ctx_atr_{{ $key }}  = document.getElementById('campaign_single_{{ $key }}_chart_{{ $campaign->id }}').getContext('2d');

          var pieChart_{{ $key }} = new Chart(ctx_atr_{{ $key }}).Pie(data_{{ $key }},
            {
              animationSteps: 60
            }
          );

          $('#campaign_single_{{ $key }}_chart_{{ $campaign->id }}_legend').html(pieChart_{{ $key }}.generateLegend());
        });
      </script>
    @else
      <div id="campaign_single_{{ $key }}_chart-{{ $campaign->id}}"
           class="campaign_single_donut_chart chart_no_data donut animated fadeIn">
        <h4>No data</h4>
      </div>
    @endif
  </div>
@endforeach