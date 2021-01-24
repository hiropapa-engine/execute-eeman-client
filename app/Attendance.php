<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    public function category()
    {
        return $this->belongsTo('App\Category');
    }

    public function school()
    {
        return $this->belongsTo('App\School');
    }

    public function class()
    {
        return $this->belongsTo('App\ClassModel');
    }

    public function enter_and_leave()
    {
        return $this->hasMany('App\EnterAndLeave');
    }
}
