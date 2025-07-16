<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Candidate extends Model implements HasMedia
{

    use InteractsWithMedia;

    protected $fillable = ['name','position'];

    public function votes()
    {
        return $this->hasMany(Vote::class);
    }
}
