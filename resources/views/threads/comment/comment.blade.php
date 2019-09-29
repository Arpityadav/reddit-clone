<li class="{{ isset($isReply) ? 'ml-10 my-2' : '' }}">
    <div class="flex border-l-2">

        <div class=" comments">
            <form action="/comment/{{$comment->id}}/vote" method="POST">
                @csrf
                <input type="hidden" name="vote" value="upvote">
                <button type="submit" class="focus:outline-none">
                    <i class="material-icons {{ $comment->isUpvoted() ? 'text-blue-700' : '' }}">keyboard_arrow_up</i>
                </button>
            </form>

            <span class="ml-2">{{ $comment->getCurrentVotes($comment->id) }}</span>

            <form action="/comment/{{$comment->id}}/vote" method="POST">
                @csrf
                <input type="hidden" name="vote" value="downvote">
                <button type="submit" class="focus:outline-none">
                    <i class="material-icons {{ $comment->isDownvoted() ? 'text-blue-700' : '' }}">keyboard_arrow_down</i>
                </button>
            </form>
        </div>

        <div class="w-full ml-4">
            <small><a href="#" class="text-blue-700">{{ $comment->user->name}}</a></small>
            <small>{{ $comment->created_at->diffForHumans() }}</small>
            <p class="text-sm">{{ $comment->body }}</p>

            @include('threads.comment.form', ['parentId' => $comment->id,])

            @if(isset($comments[$comment->id]))
                @include('threads.comment.list', [
                    'collection' => $comments[$comment->id],
                    'isReply' => true
                ])
            @endif

            @include('partials.errors')
        </div>
    </div>

</li>
