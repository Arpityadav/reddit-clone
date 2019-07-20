<form method="POST" action="/threads/{{$thread->id}}/comment">
    @csrf

    <textarea id="body"
          class="input bg-transparent border border-grey-light rounded p-2 text-xs w-full"
          name="body"
          required></textarea>

    @if(isset($parentId))
        <input type="hidden" name="reply_to_id" value="{{ $parentId }}">
    @endif

    <div class="field mb-6">
        <div class="col-md-8 offset-md-4">
            <button type="submit" class="bg-blue-400 text-white px-4 py-2 b mr-2">
                Comment
            </button>
        </div>
    </div>
</form>