<?php

namespace App\Http\Controllers;

use App\Thread;

class ThreadsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->only('create', 'store');
    }

    public function index()
    {
        $threads = \App\Thread::all();

        return view('threads.index', compact('threads'));
    }

    public function create()
    {
        return view('threads.create');
    }

    public function store()
    {
        $attributes = request()->validate([
            'title' => 'required',
            'description' => 'required'
        ]);

        $thread = auth()->user()->thread()->create($attributes);

        return redirect($thread->path());
    }

    public function show(Thread $thread)
    {
        if (($thread->comment->count())){
            $thread->sortComments();

            return view('threads.show', compact('thread', 'comments'));
        }

        return view('threads.show', compact('thread'));
    }
}
