<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Car extends Model
{
    use HasFactory;

    public function person()
    {
        return $this->belongsTo(People::class, 'people_id');
    }

    protected $table = 'cars';

    protected $fillable = [
        'brand',
        'model',
        'year',
        'people_id',
    ];
}
