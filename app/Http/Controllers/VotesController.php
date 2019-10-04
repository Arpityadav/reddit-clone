<?php

namespace App\Http\Controllers;

use App\Comment;
use App\Thread;
use App\Vote;
use Illuminate\Support\Str;

class VotesController extends Controller
{

    protected $model;


    public function __construct()
    {
        $this->middleware('auth');
    }

    public function store()
    {
        if (Str::contains(url()->current(), 'comment')) {
            $this->model = Comment::where('id', request()->route('comment'))->firstOrfail();
        } elseif (Str::contains(url()->current(), 'thread')) {
            $this->model = Thread::where('id', request()->route('thread'))->firstOrfail();
        } else {
            abort(404);
        }


        $voteExists = Vote::where(['user_id' => auth()->id(), 'voteable_id' => $this->model->id, 'voteable_type' => get_class($this->model) ])->first();

        if (isset($voteExists)) {

            if ($voteExists->voteable_action === true) {
                if (request('vote') === 'upvote') {
                    $this->model->deleteVote($this->model->votes()->where('user_id', auth()->id())->first()->toArray());

                    return back();
                } elseif (request('vote') === 'downvote') {

                    $this->model->deleteVote($this->model->votes()->where('user_id', auth()->id())->first()->toArray());

                    $this->model->downvote();

                    return back();
                } else {
                    abort(403);
                }

            } elseif ($voteExists->voteable_action === false) {
                if (request('vote') === 'downvote') {
                    $this->model->deleteVote($this->model->votes()->where('user_id', auth()->id())->first()->toArray());

                    return back();
                } elseif (request('vote') === 'upvote') {
                    $this->model->deleteVote($this->model->votes()->where('user_id', auth()->id())->first()->toArray());

                    $this->model->upvote();

                    return back();
                } else {
                    abort(403);
                }
            }
        } elseif ( request('vote') === 'upvote' ) {
            $this->model->upvote();

            return back();
        } elseif ( request('vote') === 'downvote' ) {
            $this->model->downvote();

            return back();
        } else {
            abort(403);
        }

    }
}
