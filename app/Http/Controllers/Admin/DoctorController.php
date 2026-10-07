<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\DoctorRequest;
use App\Models\Doctor;

class DoctorController extends Controller
{
    /**
     * Display a listing of doctors.
     */
    public function index()
    {
        $doctors = Doctor::orderBy('name', 'asc')->paginate(10);
        return view('admin.doctors.index', compact('doctors'));
    }

    /**
     * Show the form for creating a new doctor.
     */
    public function create()
    {
        return view('admin.doctors.create');
    }

    /**
     * Store a newly created doctor in database.
     */
    public function store(DoctorRequest $request)
    {
        Doctor::create($request->validated());

        return redirect()->route('doctors.index')->with('success', 'Data dokter berhasil ditambahkan.');
    }

    /**
     * Display the specified doctor.
     */
    public function show(Doctor $doctor)
    {
        // Load recent visits for this doctor
        $visits = $doctor->visits()->with('patient')->orderBy('visit_date', 'desc')->paginate(5);
        return view('admin.doctors.show', compact('doctor', 'visits'));
    }

    /**
     * Show the form for editing the specified doctor.
     */
    public function edit(Doctor $doctor)
    {
        return view('admin.doctors.edit', compact('doctor'));
    }

    /**
     * Update the specified doctor in database.
     */
    public function update(DoctorRequest $request, Doctor $doctor)
    {
        $doctor->update($request->validated());

        return redirect()->route('doctors.index')->with('success', 'Data dokter berhasil diperbarui.');
    }

    /**
     * Remove the specified doctor from database (soft delete).
     */
    public function destroy(Doctor $doctor)
    {
        $doctor->delete();

        return redirect()->route('doctors.index')->with('success', 'Data dokter berhasil dihapus (soft delete).');
    }
}
