<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class appointment extends Model
{
    public function calendar()
    {
        return $this->belongsTo('App\calendar', 'calendar_id');
    }

    public function prospect()
    {
        return $this->belongsTo('App\prospects');
    }

    public function setDateAttribute($value)
    {
      $dt= new Carbon($value);

        $this->attributes['date'] =$dt->toDateString();
    }
    public function setHourAttribute($value)
    {
        $dt= new Carbon($value);
        $this->attributes['hour'] = $dt->toTimeString();

    }
}
