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
        $voteExists = Vote::where('user_id', 'voteable_id', 'voteable_type')->findOrFail();

        dd($voteExists);
        if ($voteExists) {
            $isUpvote = DB::table('votes')->where('voteable_action', '=', 1)->exists();

        }
        DB::table('votes')->where('voteable_action')->

        if ($voteNotExists) {
            return $comment->upvote();
        }

        return $comment->downvote();
    }
}
