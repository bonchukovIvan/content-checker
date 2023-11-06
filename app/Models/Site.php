<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Site extends Model
{
    use HasFactory;

    protected $fillable = [
        'link',
        'faculty_id',
    ];
    
    public function faculty()
    {
        return $this->belongsTo(Faculty::class);
    }
}
