<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class VisitRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'patient_id' => ['required', 'exists:patients,id'],
            'doctor_id' => ['required', 'exists:doctors,id'],
            'visit_date' => ['required', 'date'],
            'complaint' => ['required', 'string'],
            'diagnosis' => ['required', 'string'],
        ];
    }

    /**
     * Get the validation error messages.
     */
    public function messages(): array
    {
        return [
            'patient_id.required' => 'Pasien wajib dipilih.',
            'patient_id.exists' => 'Pasien tidak ditemukan.',
            'doctor_id.required' => 'Dokter wajib dipilih.',
            'doctor_id.exists' => 'Dokter tidak ditemukan.',
            'visit_date.required' => 'Tanggal kunjungan wajib diisi.',
            'visit_date.date' => 'Format tanggal kunjungan tidak valid.',
            'complaint.required' => 'Keluhan pasien wajib diisi.',
            'diagnosis.required' => 'Diagnosa dokter wajib diisi.',
        ];
    }
}
