<li class="{{ isset($isReply) ? 'ml-10' : '' }}">
    <div class="ml-4">

        <form action="/comment/{{$comment->id}}/vote" method="POST">
            @csrf
            <input type="hidden" name="vote" value="upvote">
            <button type="submit" class="{{ $comment->isUpvoted() ? 'underline' : '' }}" >Upvote</button>
        </form>

        <form action="/comment/{{$comment->id}}/vote" method="POST">
            @csrf
            <input type="hidden" name="vote" value="downvote">
            <button type="submit" class="{{ $comment->isDownvoted() ? 'underline' : '' }}">Downvote</button>
        </form>

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
