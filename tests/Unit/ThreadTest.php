<?php

namespace Tests\Unit;

use App\User;
use Illuminate\Database\Eloquent\Collection;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ThreadTest extends TestCase
{
    use RefreshDatabase;
    
    /** @test */
    public function it_has_a_path()
    {
        $thread = factory('App\Thread')->create();

        $this->assertEquals('threads/'.$thread->id, $thread->path());
    }

    /** @test */
    public function it_belongs_to_user()
    {
        $thread = factory('App\Thread')->create();

        $this->assertInstanceOf(User::class, $thread->user);
    }

    /** @test */
    public function it_has_many_comments()
    {
        $thread = factory('App\Thread')->create();

        $this->assertInstanceOf(Collection::class, $thread->comment);
    }

    /** @test */
    public function a_thread_can_add_comments()
    {
        $this->signIn();

        $thread = factory('App\Thread')->create();
        $thread->addComment('Foo Comment');

        $this->assertCount(1, $thread->comment);

    }

}
