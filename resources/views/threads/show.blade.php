@extends('layouts.app')

@section('content')
<div class="flex-column">
    <div class="flex m-6">

        <div class="flex-none items-center">
            <img src="{{ $thread->user->gravatar }}" class="rounded-full" style="max-height: 40px;">
        </div>
        <div class="flex-column">
            <h2 class="text-4xl text-gray-800">{{$thread->title}}</h2>
        </div>

    </div>

    <div class="flex">
        <div class="flex-none items-center">
            <i class="material-icons">
                thumb_up_alt
            </i>
        </div>
        <div class="flex-column">
            <p class="text-gray-800 ">{{$thread->description}}</p>
            <span class="text-sm text-gray-700">Submitted {{ $thread->created_at->diffForHumans() }} by {{ $thread->user->name }}</span>
            <span class="text-sm text-gray-700">234 comments</span>
        </div>
    </div>
    <hr>
    <div class="mt-4">
    <h2>Comments</h2>

<<<<<<< HEAD
        @if(isset($thread->comment))
=======
        @guest
            <p class="border border-gray-200 my-3 pl-2 py-4 text-gray-800">What are your thoughts? <a href="/login" class="text-blue-700">Log in</a> or <a href="/register" class="text-blue-700">Sign up</a></p>
        @endguest

        @auth
            @include('threads.comment.form')
        @endauth

        <div class="border-b my-4 pb-2">
            <small class="text-uppercase text-gray-400">sort by</small>
            <Dropdown :class="'bp-dropdown inline text-blue-700 text-sm'">
                <template :class="'border-0 text-bold'" slot="btn">Latest</template>
                <template slot="body">
                    <ul>
                        <li><a href="#">Oldest</a></li>
                        <li><a href="#">Most Upvoted</a></li>
                        <li><a href="#">Most Discussed</a></li>
                    </ul>
                </template>
            </Dropdown>
        </div>

        @if(isset($comments))
>>>>>>> vote-system
            @include('threads.comment.list', ['collection' => $comments['root']])
        @else
            <p>No replies yet.</p>
        @endif
    </div>
</div>

@endsection
