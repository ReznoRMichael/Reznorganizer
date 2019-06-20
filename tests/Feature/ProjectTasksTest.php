<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Project;
use App\Task;

class ProjectTasksTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function a_project_can_have_tasks()
    {
        $this -> signIn();

        $project = auth()->user()->projects()->create(
            factory(Project::class)->raw()
        );

        $this -> post($project->path().'/tasks', ['body' => 'Test task']);

        $this -> get($project->path())
            -> assertSee('Test task');
    }

    /** @test */
    public function a_task_requires_a_body()
    {
        $this -> signIn();

        $project = auth()->user()->projects()->create(
            factory(Project::class)->raw()
        );

        // make a new task with a factory for checking (raw makes an array)
        $attributes = factory(Task::class) -> raw(['body' => '']);

        // use a helper to check if the project has a description
        $this -> post($project->path().'/tasks', $attributes) -> assertSessionHasErrors('body');
    }
}
