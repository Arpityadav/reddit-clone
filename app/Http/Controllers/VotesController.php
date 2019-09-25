<?php

namespace App\Http\Controllers;

use App\Comment;
use App\Vote;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class VotesController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function store(Comment $comment)
    {
        $voteExists = Vote::where(['user_id' => auth()->id(), 'voteable_id' => $comment->id, 'voteable_type' => get_class($comment) ])->first();

        if (isset($voteExists)) {

            if ($voteExists->voteable_action === true) {
                if (request('vote') === 'upvote') {
                    $comment->deleteVote($comment->votes()->first()->toArray());

                    return back();
                } elseif (request('vote') === 'downvote') {
                    $comment->deleteVote($comment->votes()->first()->toArray());

                    $comment->downvote();

                    return back();
                } else {
                    abort(403);
                }

            } elseif ($voteExists->voteable_action === false) {
                if (request('vote') === 'downvote') {
                    $comment->deleteVote($comment->votes()->first()->toArray());

                    return back();
                } elseif (request('vote') === 'upvote') {
                    $comment->deleteVote($comment->votes()->first()->toArray());

                    $comment->upvote();

                    return back();
                } else {
                    abort(403);
                }
            }
        } elseif ( request('vote') === 'upvote' ) {
            $comment->upvote();

            return back();
        } elseif ( request('vote') === 'downvote' ) {
            $comment->downvote();

            return back();
        } else {
            abort(403);
        }

    }
}
