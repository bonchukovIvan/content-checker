<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Value extends Model
{
    use HasFactory;
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'search_values';

    protected $fillable = [
        'search_value',
    ];
    
    public function group()
    {
        return $this->belongsTo(ValuesGroup::class);
    }
}
