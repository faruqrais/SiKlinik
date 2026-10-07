<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\VisitRequest;
use App\Models\Doctor;
use App\Models\Patient;
use App\Models\Visit;

class VisitController extends Controller
{
    /**
     * Display a listing of visits.
     */
    public function index()
    {
        $visits = Visit::with(['patient', 'doctor'])
            ->orderBy('visit_date', 'desc')
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('admin.visits.index', compact('visits'));
    }

    /**
     * Show the form for creating a new visit.
     */
    public function create()
    {
        $patients = Patient::orderBy('name', 'asc')->get();
        $doctors = Doctor::orderBy('name', 'asc')->get();
        
        return view('admin.visits.create', compact('patients', 'doctors'));
    }

    /**
     * Store a newly created visit in database.
     */
    public function store(VisitRequest $request)
    {
        Visit::create($request->validated());

        return redirect()->route('visits.index')->with('success', 'Data kunjungan berhasil ditambahkan.');
    }

    /**
     * Display the specified visit details.
     */
    public function show(Visit $visit)
    {
        $visit->load(['patient', 'doctor']);
        return view('admin.visits.show', compact('visit'));
    }

    /**
     * Show the form for editing the specified visit.
     */
    public function edit(Visit $visit)
    {
        $patients = Patient::orderBy('name', 'asc')->get();
        $doctors = Doctor::orderBy('name', 'asc')->get();
        
        return view('admin.visits.edit', compact('visit', 'patients', 'doctors'));
    }

    /**
     * Update the specified visit in database.
     */
    public function update(VisitRequest $request, Visit $visit)
    {
        $visit->update($request->validated());

        return redirect()->route('visits.index')->with('success', 'Data kunjungan berhasil diperbarui.');
    }

    /**
     * Remove the specified visit from database (soft delete).
     */
    public function destroy(Visit $visit)
    {
        $visit->delete();

        return redirect()->route('visits.index')->with('success', 'Data kunjungan berhasil dihapus (soft delete).');
    }
}
