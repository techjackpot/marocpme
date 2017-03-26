<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class prospects extends Model
{
    public function appointment()
    {
        return $this->hasMany('App\appointment','appointment_id');
    }

}
