<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Doctor extends Model
{
    use HasFactory;

    protected $fillable = [
        'doctor_id',
        'sip',
        'nik',
        'name',
        'email',
        'phone',
        'password',
        'role',
        'degree',
        'specialization',
        'hospital',
        'address',
        'city',
        'province',
        'zip',
        'country',
        'photo',
        'status',
        'polyclinic_id',
        'is_active',
        'polyName',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * Get the polyclinic that the doctor belongs to.
     */
    public function polyclinic()
    {
        return $this->belongsTo(Polyclinic::class, 'polyclinic_id', 'polyID');
    }
}
