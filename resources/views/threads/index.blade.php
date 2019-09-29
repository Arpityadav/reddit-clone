@extends('layouts.app')

@section('content')
    @forelse($threads as $thread)
        <div class="content-center">
            <a href="{{ $thread->path() }}">

                <div class="border p-4 flex flex-col justify-between leading-normal">
                    <div class="mb-8">
                        <div class="text-gray-900 font-bold text-xl mb-2">{{ $thread->title }}</div>
                        <p class="text-gray-700 text-base">{{ $thread->description }}</p>
                    </div>
                    <div class="flex items-center">
                        <img class="w-10 h-10 rounded-full mr-4" src="/img/jonathan.jpg" alt="Avatar of {{ $thread->user->name }}">
                        <div class="text-sm">
                            <p class="text-gray-900 leading-none">{{ $thread->user->name }}</p>
                            <p class="text-gray-600">{{ $thread->created_at->diffForHumans() }}</p>
                        </div>
                    </div>
                </div>
            </a>
        </div>
    @empty
        <p>No threads created.</p>
    @endforelse
@endsection
