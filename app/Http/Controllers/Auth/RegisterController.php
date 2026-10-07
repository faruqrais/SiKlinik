<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Patient;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    /**
     * Show the registration form.
     */
    public function showRegistrationForm()
    {
        // Redirect if already logged in
        if (Auth::check()) {
            return Auth::user()->role === 'admin' 
                ? redirect('/admin/dashboard') 
                : redirect('/patient/dashboard');
        }
        return view('auth.register');
    }

    /**
     * Handle register request.
     */
    public function register(Request $request)
    {
        // Validate user and patient fields
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'nik' => ['required', 'digits:16', 'unique:patients,nik'],
            'birth_date' => ['required', 'date'],
            'phone' => ['required', 'string', 'max:20'],
            'address' => ['required', 'string'],
        ], [
            'name.required' => 'Nama lengkap wajib diisi.',
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'email.unique' => 'Email sudah terdaftar.',
            'password.required' => 'Password wajib diisi.',
            'password.min' => 'Password minimal 8 karakter.',
            'password.confirmed' => 'Konfirmasi password tidak cocok.',
            'nik.required' => 'NIK wajib diisi.',
            'nik.digits' => 'NIK harus berupa 16 digit angka.',
            'nik.unique' => 'NIK sudah terdaftar.',
            'birth_date.required' => 'Tanggal lahir wajib diisi.',
            'birth_date.date' => 'Format tanggal lahir tidak valid.',
            'phone.required' => 'Nomor HP wajib diisi.',
            'address.required' => 'Alamat lengkap wajib diisi.',
        ]);

        // Begin Transaction to ensure integrity
        DB::beginTransaction();

        try {
            // 1. Create User account (defaults as 'patient')
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'role' => 'patient',
            ]);

            // 2. Create Patient profile
            Patient::create([
                'user_id' => $user->id,
                'name' => $request->name,
                'nik' => $request->nik,
                'birth_date' => $request->birth_date,
                'phone' => $request->phone,
                'address' => $request->address,
            ]);

            DB::commit();

            // Auto login after successful registration
            Auth::login($user);

            return redirect('/patient/dashboard')->with('success', 'Registrasi berhasil! Selamat datang di SiKlinik.');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Terjadi kesalahan saat registrasi. Silakan coba lagi.')->withInput();
        }
    }
}
