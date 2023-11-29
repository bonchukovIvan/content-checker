<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Departament extends Model
{
    use HasFactory;

    protected $table = 'departament';

    public function sites()
    {
        return $this->hasMany(Site::class);
    }

    public function valueGroups()
    {
        return $this->belongsToMany(ValueGroup::class, 'departament_value_group');
    }
}
