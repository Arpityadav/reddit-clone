<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ThreadCommentsTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function an_authenticated_user_can_comment_to_a_thread()
    {
        $this->signIn();
        $thread = factory('App\Thread')->create();

        $this->post($thread->path().'/comment', ['body' => 'Foo Comment']);

        $this->assertCount(1, $thread->comment);
    }

    /** @test */
    public function guests_cannot_comment_to_a_thread()
    {
        $this->post('threads/1/comment', [])
            ->assertRedirect('/login');
    }

    /** @test */
    public function an_authenticated_user_can_reply_to_a_comment()
    {
        $this->signIn();
        $thread = factory('App\Thread')->create();

        $comment = $thread->addComment('Foo Comment');

        $this->post($thread->path().'/comment', [
            'body' => 'Replying to Foo Comment',
            'reply_to_id' => $comment->id
        ]);

        $this->assertCount(2, $thread->comment);

        $this->assertTrue($thread->comment->last()->parent->is($comment));
    }

    /** @test */
    public function a_comment_requires_a_body()
    {
        $this->signIn();
        $comment = factory('App\Comment')->raw(['body' => '']);

        $this->post('threads/1/comment', $comment)->assertSessionHasErrors('body');
    }


}
