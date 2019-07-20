<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ThreadsTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function an_authenticated_user_can_make_threads()
    {
        $this->signIn();

        $thread = factory('App\Thread')->create();

        $this->post('/threads', $thread->toArray());

        $this->get($thread->path())
            ->assertSee($thread->title)
            ->assertSee($thread->description);
    }

    /** @test */
    public function a_thread_requires_a_title()
    {
        $this->signIn();

        $thread = factory('App\Thread')->raw(['title' => '']);

        $this->post('/threads', $thread)
            ->assertSessionHasErrors('title');
    }


    /** @test */
    public function a_thread_requires_a_description()
    {
        $this->signIn();

        $thread = factory('App\Thread')->raw(['description' => '']);


        $this->post('/threads', $thread)
            ->assertSessionHasErrors('description');
    }

    /** @test */
    public function guests_cannot_make_threads()
    {
        $this->post('/threads', [])->assertRedirect('/login');
    }

    /** @test */
    public function a_user_can_view_threads()
    {
        $thread = factory('App\Thread', 2)->create();

        $this->get('/threads')
            ->assertSee($thread->first()->title)
            ->assertSee($thread->last()->title);
    }

}
