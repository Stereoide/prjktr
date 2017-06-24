<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Worklog;

class Job extends Model
{
    use SoftDeletes;
	
   /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'project_id',
        'subproject_id',
        'activity_id',
        'description',
        'status',
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [];
    
    protected $dates = ['created_at', 'updated_at', 'deleted_at', 'begin_at', 'end_at'];

    public function project()
    {
    	return $this->belongsTo('App\Project');
    }
    
    public function subproject()
    {
    	return $this->belongsTo('App\Subproject');
    }
    
    public function activity()
    {
    	return $this->belongsTo('App\Activity');
    }
    
    public function worklogs()
    {
        return $this->hasMany('App\Worklog');
    }
    
    public function scopeOpen($query) {
    	return $query->where('jobs.status', 'open');
    }
    
    public function scopeClosed($query) {
    	return $query->where('jobs.status', 'closed');
    }
    
    public function scopeOrdered($query) {
    	return $query
    		->select('jobs.*', 'projects.name AS project_name', 'subprojects.name AS subproject_name', 'activities.name AS activity_name')
    		->join('projects', 'jobs.project_id', '=', 'projects.id')
    		->join('subprojects', 'jobs.subproject_id', '=', 'subprojects.id')
    		->join('activities', 'jobs.activity_id', '=', 'activities.id')
    		->orderBy('project_name', 'ASC')
    		->orderBy('subproject_name', 'ASC')
    		->orderBy('activity_name', 'ASC');
    }
}
