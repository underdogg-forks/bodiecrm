<form id = "comment_submit" method = "POST" action = "{{ url('landing_pages/' . $landing_page->id . '/add_comment') }}" class = "row" data-abide>

    {!! csrf_field() !!}

    <textarea name = "comment" placeholder = "Share your thoughts" required></textarea>
    <small class = "error">Please add a comment</small>

    <button class = "button small right">Submit</button>
</form>



<div id = "comments_block" class = "row">
    @if ( $landing_page->comments->count() > 0 )
        @foreach ( $landing_page->comments as $comment )
            <div class = "comment_item">
                <span data-tooltip aria-haspopup = "true" class = "has-tip tip-right" title = "{{ $comment->user->fullname }}">
                    @if ( is_null($comment->user->profile_url) )
                    <img src = "{{ asset('img/default.png') }}" class = "th" />
                    @else
                    <img src = "{{ asset('img/user/' . $comment->user->id . '/' . $comment->user->profile_url) }}" class = "th" />
                    @endif
                </span>

                <h5 class = "inline">{{ $comment->user->fullname }}</h5>
                <span class = "inline date">{{ $comment->created_at->timezone($user->timezone)->toFormattedDateString() }}</span>

                <div class = "comment_content">
                    {{ $comment->comment }}
                </div>
            </div>
        @endforeach
    @else
        <div class = "no_comments text-center"><h4>There are no comments</h4></div>
    @endif
</div>


<div id = "comment_clone" class = "comment_item animated hide">
    <span data-tooltip aria-haspopup = "true" class = "has-tip tip-right" title = ""></span>

    <h5 class = "inline"></h5>
    <span class = "inline date"></span>

    <div class = "comment_content"></div>
</div>