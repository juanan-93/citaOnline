<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory;

    protected $fillable = ['name']; // El campo que permitirá asignar nombres a los roles

    
    public function users()
    {
        return $this->hasMany(User::class);
    }
}
