<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    // define what properties can be mass-assigned and filled into the table
    protected $guarded = [];

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
}
