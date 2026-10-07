<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\PatientRequest;
use App\Models\Patient;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class PatientController extends Controller
{
    /**
     * Display a listing of patients.
     */
    public function index()
    {
        $patients = Patient::orderBy('name', 'asc')->paginate(10);
        return view('admin.patients.index', compact('patients'));
    }

    /**
     * Show the form for creating a new patient.
     */
    public function create()
    {
        return view('admin.patients.create');
    }

    /**
     * Store a newly created patient in database.
     */
    public function store(PatientRequest $request)
    {
        DB::beginTransaction();

        try {
            // 1. Create the user login account
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'role' => 'patient',
            ]);

            // 2. Create the patient profile associated with the user
            Patient::create([
                'user_id' => $user->id,
                'name' => $request->name,
                'nik' => $request->nik,
                'birth_date' => $request->birth_date,
                'phone' => $request->phone,
                'address' => $request->address,
            ]);

            DB::commit();
            return redirect()->route('patients.index')->with('success', 'Data pasien berhasil ditambahkan.');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Gagal menambahkan data pasien: ' . $e->getMessage())->withInput();
        }
    }

    /**
     * Display the specified patient.
     */
    public function show(Patient $patient)
    {
        // Load the patient's user account and historical visits
        $patient->load('user');
        $visits = $patient->visits()->with('doctor')->orderBy('visit_date', 'desc')->paginate(5);
        
        return view('admin.patients.show', compact('patient', 'visits'));
    }

    /**
     * Show the form for editing the specified patient.
     */
    public function edit(Patient $patient)
    {
        $patient->load('user');
        return view('admin.patients.edit', compact('patient'));
    }

    /**
     * Update the specified patient in database.
     */
    public function update(PatientRequest $request, Patient $patient)
    {
        DB::beginTransaction();

        try {
            $user = $patient->user;

            // 1. Update the linked User account
            $userData = [
                'name' => $request->name,
                'email' => $request->email,
            ];

            if ($request->filled('password')) {
                $userData['password'] = Hash::make($request->password);
            }

            $user->update($userData);

            // 2. Update the Patient profile details
            $patient->update([
                'name' => $request->name,
                'nik' => $request->nik,
                'birth_date' => $request->birth_date,
                'phone' => $request->phone,
                'address' => $request->address,
            ]);

            DB::commit();
            return redirect()->route('patients.index')->with('success', 'Data pasien berhasil diperbarui.');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Gagal memperbarui data pasien: ' . $e->getMessage())->withInput();
        }
    }

    /**
     * Remove the specified patient from database (soft delete).
     */
    public function destroy(Patient $patient)
    {
        $patient->delete();

        return redirect()->route('patients.index')->with('success', 'Data pasien berhasil dihapus (soft delete).');
    }
}
