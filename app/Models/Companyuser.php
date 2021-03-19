<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Companyuser extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'email', 'age', 'category_id'];


    public function category(){
        return $this->belongsTo(Category::class);
    }
}
