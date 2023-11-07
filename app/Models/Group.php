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
    ];
    
    public function values()
    {
        return $this->hasMany(Value::class, 'values_group_id');
    }
}
