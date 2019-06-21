<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Task;
use App\Project;

class TaskTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_belongs_to_a_project()
    {
        // if we have a task
        $task = factory(Task::class)->create();

        // it must belong to a project
        $this->assertInstanceOf(Project::class, $task->project);
    }

    /** @test */
    public function it_has_a_path()
    {
        $task = factory(Task::class)->create();

        $this->assertEquals('/projects/'.$task->project->id.'/tasks/'.$task->id, $task->path());
    }
}
