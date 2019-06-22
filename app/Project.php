<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    protected $guarded = [];

    public $old = [];

    public function path()
    {
        return "/projects/{$this->id}";
    }

    public function owner()
    {
        // make sure that the project belongs to the owner
        return $this -> belongsTo(User::class);
    }

    public function tasks()
    {
        return $this -> hasMany(Task::class);
    }

    public function addTask($body)
    {
        return $this->tasks()->create( compact('body') );
    }

    public function activity()
    {
        return $this->hasMany(Activity::class)->latest();
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
            'description' => $description,
            'changes' => $this->activityChanges()
        ]);
    }

    public function activityChanges()
    {
        if( $this->wasChanged() )
        {
            return [
                'before' => array_except( array_diff($this->old, $this->getAttributes()), 'updated_at' ),
                'after' => array_except( $this->getChanges(), 'updated_at' )
            ];
        }
    }
}
