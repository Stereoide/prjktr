<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Subproject;

class Subproject extends Model
{
    use SoftDeletes;
	
   /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
    	'project_id',
        'np_id',
    	'name', 
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [];
	
    public function project()
    {
        return $this->belongsTo('App\Project');
    }
}
