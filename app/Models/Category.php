<?php

namespace App\Models;

use Companyusers;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;


    public function users(){
        return $this->hasMany(Companyusers::class);
    }
}
