<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Thread extends Model
{
    use Commentable, Voteable;

    protected $guarded = [];

    public function path()
    {
        return "threads/{$this->id}";
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
