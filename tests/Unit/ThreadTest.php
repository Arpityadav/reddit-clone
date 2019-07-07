<?php

namespace Tests\Unit;

use App\User;
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
        $user = factory('App\User')->create();
        $this->actingAs($user);

        $thread = factory('App\Thread')->create();

        $this->assertInstanceOf(User::class, $thread->user);
    }
}
