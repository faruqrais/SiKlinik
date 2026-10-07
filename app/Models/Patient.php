<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Patient extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'name',
        'nik',
        'birth_date',
        'phone',
        'address',
    ];

    /**
     * The attributes that should be cast to specific types.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'birth_date' => 'date',
    ];

    /**
     * Get the user account associated with the patient profile.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the visits associated with the patient.
     */
    public function visits()
    {
        return $this->hasMany(Visit::class);
    }
}
