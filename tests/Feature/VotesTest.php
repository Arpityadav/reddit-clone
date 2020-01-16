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
        $this->withoutExceptionHandling();
        $thread = factory('App\Thread')->create();
        $comment = $thread->addComment('A comment');

        $this->post('/comment/'. $comment->id .'/vote', [
            'vote'=> 'upvote',
            'model' => 'comment'
        ]);

        $this->assertCount(1, $comment->votes);
    }

    /** @test */
    public function an_authenticated_user_can_downvote_a_comment()
    {
        $this->signIn();

        $thread = factory('App\Thread')->create();
        $comment = $thread->addComment('A comment');

        $this->post('/comment/'. $comment->id .'/vote', [
            'vote'=> 'downvote',
            'model' => 'comment'
        ]);

        $this->assertCount(1, $comment->votes);
    }

    /** @test */
    public function a_vote_becomes_neutral_if_voted_twice_for_the_same_action()
    {
        $this->withoutExceptionHandling();
        $this->signIn();

        $thread = factory('App\Thread')->create();
        $comment = $thread->addComment('A comment');

        $this->post('/comment/'. $comment->id .'/vote', [
            'vote'=> 'upvote',
            'model' => 'comment'
        ]);
        $this->assertCount(1, $comment->votes);


        $this->post('/comment/'. $comment->id .'/vote', [
            'vote'=> 'upvote',
            'model' => 'comment'
        ]);

        $comment->refresh();

        $this->assertCount(0, $comment->votes);
    }

    /** @test */
    public function a_vote_can_be_deleted()
    {
        $this->signIn();

        $thread = factory('App\Thread')->create();
        $comment = $thread->addComment('A comment');

        $this->post('/comment/'. $comment->id .'/vote', [
            'vote' => 'upvote',
            'model' => 'comment'
        ]);

        $this->assertCount(1, $comment->votes);

        $comment->deleteVote($comment->votes()->first()->toArray());

        $comment->refresh();

        $this->assertCount(0, $comment->votes);
    }

    /** @test */
    public function a_user_can_only_upvote_or_downvote_a_comment()
    {
        $this->signIn();

        $thread = factory('App\Thread')->create();
        $comment = $thread->addComment('A comment');

        $this->post('/comment/'. $comment->id .'/vote', [
            'vote' => 'foobar',
            'model' => 'comment'
        ])
        ->assertStatus(403);
    }
}
