<?php

namespace App\Http\Requests;

use App\Models\Complaint;
use App\Models\Doctor;
use Illuminate\Foundation\Http\FormRequest;

class BookingRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true; // handled by auth/role middleware
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'complaint_id' => ['required', 'exists:complaints,id'],
            'doctor_id' => ['required', 'exists:doctors,id'],
            'booking_date' => ['required', 'date', 'after_or_equal:today'],
            'booking_time' => ['required'],
        ];
    }

    /**
     * Custom validation logic to ensure integrity (anti-tamper checks).
     */
    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            $complaintId = $this->input('complaint_id');
            $doctorId = $this->input('doctor_id');

            if ($complaintId && $doctorId) {
                $complaint = Complaint::find($complaintId);
                $doctor = Doctor::find($doctorId);

                if ($complaint && $doctor) {
                    // Check if doctor's specialization matches complaint's specialization
                    if ($complaint->specialization_id !== $doctor->specialization_id) {
                        $validator->errors()->add(
                            'doctor_id', 
                            'Dokter yang dipilih tidak memiliki spesialisasi yang sesuai dengan keluhan Anda (Penyimpangan data terdeteksi).'
                        );
                    }
                }
            }
        });
    }

    /**
     * Custom validation error messages.
     */
    public function messages(): array
    {
        return [
            'complaint_id.required' => 'Keluhan wajib dipilih.',
            'complaint_id.exists' => 'Keluhan tidak terdaftar di sistem.',
            'doctor_id.required' => 'Dokter wajib dipilih.',
            'doctor_id.exists' => 'Dokter tidak terdaftar di sistem.',
            'booking_date.required' => 'Tanggal kunjungan wajib diisi.',
            'booking_date.date' => 'Format tanggal tidak valid.',
            'booking_date.after_or_equal' => 'Tanggal kunjungan tidak boleh di masa lalu.',
            'booking_time.required' => 'Waktu kunjungan wajib diisi.',
        ];
    }
}
