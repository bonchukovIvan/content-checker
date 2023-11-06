<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Faculty extends Model
{
    use HasFactory;
    
    public function sites()
    {
        return $this->hasMany(Site::class);
    }

    public function links()
    {
        return $this->hasMany(Link::class);
    }
}
