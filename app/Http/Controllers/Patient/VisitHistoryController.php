<?php

namespace App\Http\Controllers\Patient;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class VisitHistoryController extends Controller
{
    /**
     * Display a read-only listing of the patient's visit history.
     */
    public function index()
    {
        $patient = Auth::user()->patient;

        if (!$patient) {
            Auth::logout();
            return redirect()->route('login')->with('error', 'Profil pasien tidak ditemukan.');
        }

        // Fetch paginated visits with doctor details
        $visits = $patient->visits()
            ->with('doctor')
            ->orderBy('visit_date', 'desc')
            ->paginate(10);

        return view('patient.visits.index', compact('visits'));
    }
}
