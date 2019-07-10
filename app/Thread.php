<?php

namespace App;

use App\Comment;
use Illuminate\Database\Eloquent\Model;

class Thread extends Model
{
    protected $guarded = [];

    public function path()
    {
        return "threads/{$this->id}";
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function comment()
    {
        return $this->hasMany(Comment::class);
    }

    public function addComment($body)
    {
        return $this->comment()->create(compact('body'));
    }
}
