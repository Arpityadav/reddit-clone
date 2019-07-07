@extends('layouts.app')

@section('content')
    <ul>
        @forelse($threads as $thread)
            <li>{{ $thread->title }}</li>
        @empty
            <p>No threads created.</p>
        @endforelse
    </ul>
@endsection