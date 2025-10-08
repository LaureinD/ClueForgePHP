<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = [
        'name',
    ];

    public function categoryables()
    {
        return $this->morphTo();
    }

    public function icon() {
        return $this->belongsTo(Icon::class);
    }

    public function roles()
    {
        return $this->morphedByMany(Role::class, 'categoryable');
    }

    public function permissions()
    {
        return $this->morphedByMany(Permission::class, 'categoryable');
    }
}
