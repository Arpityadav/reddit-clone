<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class VotesTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function guests_cannot_vote_a_comment()
    {
        $this->post('/comment/1/vote')
            ->assertRedirect('/login');
    }

    /** @test */
    public function an_authenticated_user_can_upvote_a_comment()
    {
        $this->signIn();

        $thread = factory('App\Thread')->create();
        $comment = $thread->addComment('A comment');

        $this->post('/comment/'. $comment->id .'/vote');

        $this->assertCount(1, $comment->votes);
    }
//
//    /** @test */
//    public function an_authenticated_user_can_downvote_a_comment()
//    {
//        $this->signIn();
//
//        $thread = factory('App\Thread')->create();
//        $comment = $thread->addComment('A comment');
//
//        $this->post('/comment/'. $comment->id .'/vote');
//
//        $this->assertCount(1, $comment->votes);
//
//        $this->post('/comment/'. $comment->id .'/vote');
//
//        $this->assertCount(1, $comment->votes);
//
//    }

    /** @test */
    public function a_comment_cannot_be_voted_twice()
    {
        $this->signIn();

        $thread = factory('App\Thread')->create();
        $comment = $thread->addComment('A comment');

        $this->post('/comment/'. $comment->id .'/vote');
        $this->post('/comment/'. $comment->id .'/vote');

        $this->assertCount(1, $comment->votes);
    }

}
