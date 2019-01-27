<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Traits\HasObjectiveTrait;
use App\Traits\HasAvatarTrait;
use App\Interfaces\HasObjectiveInterface;
use App\Interfaces\HasInvitationInterface;
use App\Traits\HasInvitationTrait;
use App\Traits\HasFollowTrait;

class Company extends Model implements HasObjectiveInterface, HasInvitationInterface
{
    use HasObjectiveTrait, HasAvatarTrait, HasInvitationTrait, HasFollowTrait;

    protected $fillable = [
        'name', 'description', 'user_id',
    ];

    public function users()
    {
        return $this->hasMany('App\User', 'company_id');
    }

    public function departments()
    {
        return $this->hasMany('App\Department', 'company_id');
    }

    public function projects()
    {
        return $this->hasManyThrough(Project::class, User::class, 'company_id', 'user_id');
    }

    public function getOKrRoute()
    {
        return route('company.okr');
    }

    public function getNotifiableUser()
    {
        return $this->users;
    }

    public function admin()
    {
        return $this->belongsTo(User::class);
    }

    public function getInviteUrl($userId)
    {
        return route('company.index');
    }

    public function delete()
    {   
        foreach ($this->projects as $project) {
            $project->delete();
        }
        foreach ($this->users as $user) {
            $user->update(['company_id' => null, 'department_id' => null]);
        }
        foreach ($this->departments as $department) {
            $department->delete();
        }
        $this->follower()->delete();
        
        return parent::delete();
    }
}
