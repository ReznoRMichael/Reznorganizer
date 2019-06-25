<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Project;
use App\Task;
use Facades\Tests\Setup\ProjectFactory;

class ProjectTasksTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    function guests_cannot_add_tasks_to_projects()
    {
        $project = factory(Project::class)->create();

        $this -> post($project->path().'/tasks')->assertRedirect('login');
    }

    /** @test */
    function only_the_owner_of_a_project_may_add_tasks()
    {
        $this->signIn();

        // project that is not the signed in user
        $project = factory(Project::class)->create();

        // adding a task to another user's project is forbidden
        $this -> post($project->path().'/tasks', ['body' => 'Test task'])
            ->assertStatus(403);

        $this -> assertDatabaseMissing('tasks', ['body' => 'Test task']);
    }

    /** @test */
    function only_the_owner_of_a_project_may_update_a_task()
    {
        $this->signIn();

        // different project and task that is not the signed in user's
        $project = ProjectFactory::withTasks(1)->create();

        // updating that task from another user's project is forbidden
        $this -> patch($project->tasks[0]->path(), ['body' => 'changed'])
            ->assertStatus(403);

        // there should be no record of that change in the database
        $this -> assertDatabaseMissing('tasks', ['body' => 'changed']);
    }

    /** @test */
    function a_project_can_have_tasks()
    {
        $project = ProjectFactory::create();

        $this->actingAs($project->owner)
             ->post($project->path().'/tasks', ['body' => 'Test task']);

        $this->get($project->path())
             ->assertSee('Test task');
    }
    
    /** @test */
    function a_task_can_be_updated()
    {
        //$this->withoutExceptionHandling();
        $project = ProjectFactory::withTasks(1)->create();

        $this->actingAs($project->owner)
            ->patch($project->tasks->first()->path(), [
            'body' => 'changed'
        ]);

        $this->assertDatabaseHas('tasks', [
            'body' => 'changed'
        ]);
    }

    /** @test */
    function a_task_can_be_completed()
    {
        //$this->withoutExceptionHandling();
        $project = ProjectFactory::withTasks(1)->create();

        $this->actingAs($project->owner)
            ->patch($project->tasks->first()->path(), [
            'body' => 'changed',
            'completed' => true
        ]);

        $this->assertDatabaseHas('tasks', [
            'body' => 'changed',
            'completed' => true
        ]);
    }

    /** @test */
    function a_task_can_be_marked_as_incomplete()
    {
        $this->withoutExceptionHandling();
        $project = ProjectFactory::withTasks(1)->create();

        $this->actingAs($project->owner)
            ->patch($project->tasks[0]->path(), [
            'body' => 'changed',
            'completed' => true
        ]);

        $this->patch($project->tasks[0]->path(), [
            'body' => 'changed',
            'completed' => false
        ]);

        $this->assertDatabaseHas('tasks', [
            'body' => 'changed',
            'completed' => false
        ]);
    }

    /** @test */
    function a_task_requires_a_body()
    {
        $project = ProjectFactory::create();

        // make a new task with a factory for checking (raw makes an array)
        $attributes = factory(Task::class) -> raw(['body' => '']);

        // use a helper to check if the project has a description
        $this->actingAs($project->owner)
             ->post($project->path().'/tasks', $attributes)
             ->assertSessionHasErrors('body');
    }
}
