<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Project;
use App\Task;

class ProjectTasksController extends Controller
{
    public function store(Project $project)
    {
        $this->authorize('update', $project);
        
        request() -> validate([
            'body' => 'required'
        ]);
        
        if( request('body') != '' ) {
        $project -> addTask( request('body') );
        }

        return redirect( $project->path() );
    }

    public function update(Project $project, Task $task)
    {
        // do not forget about the project-task relationship
        $this->authorize('update', $task->project);

        // if the request body is validated, update the task
        $task->update( request() -> validate(['body' => 'required']) );

        request('completed') ? $task->complete() : $task->incomplete();

        return redirect( $project->path() );
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Project  $project
     * @param  \App\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function destroy(Project $project, Task $task)
    {
        $this->authorize('manage', $task->project);

        $task->delete();

        return redirect( $project->path() );
    }
}
