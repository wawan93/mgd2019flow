<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    public function collectors()
    {
        return $this->belongsToMany(Collector::class);
    }

    protected $fillable = ['name', 'starts_at', 'max_attendees'];
}
