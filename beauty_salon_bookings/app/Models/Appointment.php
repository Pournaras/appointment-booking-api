<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'specialist_id',
        'service_id',
        'appointment_date',
        'start_time',
        'end_time',
    ];

    public function specialist()
    {
        return $this->belongsTo(Specialist::class);
    }

    public function service()
    {
        return $this->belongsTo(Service::class);
    }
}
