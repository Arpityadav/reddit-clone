@extends('layouts.app')

@section('content')
<div class="flex-column">
    <div class="flex-col m-6">

        <div class="flex">
            <div class="flex-none items-center">
                <img src="{{ $thread->user->gravatar }}" class="border border-gray-400 mt-2" style="max-height: 40px; border-radius: 14px;">
            </div>
            <div class="flex-column items-center ml-4">
                <h2 class="text-2xl text-gray-800">{{$thread->title}}</h2>

                <div class="flex-column">
                    <small class="text-sm text-gray-700">submitted {{ $thread->created_at->diffForHumans() }} by {{ $thread->user->name }} with {{ $thread->comment->count() }} {{str_plural('reply', $thread->comment->count())}}</small>
                </div>
            </div>
        </div>

        <div class="flex">
            <div class="m-2 ml-8">
                <p class="text-gray-800 ">{{$thread->description}}</p>
            </div>
        </div>

    </div>

    <hr>
    <div class="mt-4">
    <h2>Comments</h2>

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
            @include('threads.comment.list', ['collection' => $comments['root']])
        @else
            <p>No replies yet.</p>
        @endif
    </div>
</div>

@endsection
