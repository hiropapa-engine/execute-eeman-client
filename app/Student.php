<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    public function notification_line_ids()
    {
        return $this->hasMany('App\NotificationLineId');
    }
}
