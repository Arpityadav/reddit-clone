<?php


namespace App;


interface PublisherInterface
{
    public function votes();
    public function upvote();
    public function downvote();
    public function deleteVote($attributes);
    public function isUpvoted();
    public function isDownvoted();
    public function getCurrentVotes($vote_id);
}
