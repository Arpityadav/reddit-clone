<?php

namespace App;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

trait Voteable
{

//    public static function bootVoteable()
//    {
//        if (Str::contains(url()->current(), 'comment')) {
//            $this->model = Comment::where('id', request()->route('comment'))->firstOrfail();
//        } elseif (Str::contains(url()->current(), 'thread')) {
//            $this->model = Thread::where('id', request()->route('comment'))->firstOrfail();
//        } else {
//            abort(404);
//        }
//
//    }

//    protected static $models = ['comment', 'thread'];
//
//    protected static $model;
//
//    public static function bootVoteable()
//    {
//        foreach (self::$models as $model) {
//            if ($model === strtolower(str_replace('App\\', '', get_class($model)))) {
//                self::$model = $model;
//            }
//        }
//    }
//
//    protected $model;
//
//    public function __construct(VotesServiceProvider $model)
//    {
//        $this->model = $model;
//    }
//

    public function getUpvotedAttribute()
    {
        return $this->isUpvoted();
    }
    public function isUpvoted()
    {
        return $this->votes()->where(['voteable_action' => true, 'user_id' => auth()->id()])->exists();
    }

    public function deleteVote($attributes)
    {
        DB::table('votes')->where($attributes)->delete();
    }

    public function downvote()
    {
        if (!$this->votes()->where(['user_id' => auth()->id()])->exists()) {
            $this->votes()->create([
                'user_id' => auth()->id(),
                'voteable_action' => false,
            ]);
        }
    }

    public function votes()
    {
        return $this->morphMany(Vote::class, 'voteable');
    }

    public function getDownvotedAttribute()
    {
        return $this->isDownvoted();
    }
    public function isDownvoted()
    {
        return $this->votes()->where(['voteable_action' => false, 'user_id' => auth()->id()])->exists();
    }

    public function upvote()
    {
        if (!$this->votes()->where(['user_id' => auth()->id()])->exists()) {
            $this->votes()->create([
            'user_id' => auth()->id(),
                'voteable_action' => true,
            ]);
        }
    }

    public function getVotesCountAttribute()
    {
        $votes = Vote::where([['voteable_id', '=', $this->id], ['voteable_type', '=' , get_class($this)]])->get();

        $upvotes = 0;
        $downvotes = 0;

        if ($votes) {
            foreach ($votes as $vote) {
                if ($vote->voteable_action) {
                    $upvotes++;
                } elseif (!$vote->voteable_action) {
                    $downvotes++;
                }
            }

            return $upvotes - $downvotes;
        }
    }
}
