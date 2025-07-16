<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\Activitylog\Traits\LogsActivity;
class Candidate extends Model implements HasMedia
{

    use InteractsWithMedia;

    use LogsActivity;

    protected static $logAttributes = ['name', 'position'];
    protected static $logName = 'candidate';
    protected static $logOnlyDirty = true;

    protected $fillable = ['name','position'];

    public function votes()
    {
        return $this->hasMany(Vote::class);
    }


}
