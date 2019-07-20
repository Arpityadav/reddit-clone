<?php

namespace App;


trait Commentable
{

    public function addComment($body, $parentId = null)
    {
        if ($parentId) {
            return $this->comment()->findOrFail($parentId)->reply($body);
        }
        return $this->comment()->create([
            'user_id' => auth()->id(),
            'body' => $body
        ]);
    }

    public function comment()
    {
        return $this->hasMany(Comment::class);
    }

    public function sortComments()
    {
        $comments = $this->comment->groupBy('reply_to_id');
        $comments['root'] = $comments[''];

        unset($comments['']);
    }
}