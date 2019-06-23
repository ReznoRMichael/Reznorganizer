<?php

namespace App;

trait RecordsActivity
{
    /**
     * The project's old attributes
     *
     * @var array
     */
    public $oldAttributes = [];

    /**
     * Boot the trait.
     *
     */
    public static function bootRecordsActivity()
    {
        foreach( self::recordableEvents() as $event) {
            static::$event ( function ($model) use ($event) {
                $model->recordActivity( $model->activityDescription($event) );
            });

            // responsible for storing the old attributes before the update for future comparison in the database (activity.changes column)
            if($event === 'updated') {
                static::updating( function ($model) {
                    $model->oldAttributes = $model->getOriginal();
                });
            }
        }
    }

    protected function activityDescription( $description )
    {
        return "{$description}_".strtolower( class_basename($this) ); // created_task
    }

    /**
     * @return array
     */
    protected static function recordableEvents()
    {
        if( isset(static::$recordableEvents) ) {
            return static::$recordableEvents;
        }
        return ['created', 'updated', 'deleted'];
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
            'user_id' => ( $this->project ?? $this )->owner->id,
            'description' => $description,
            'changes' => $this->activityChanges(),
            'project_id' => class_basename($this) === 'Project' ? $this->id : $this->project_id
        ]);
    }

    /**
     * The activity feed for the project
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function activity()
    {
        return $this->morphMany(Activity::class, 'subject')->latest();
    }

    /**
     * Let's return the changed activity results - before and after
     *
     * @param  \App\Activity  $description
     * @return void
     */
    public function activityChanges()
    {
        if( $this->wasChanged() )
        {
            return [
                'before' => array_except( array_diff($this->oldAttributes, $this->getAttributes()), 'updated_at' ),
                'after' => array_except( $this->getChanges(), 'updated_at' )
            ];
        }
    }
}