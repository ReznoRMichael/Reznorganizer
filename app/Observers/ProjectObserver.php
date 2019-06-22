<?php

namespace App\Observers;

use App\Project;

class ProjectObserver
{
    /**
     * Handle the project "created" event.
     *
     * @param  \App\Project  $project
     * @return void
     */
    public function created(Project $project)
    {
        $project->recordActivity('created');
    }

    /**
     * Handle the project "updated" event.
     *
     * @param  \App\Project  $project
     * @return void
     */
    public function updated(Project $project)
    {
        // when a project is updated() let's also generate some activity
        $project->recordActivity('updated');
    }

    public function updating(Project $project)
    {
        $project->old = $project->getOriginal();
    }

    /**
     * Handle the project "deleted" event.
     *
     * @param  \App\Project  $project
     * @return void
     */
    public function deleted(Project $project)
    {
        //
    }

    /**
     * Handle the project "restored" event.
     *
     * @param  \App\Project  $project
     * @return void
     */
    public function restored(Project $project)
    {
        //
    }

    /**
     * Handle the project "force deleted" event.
     *
     * @param  \App\Project  $project
     * @return void
     */
    public function forceDeleted(Project $project)
    {
        //
    }
}
