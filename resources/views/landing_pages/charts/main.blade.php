{{-- Landing Page single main chart --}}

@if ( ! $landing_page->leads_data->isEmpty() )
  <canvas id="landing_page_single_leads_chart"></canvas>
  <script>
    $(function () {
      var data_landing_page_single = {!! $landing_page->leads_graph !!};

      var ctx_lp_single = document.getElementById('landing_page_single_leads_chart').getContext('2d');
      var myLineChart = new Chart(ctx_lp_single).Line(data_landing_page_single);
    });
  </script>
@else
  <div id="landing_page_single_leads_chart"
       class="landing_page_single_leads_chart chart_no_data panel animated fadeIn text-center">
    <h4>No leads in past month</h4>
  </div>
@endif