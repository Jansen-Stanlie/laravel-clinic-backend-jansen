<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Schedule extends Model
{
    use HasFactory;
    protected $fillable = [
        'doctor_id',
        'polyclinic_id',
        'doctor_name',
        'date_schedule',
        'day',
        'start',
        'end',
        'specialization',
        'status',
    ];

    /**
     * Get the doctor that the schedule belongs to.
     */
    public function doctor()
    {
        return $this->belongsTo(Doctor::class, 'doctor_id', 'doctor_id');
    }

    /**
     * Get the polyclinic that the schedule belongs to.
     */
    public function polyclinic()
    {
        return $this->belongsTo(Polyclinic::class, 'polyclinic_id', 'polyID');
    }
}
