<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MonitorEvent extends Model
{
    protected $table = 'monitor_events';

        protected $fillable = [
        'monitor_id',
        'status_code',
        'response_time_ms',
        'is_up',
        'checked_at'
    ];

    public function monitor()
    {
        return $this->belongsTo(Monitor::class);
    }
}
