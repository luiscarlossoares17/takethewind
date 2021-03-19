<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Teamusers extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = ['deleted_at'];

    protected $table = 'teamusers';

    public function user(){
        return $this->belongsTo(Companyuser::class, 'companyuser_id');
    }

    public function team(){
        return $this->belongsTo(Team::class);
    }

    public function userlevel(){
        return $this->belongsTo(Userlevel::class);
    }
    
}
