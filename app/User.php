<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function projects()
    {
        // make sure you specify the owner_id instead of the default user_id
        // view all projects ordered by the updated_at timestamp in the database
        // use also: orderBy('updated_at', 'desc') or orderByDesc('updated_at')
        return $this->hasMany(Project::class, 'owner_id')->latest('updated_at');
    }

    public function authorizedProjects()
    {
        // dashboard - see not only own projects, but also those invited to
        return Project::where('owner_id', $this->id)
            ->orWhereHas('members', function ($query) {
                $query->where('user_id', $this->id);
            })->get();

        // alternative approach
        // $projectsCreated = $this->projects;
        // $ids = \DB::table('project_members')->where('user_id', $this->id)->pluck('project_id');
        // $projectsShared = Project::find( $ids );
        // return $projectsCreated->merge( $projectsShared );
    }
}
