<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Complaint extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'specialization_id',
    ];

    /**
     * Get the specialization associated with the complaint.
     */
    public function specialization()
    {
        return $this->belongsTo(Specialization::class);
    }
}
