<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;

use Illuminate\Database\Eloquent\Model;

class Haystack extends Model
{
    use HasFactory;
    
    protected $guarded = [];

    public function needles(): HasMany
    {
        return $this->hasMany(Needle::class);
    }
}
