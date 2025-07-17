<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use Spatie\Activitylog\LogOptions;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\Activitylog\Traits\LogsActivity;


class Candidate extends Model implements HasMedia
{

    use InteractsWithMedia, LogsActivity;




    protected $fillable = ['name','position'];

    public function votes()
    {
        return $this->hasMany(Vote::class);
    }

    public function position()
    {
        return $this->belongsTo(Position::class);
    }


    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['name', 'position'])
            ->logOnlyDirty()
            ->useLogName('candidate');
    }

}
