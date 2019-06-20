<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ProjectsTest extends TestCase
{
    use WithFaker;

    $attributes = [
      'title' => $this -> faker(),
      'description' => $this -> faker()  
    ];

    /** @test */
    public function a_user_can_create_a_project()
    {
        $this -> post('/projects', $attributes);

        $this -> assertDatabaseHas('projects', $attributes);
    }
}
