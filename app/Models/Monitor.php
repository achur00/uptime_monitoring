<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Monitor extends Model
{
  protected $table = 'monitors';
  
   protected $fillable = [
        'url',
        'check_interval',
        'threshold',
        'status',
    ];

    public function checks()
    {
        return $this->hasMany(
            MonitorEvent::class
        );
    }
}
