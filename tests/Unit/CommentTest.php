<?php

namespace Tests\Unit;

use App\Comment;
use App\Thread;
use Illuminate\Database\Eloquent\Collection;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CommentTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_can_be_replied()
    {
        $thread = factory('App\Thread')->create();

        $comment = $thread->addComment('Foo Comment');

        $comment->reply('Replying to Foo Comment');

        $this->assertCount(1, $comment->replies);
    }
    
    /** @test */
    public function it_has_many_replies()
    {
        $thread = factory('App\Thread')->create();

        $comment = $thread->addComment('Foo Comment');

        $this->assertInstanceOf(Collection::class, $comment->replies);
    }

    /** @test */
    public function it_knows_its_parent()
    {
        $thread = factory('App\Thread')->create();
        $comment = $thread->addComment('Foo Comment');

        $this->assertNull($comment->parent);

        $comment->reply('Reply to Foo Comment');

        $this->assertTrue($comment->replies()->first()->parent->is($comment));
    }

    /** @test */
    public function replies_belongs_to_a_comment()
    {
        $thread = factory('App\Thread')->create();
        $comment = $thread->addComment('Foo Comment');


        $reply = $comment->reply('Replying to Foo Comment');

        $this->assertInstanceOf(Comment::class, $reply->parent);
    }

    /** @test */
    public function it_belongs_to_a_thread()
    {
        $thread = factory('App\Thread')->create();
        $comment = $thread->addComment('Foo Comment');

        $this->assertInstanceOf(Thread::class, $comment->thread);
    }
}
