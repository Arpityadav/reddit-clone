<?php

namespace Tests\Unit;

use App\Comment;
use App\Thread;
use App\User;
use Illuminate\Database\Eloquent\Collection;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CommentTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_can_be_replied()
    {
        $this->signIn();

        $comment = factory('App\Comment')->create();

        $comment->reply('Replying to Foo Comment');

        $this->assertCount(1, $comment->replies);
    }
    
    /** @test */
    public function it_has_many_replies()
    {
        $comment = factory('App\Comment')->create();

        $this->assertInstanceOf(Collection::class, $comment->replies);
    }

    /** @test */
    public function it_knows_its_parent()
    {
        $this->signIn();

        $comment = factory('App\Comment')->create();
        $this->assertNull($comment->parent);

        $comment->reply('Reply to Foo Comment');

        $this->assertTrue($comment->replies()->first()->parent->is($comment));
    }

    /** @test */
    public function replies_belongs_to_a_comment()
    {
        $this->signIn();
        $comment = factory('App\Comment')->create();

        $reply = $comment->reply('Replying to Foo Comment');

        $this->assertInstanceOf(Comment::class, $reply->parent);
    }

    /** @test */
    public function it_belongs_to_a_thread()
    {
        $comment = factory('App\Comment')->create();

        $this->assertInstanceOf(Thread::class, $comment->thread);
    }

    /** @test */
    public function it_belongs_to_a_user()
    {
        $comment = factory('App\Comment')->create();

        $this->assertInstanceOf(User::class, $comment->user);
    }
}
