<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'name',
        'duration',
    ];

    public function specialists()
    {
        return $this->belongsToMany(
            Specialist::class,
            'specialist_services',
            'service_id',
            'specialist_id'
        );
    }

    public function appointments()
    {
        return $this->hasMany(Appointment::class);
    }
}
