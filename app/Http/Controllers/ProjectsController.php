<?php

namespace App\Http\Controllers;

use App\Project;
use Illuminate\Http\Request;

class ProjectsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $projects = auth()->user()->authorizedProjects();

        return view('projects.index', compact('projects'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('projects.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return mixed
     */
    public function store()
    {
        // validate and persist
        $project = auth() -> user() -> projects() -> create( $this->validateRequest() );
        // for adding optional tasks from the Vue modal form
        if( request()->has('tasks') ) {
            foreach( request('tasks') as $task ) {
                $project->addTask( $task['body'] );
            }
        }
        // for Vue modal form - return the redirect path for the project
        if( request()->wantsJson() ) {
            return ['projectpath' => $project->path()];
        }
        // redirect
        return redirect( $project->path() );
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function show(Project $project)
    {
        // Project $project is the route model binding for the {project} wildcard to find the id of the project quicker

        // don't allow users view other users' projects
        $this->authorize('update', $project);

        return view('projects.show', compact('project'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function edit(Project $project)
    {
        return view('projects.edit', compact('project'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Project $project)
    {
        // don't allow users update other users' projects
        $this->authorize('update', $project);

        $project->update( $this->validateRequest() );

        return redirect($project->path());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function destroy(Project $project)
    {
        $this->authorize('manage', $project);

        $project->delete();

        return redirect( action('ProjectsController@index') );
    }

    public function validateRequest()
    {
        return request() -> validate([
            'title' => 'sometimes|required|max:45',
            'description' => 'sometimes|required|max:191',
            'notes' => 'nullable'
        ]);
    }
}
