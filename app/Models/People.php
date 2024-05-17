<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class People extends Model
{
    use HasFactory;

    public function cars()
    {
        return $this->hasMany(Car::class, 'people_id');
    }
    protected $table = 'people';

    protected $fillable = [
        'name',
        'email',
        'password',
        'phone',
        'language'
    ];
}
