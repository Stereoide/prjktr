<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;

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
        'user_id',
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [];

    /* Relationships */

    public function subprojects()
    {
        return $this->hasMany('App\Subproject')->ordered();
    }

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    /* Scopes */

    public function scopeForUser($query)
    {
        return $query->where('projects.user_id', Auth::id());
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('name', 'ASC');
    }

    public function scopeUnassigned($query)
    {
        return $query->whereNull('np_id');
    }
}
