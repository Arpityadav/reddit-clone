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

    public function store($id)
    {

        $this->getModel($id);

        $voteExists = Vote::where(['user_id' => auth()->id(), 'voteable_id' => $this->model->id, 'voteable_type' => get_class($this->model) ])->first();

        if (isset($voteExists)) {
            return $this->automateVote($voteExists);
        } elseif (request('vote') === 'upvote') {
            return $this->applyUpvote();
        } elseif (request('vote') === 'downvote') {
            return $this->applyDownvote();
        } else {
            abort(403);
        }
    }

    /**
     * @param $id
     */
    public function getModel($id): void
    {
        if (request()->model === 'comment') {
            $this->model = Comment::find($id);
        } else if (request()->model === 'thread') {
            $this->model = Thread::find($id);
        }
    }

    /**
     * @param $voteExists
     * @return array
     */
    public function automateVote($voteExists): array
    {
        if ($voteExists->voteable_action === true) {
            if (request('vote') === 'upvote') {
                $this->model->deleteVote($this->model->votes()->where('user_id', auth()->id())->first()->toArray());

                return [
                    'count' => $this->model->votesCount,
                    'isUpvoted' => false,
                    'isDownvoted' => false,
                ];
            } elseif (request('vote') === 'downvote') {
                $this->model->deleteVote($this->model->votes()->where('user_id', auth()->id())->first()->toArray());

                $this->model->downvote();

                return [
                    'count' => $this->model->votesCount,
                    'isUpvoted' => false,
                    'isDownvoted' => true,
                ];

            } else {
                abort(403);
            }
        } elseif ($voteExists->voteable_action === false) {
            if (request('vote') === 'downvote') {
                $this->model->deleteVote($this->model->votes()->where('user_id', auth()->id())->first()->toArray());
                return [
                    'count' => $this->model->votesCount,
                    'isUpvoted' => false,
                    'isDownvoted' => false,
                ];

            } elseif (request('vote') === 'upvote') {
                $this->model->deleteVote($this->model->votes()->where('user_id', auth()->id())->first()->toArray());

                $this->model->upvote();

                return [
                    'count' => $this->model->votesCount,
                    'isDownvoted' => false,
                    'isUpvoted' => true,
                ];

            } else {
                abort(403);
            }
        }
    }

    /**
     * @return array
     */
    public function applyUpvote(): array
    {
        $this->model->upvote();

        return [
            'count' => $this->model->votesCount,
            'isUpvoted' => true,
            'isDownvoted' => false,
        ];
    }

    /**
     * @return array
     */
    public function applyDownvote(): array
    {
        $this->model->downvote();

        return [
            'count' => $this->model->votesCount,
            'isDownvoted' => true,
            'isUpvoted' => false
        ];
    }
}
