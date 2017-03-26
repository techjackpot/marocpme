<?php

namespace App;

use Dingo\Api\Http\Middleware\Request;
use Illuminate\Database\Eloquent\Model;

class calendar extends Model
{
    public function appointment()
    {
        return $this->hasMany('App\appointment');
    }

    public function user()
    {
        return $this->belongsTo('App\User','user_id');
    }

    public static function titleCalendar($title)
    {

        $newTitle = strlen($title) > 6 ? substr($title,0,6)."..." : $title;

        return $newTitle;
    }
}
