<li class="{{ isset($isReply) ? 'ml-10' : '' }}">
    <div class="ml-4">
        <small>{{ $comment->user->name}}</small>
        <small>{{ $comment->created_at->diffForHumans() }}</small>
        <p>{{ $comment->body }}</p>
    </div>

    @include('threads.comment.form', ['parentId' => $comment->id,])

    @if(isset($comments[$comment->id]))
        @include('threads.comment.list', [
            'collection' => $comments[$comment->id],
            'isReply' => true
        ])
    @endif
</li>