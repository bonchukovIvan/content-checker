<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Needle extends Model
{
    use HasFactory;

    protected $fillable = ['value'];

    public function haystack()
    {
        return $this->belongsTo(Haystack::class);
    }

}
