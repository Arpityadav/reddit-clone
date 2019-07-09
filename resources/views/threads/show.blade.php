@extends('layouts.app')

@section('content')
<div class="mx-auto">
    <div class="border flex-column">
        <h2 class="text-4xl text-gray-800">{{$thread->title}}</h2>
        <p class="text-gray-800 ">{{$thread->description}}</p>
        <span class="text-sm text-gray-700">Submitted {{ $thread->created_at->diffForHumans() }} by {{ $thread->user->name }}</span>
        <span class="text-sm text-gray-700">234 comments</span>
    </div>
</div>

@endsection