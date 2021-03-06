<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use RecordsActivity;

    protected $guarded = [];

    public function path()
    {
        return action('ProjectsController@index')."/{$this->id}";
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

    public function invite(User $user)
    {
        return $this->members()->attach( $user );
    }

    public function members()
    {
        // standard convention is project_user, but we can override it to project_members
        // project_members - the table name in the database with relations
        return $this->belongsToMany(User::class, 'project_members')->withTimestamps();
    }

}
