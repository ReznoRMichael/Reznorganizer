<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Project;
use App\User;
use App\Http\Requests\ProjectInvitationRequest;

class ProjectInvitationsController extends Controller
{
    public function store(Project $project, ProjectInvitationRequest $request)
    {
        // $this->authorize('update', $project);

        // request()->validate([
        //     'email' => ['required', 'exists:users,email']
        // ], [
        //     'email.exists' => 'The user you are inviting must have an active rezno[R]ganizer account.'
        // ]);

        $user = User::whereEmail( request('email') )->first();

        $project->invite( $user );

        return redirect( $project->path() );
    }
}
