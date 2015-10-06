{{-- View for Landing Page index main chart --}}

@foreach ( $landing_pages as $landing_page)

    <div class = "small-4 columns">
        <div class = "panel" data-equalizer-watch>
            <h4><a href = "{{ url('landing_pages/' . $landing_page->id) }}">{{ $landing_page->title }}</a></h4>

            <div class = "landing_page_list_details row">
                <div class = "small-12 columns">
                    <span class = "date">{{ $landing_page->created_at->toFormattedDateString() }}</span>

                    @if ( $landing_page->send_email )
                        <span data-tooltip aria-haspopup = "true" class = "has-tip tip-right" title = "{{ Lang::get('landing_page.email') }}"><i class = "fa fa-envelope"></i></span>
                    @endif
                </div>
            </div>

            @if ( ! $landing_page->leads_data->isEmpty() ) 
                <canvas id = "landing_page_list_chart_{{ $landing_page->id }}"></canvas>
                <script>
                    $(document).ready(function() {
                        var data_{{ $landing_page->id }}    = {!! $landing_page->leads_graph !!};

                        var ctx_{{ $landing_page->id }}     = document.getElementById('landing_page_list_chart_{{ $landing_page->id }}').getContext('2d');
                        
                        var barChart_{{ $landing_page->id }} = new Chart(ctx_{{ $landing_page->id }}).Bar(
                            data_{{ $landing_page->id }},
                            {
                                showScale: false
                            }
                        );
                    });
                </script>
            @else
                <div id = "landing_page_list_chart_{{ $landing_page->id }}" class = "landing_page_list_chart_item animated fadeIn text-center">
                    <h4>No leads</h4>
                </div>
            @endif

            <div class = "landing_page_list_owner row">
                <div class = "small-6 columns">
                    <div class = "inline">
                        <a class = "th" href = "{{ url('user/' . $landing_page->user->id) }}">

                            @if ( is_null($landing_page->user->profile_url) )
                            <img src = "{{ asset('img/default.png') }}" />
                            @else
                            <img src = "{{ asset('img/user/' . $landing_page->user->id . '/' . $landing_page->user->profile_url) }}" />
                            @endif
                        </a>
                    </div>

                    <a href = "{{ url('user/' . $landing_page->user->id) }}">
                        {{ $landing_page->user->fullname }}
                    </a>
                </div>

                <div class = "icons small-6 columns text-right">
                    <span data-tooltip aria-haspopup = "true" class = "has-tip tip-right" title = "{{ Lang::get('landing_page.comments') }}"><i class = "fa fa-comments"></i> {{ number_format($landing_page->comments->count()) }}</span>
                    <span data-tooltip aria-haspopup = "true" class = "has-tip tip-right" title = "{{ Lang::get('landing_page.total_lead_count') }}"><i class = "fa fa-file-text-o"></i> {{ number_format($landing_page->leads->count()) }}</span>
                </div>
            </div>
        </div>
    </div>
    
@endforeach