{{-- Campaign single main chart --}}

@if ( ! $campaign->leads_data->isEmpty() )
    <canvas id = "campaigns_single_chart" height = "400"></canvas>
    <script>
        $(function() {
            var data_campaigns_single = {!! $campaign->leads_graph !!};

            var ctx_campaigns_single = document.getElementById('campaigns_single_chart').getContext('2d');
            var myLineChart          = new Chart(ctx_campaigns_single).Line(data_campaigns_single);
        });
    </script>
@else
    <div id = "campaign_single_chart_{{ $campaign->id }}" class = "campaign_single_chart_item panel animated fadeIn text-center">
        <h4>No leads in past month</h4>
    </div>
@endif