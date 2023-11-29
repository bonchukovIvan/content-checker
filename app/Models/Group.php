<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    use HasFactory;
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'values_groups';

    protected $fillable = [
        'name',
        'faculty_id',
    ];

    public function faculty()
    {
        return $this->belongsTo(Faculty::class);
    }
    
    public function values()
    {
        return $this->hasMany(Value::class, 'values_group_id');
    }

    public function departaments()
    {
        return $this->belongsToMany(Departament::class, 'departament_value_group');
    }
}
