<?php

namespace Tests\Feature;

use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Facades\Tests\Setup\ProjectFactory;

class InvitationsTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    function a_project_owner_can_invite_a_user()
    {
        $project = ProjectFactory::create();
        $userToInvite = factory(User::class)->create();

        $this->actingAs($project->owner)->post( action('ProjectInvitationsController@store', $project), [
                'email' => $userToInvite->email
            ])
            ->assertRedirect( $project->path() );
        
        $this->assertTrue( $project->members->contains($userToInvite) );
    }

    /** @test */
    function non_owners_may_not_invite_users()
    {
        $project = ProjectFactory::create();
        $user = factory(User::class)->create();

        $assertInvitationForbidden = function () use ($user, $project) {
            $this->actingAs($user)
                ->post( action('ProjectInvitationsController@store', $project) )
                ->assertStatus(403);
        };

        $assertInvitationForbidden();
        //after the same user has been invited to the project
        $project->invite($user);
        //they cannot invite other users
        $assertInvitationForbidden();
    }

    /** @test */
    function the_email_address_must_be_associated_with_a_valid_reznorganizer_account()
    {
        $project = ProjectFactory::create();

        $this->actingAs($project->owner)
            ->post( action('ProjectInvitationsController@store', $project), [
            'email' => 'notauser@reznorganizer.com'
        ])
            ->assertSessionHasErrors([
                'email' => 'The user you are inviting must have an active rezno[R]ganizer account.'
            ], null, 'invitations');
        
    }
    
    /** @test */
    function invited_users_may_update_project_details()
    {
        $project = ProjectFactory::create();

        $project->invite( $newUser = factory(User::class)->create() );

        $this->signIn( $newUser );
        $this->post( action('ProjectTasksController@store', $project), $task = ['body' => 'Foo task'] );

        $this->assertDatabaseHas('tasks', $task);
    }
}
