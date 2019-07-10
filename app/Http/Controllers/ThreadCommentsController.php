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
        if ($commentId = request('reply_to_id')) {
            $comment = Comment::findOrFail($commentId);
            $comment->reply(request('body'));
        }else {
            $thread->addComment(request('body'));
        }
    }
}
