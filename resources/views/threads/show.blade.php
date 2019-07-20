@extends('layouts.app')

@section('content')
<div class="mx-auto">
    <div class="border flex-column">
        <h2 class="text-4xl text-gray-800">{{$thread->title}}</h2>
        <p class="text-gray-800 ">{{$thread->description}}</p>
        <span class="text-sm text-gray-700">Submitted {{ $thread->created_at->diffForHumans() }} by {{ $thread->user->name }}</span>
        <span class="text-sm text-gray-700">234 comments</span>
    </div>

    <hr>
    <div class="mt-4">
    <h2>Comments</h2>

        @if(isset($comment))
            @include('threads.comment.list', ['collection' => $comments['root']])
        @else
            <p>No replies yet.</p>
        @endif
    </div>
    @include('threads.comment.form')
</div>

@endsection