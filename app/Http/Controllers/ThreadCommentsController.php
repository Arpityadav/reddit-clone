<?php

namespace App\Http\Controllers;

use App\Comment;
use App\Thread;
use Illuminate\Http\Request;

class ThreadCommentsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function store(Thread $thread)
    {
        request()->validate([
            'body' => 'required'
        ]);

        $thread->addComment(request('body'), request('reply_to_id'));

        return back();
    }
}
