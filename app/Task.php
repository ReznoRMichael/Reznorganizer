<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    protected $guarded = [];

    // set this to also update the parent project timestamp, not only the task itself
    protected $touches = [
        'project'
    ];

    protected $casts = [
        'completed' => 'boolean'
    ];

    public function complete()
    {
        $this->update(['completed' => true]);

        $this->recordActivity('completed_task');
    }

    public function incomplete()
    {
        $this->update(['completed' => false]);

        $this->recordActivity('uncompleted_task');
    }

    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    public function path()
    {
        return "/projects/{$this->project->id}/tasks/{$this->id}";
    }

    public function activity()
    {
        return $this->morphMany(Activity::class, 'subject')->latest();
    }

    /**
     * Let's generate some activity associated with the project
     *
     * @param  \App\Activity  $description
     * @return void
     */
    public function recordActivity($description)
    {
        // only the description is needed, the project_id is provided automatically
        $this->activity()->create([
            'project_id' => $this->project_id,
            'description' => $description
        ]);
    }
}
