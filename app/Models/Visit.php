<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Visit extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'patient_id',
        'doctor_id',
        'complaint_id',
        'visit_date',
        'complaint',
        'diagnosis',
        'status',
        'booking_date',
        'booking_time',
        'booking_code',
        'consultation_fee',
        'admin_fee',
        'total_fee',
        'payment_status',
    ];

    /**
     * Get the complaint category associated with the visit.
     */
    public function complaint()
    {
        return $this->belongsTo(Complaint::class);
    }

    /**
     * The attributes that should be cast to specific types.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'visit_date' => 'date',
        'booking_date' => 'date',
    ];

    /**
     * Get the patient associated with the visit.
     */
    public function patient()
    {
        return $this->belongsTo(Patient::class)->withTrashed(); // include soft-deleted patients in historical visit records
    }

    /**
     * Get the doctor associated with the visit.
     */
    public function doctor()
    {
        return $this->belongsTo(Doctor::class)->withTrashed(); // include soft-deleted doctors in historical visit records
    }
}
