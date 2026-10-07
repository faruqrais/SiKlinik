<?php

namespace App\Http\Requests;

use App\Models\Patient;
use Illuminate\Foundation\Http\FormRequest;

class PatientRequest extends FormRequest
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
        $patient = $this->route('patient');
        $patientId = is_object($patient) ? $patient->id : $patient;
        $userId = null;

        if ($patientId) {
            $patientModel = Patient::find($patientId);
            $userId = $patientModel ? $patientModel->user_id : null;
        }

        $rules = [
            'name' => ['required', 'string', 'max:255'],
            'birth_date' => ['required', 'date'],
            'phone' => ['required', 'string', 'max:20'],
            'address' => ['required', 'string'],
        ];

        if ($this->isMethod('POST')) {
            // For creating new patients
            $rules['email'] = ['required', 'string', 'email', 'max:255', 'unique:users,email'];
            $rules['password'] = ['required', 'string', 'min:8'];
            $rules['nik'] = ['required', 'digits:16', 'unique:patients,nik'];
        } else {
            // For editing existing patients
            $rules['email'] = ['required', 'string', 'email', 'max:255', 'unique:users,email,' . $userId];
            $rules['password'] = ['nullable', 'string', 'min:8'];
            $rules['nik'] = ['required', 'digits:16', 'unique:patients,nik,' . $patientId];
        }

        return $rules;
    }

    /**
     * Get the validation error messages.
     */
    public function messages(): array
    {
        return [
            'name.required' => 'Nama lengkap wajib diisi.',
            'birth_date.required' => 'Tanggal lahir wajib diisi.',
            'birth_date.date' => 'Format tanggal lahir tidak valid.',
            'phone.required' => 'Nomor HP wajib diisi.',
            'address.required' => 'Alamat lengkap wajib diisi.',
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'email.unique' => 'Email sudah digunakan oleh user lain.',
            'password.required' => 'Password wajib diisi.',
            'password.min' => 'Password minimal 8 karakter.',
            'nik.required' => 'NIK wajib diisi.',
            'nik.digits' => 'NIK harus 16 digit.',
            'nik.unique' => 'NIK sudah digunakan.',
        ];
    }
}
