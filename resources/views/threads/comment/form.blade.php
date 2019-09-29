@auth
    <form method="POST" action="/threads/{{$thread->id}}/comment" class="w-full my-2">
        @csrf

        <input type="text" name="body" id="body" class="input bg-transparent border border-grey-light rounded p-2 text-xs w-full" placeholder="Press Enter to leave your comment.">

        @if(isset($parentId))
            <input type="hidden" name="reply_to_id" value="{{ $parentId }}">
        @endif
    </form>
@endauth

