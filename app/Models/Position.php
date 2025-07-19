<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Position extends Model
{
    protected $fillable = ['name','type','max_votes','order'];
    public  function candidates()
    {
       return $this->hasMany(Candidate::class);
    }
}
