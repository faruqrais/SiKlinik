<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Doctor extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'specialization',
        'specialization_id',
        'schedule',
        'phone',
        'consultation_fee',
    ];

    /**
     * Get the specialization associated with the doctor.
     */
    public function specialization()
    {
        return $this->belongsTo(Specialization::class);
    }

    /**
     * Get the visits associated with the doctor.
     */
    public function visits()
    {
        return $this->hasMany(Visit::class);
    }
}
