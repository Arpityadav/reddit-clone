<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use Voteable;

    protected $appends = ['votesCount', 'upvoted', 'downvoted'];

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


    public function user()
    {
        return $this->belongsTo(User::class);
    }


    public function replies()
    {
        return $this->hasMany(Comment::class, 'reply_to_id');
    }

    public function parent()
    {
        return $this->belongsTo(Comment::class, 'reply_to_id');
    }
}
