<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    protected $guarded = [];


    public function reply($body)
    {
        $reply = new static(compact('body'));
        $reply->user_id = auth()->id();
        $reply->reply_to_id = $this->id;
        $reply->thread_id = $this->thread->id;

        $reply->save();
        return $reply;
    }

    public function thread()
    {
        return $this->belongsTo(Thread::class);
    }

    public function replies()
    {
        return $this->hasMany(Comment::class, 'reply_to_id');
    }

    public function parent()
    {
        return $this->belongsTo(Comment::class, 'reply_to_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function votes()
    {
        return $this->morphMany(Vote::class, 'voteable');
    }

    public function upvote()
    {
        if (! $this->votes()->where(['user_id' => auth()->id() ])->exists()) {
            $this->votes()->create([
                'user_id' => auth()->id(),
                'voteable_action' => true,
            ]);
        }
    }

//    public function downvote()
//    {
//        if (! $this->votes()->where(['user_id' => auth()->id() ])->exists()) {
//            $this->votes()->create([
//                'user_id' => auth()->id(),
//                'voteable_action' => false,
//            ]);
//        }
//    }

}
