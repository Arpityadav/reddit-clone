<ul>
    @foreach($collection as $comment)
        @include('threads.comment.comment')
    @endforeach
</ul>
