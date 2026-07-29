<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Specialist extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'name',
    ];

    public function services()
    {
        return $this->belongsToMany(
            Service::class,
            'specialist_services',
            'specialist_id',
            'service_id'
        );
    }

    public function appointments()
    {
        return $this->hasMany(Appointment::class);
    }
}
