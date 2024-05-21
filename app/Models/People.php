<?php

namespace App\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;

class People extends Model
{
    use HasFactory, HasApiTokens, Authenticatable;

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
