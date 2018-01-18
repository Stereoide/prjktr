<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

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

    /* Relationships */

    public function subprojects()
    {
        return $this->hasMany('App\Subproject')->ordered();
    }

    /* Scopes */

    public function scopeOrdered($query)
    {
        return $query->orderBy('name', 'ASC');
    }

    public function scopeUnassigned($query)
    {
        return $query->whereNull('np_id');
    }
}
