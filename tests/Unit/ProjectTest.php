<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ProjectTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    function it_has_a_path()
    {
        $project = factory('App\Project')->create();

        $this -> assertEquals('/projects/'. $project->id, $project -> path());
    }

    /** @test */
    function it_belongs_to_an_owner()
    {
        $project = factory('App\Project')->create();

        $this-> assertInstanceOf('App\User', $project->owner );
    }

    /** @test */
    function it_can_add_a_task()
    {
        $project = factory('App\Project')->create();

        // after adding a task
        $task = $project->addTask('Test task');

        // there should be at least one task
        $this -> assertCount(1, $project->tasks);

        // that contains the data written earlier
        $this -> assertTrue($project->tasks->contains($task));
    }

    /** @test */
    function it_can_invite_a_user()
    {
        $project = factory('App\Project')->create();
        
        $project->invite( $user = factory('App\User')->create() );

        $this->assertTrue( $project->members->contains($user) );
    }

}
