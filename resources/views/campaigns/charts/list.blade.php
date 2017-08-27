{{-- View for Campaign index main chart --}}

@foreach ( $campaigns as $campaign )

  <div class="small-12 columns">
    <div class="panel">
      <div class="row">
        <div class="small-8 columns">
          <h4><a href="{{ url('campaigns/' . $campaign->id) }}">{{ $campaign->title }}</a></h4>
        </div>
      </div>

      <div class="campaigns_list_details row">
        <div class="small-12 columns">
          <span class="date">{{ $campaign->created_at->toFormattedDateString() }}</span>
        </div>
      </div>


      @if ( ! $campaign->leads_data->isEmpty() )
        <canvas id="campaigns_list_chart_{{ $campaign->id }}" height="400"></canvas>
        <script>
          $(function () {
            var data{{ $campaign->id }} = {!! $campaign->leads_graph !!};
            var ctx{{ $campaign->id }}  = document.getElementById('campaigns_list_chart_{{ $campaign->id }}').getContext('2d');

            var myLineChart = new Chart(ctx{{ $campaign->id }}).Line(data{{ $campaign->id }});
          });
        </script>
      @else
        <div id="campaigns_list_chart_{{ $campaign->id }}"
             class="campaigns_list_chart_item panel animated fadeIn text-center">
          <h4>No leads in past month</h4>
        </div>
      @endif


      <div class="campaigns_list_owner row">
        <div class="small-10 columns">
          <div class="inline">
            <a class="th" href="{{ url('user/' . $campaign->user->id) }}">

              @if ( is_null($campaign->user->profile_url) )
                <img src="{{ asset('img/default.png') }}"/>
              @else
                <img src="{{ asset('img/user/' . $campaign->user->id . '/' . $campaign->user->profile_url) }}"/>
              @endif
            </a>
          </div>

          <div class="inline">
            <span class="small">Owner</span><br>
            <a href="{{ url('user/' . $campaign->user->id) }}">
              {{ $campaign->user->fullname }}
            </a>
          </div>

          <div id="campaigns_list_users" class="inline">
            <div class="inline top">
              <span class="small">Shared with</span><br>

              <div class="text-right">
                {{ $campaign->users->count() }}

                @if ( $campaign->users->count() == 1 )
                  {{ str_singular('person') }}
                @else
                  {{ str_plural('person') }}
                @endif
              </div>
            </div>

            <div id="campaigns_list_users_icons" class="inline">

              @foreach ( $campaign->users as $campaign_user )
                <span data-tooltip aria-haspopup="true" class="has-tip tip-right"
                      title="{{ $campaign_user->fullname }}">
                                    @if ( is_null($campaign_user->profile_url) )
                    <img src="{{ asset('img/default.png') }}" class="th"/>
                  @else
                    <img src="{{ asset('img/user/' . $campaign_user->id . '/' . $campaign_user->profile_url) }}"
                         class="th"/>
                  @endif
                                </span>
              @endforeach

            </div>
          </div>
        </div>

        <div class="icons small-2 columns text-right">
          <span data-tooltip aria-haspopup="true" class="has-tip tip-left" title="{{ Lang::get('campaign.comments') }}"><i
              class="fa fa-comments"></i> {{ number_format($campaign->comments->count()) }}</span>
          <span data-tooltip aria-haspopup="true" class="has-tip tip-left"
                title="{{ Lang::get('campaign.total_lead_count') }}"><i
              class="fa fa-file-text-o"></i> {{ number_format($campaign->leads->count()) }}</span>
        </div>
      </div>
    </div>
  </div>

@endforeach