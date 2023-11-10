<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Faculty extends Model
{
    use HasFactory;

    public function valueGroups()
    {
        return $this->hasMany(ValueGroup::class);
    }
    
    public function sites()
    {
        return $this->hasMany(Site::class);
    }
}
