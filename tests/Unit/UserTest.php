<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Database\Eloquent\Collection;
use Facades\Tests\Setup\ProjectFactory;

class UserTest extends TestCase
{
    use RefreshDatabase;
    
    /** @test */
    function a_user_has_projects()
    {
        $user = factory('App\User')->create();

        $this -> assertInstanceOf(Collection::class, $user->projects);
    }

    /** @test */
    function a_user_has_accessible_projects()
    {
        $john = $this->signIn();

        ProjectFactory::ownedBy( $john )->create();
        // john only can see 1 project
        $this->assertCount( 1, $john->authorizedProjects() );

        $sally = factory('App\User')->create();
        $nick = factory('App\User')->create();
        // sally invites nick to the project
        $project = tap( ProjectFactory::ownedBy( $sally )->create() )->invite( $nick );
        // john can still only see 1 project
        $this->assertCount( 1, $john->authorizedProjects() );

        $project->invite( $john );
        // after inviting john can now see 2 projects
        $this->assertCount( 2, $john->authorizedProjects() );
    }
}
