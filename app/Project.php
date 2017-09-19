<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Project;

class Project extends Model
{
    use SoftDeletes;
	
   /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'np_id',
    	'name', 
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [];
	
    public function subprojects()
    {
        return $this->hasMany('App\Subproject')->ordered();
    }

    public function scopeOrdered($query) {
        return $query->orderBy('name', 'ASC');
    }
}
