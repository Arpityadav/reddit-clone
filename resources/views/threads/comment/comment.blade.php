<li class="{{ isset($isReply) ? 'ml-10 my-2' : '' }}">
    <div class="flex border-l-2">

        <vote :data="{{ $comment }}" model="comment"></vote>

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
