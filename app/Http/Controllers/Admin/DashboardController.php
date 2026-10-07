<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Doctor;
use App\Models\Patient;
use App\Models\Visit;
use Carbon\Carbon;

class DashboardController extends Controller
{
    /**
     * Display the Admin Dashboard with statistics and recent activity.
     */
    public function index()
    {
        // 1. Gather counts
        $totalDoctors = Doctor::count();
        $totalPatients = Patient::count();
        
        // 2. Count visits today
        $today = Carbon::today()->toDateString();
        $todayVisits = Visit::whereDate('visit_date', $today)->count();

        // 3. Get recent 5 visits with patient and doctor details
        $recentVisits = Visit::with(['patient', 'doctor'])
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        // 4. Calculate today's earnings from paid bookings
        $todayEarnings = Visit::whereDate('booking_date', $today)
            ->where('payment_status', 'sudah_bayar')
            ->sum('total_fee');

        return view('admin.dashboard', compact('totalDoctors', 'totalPatients', 'todayVisits', 'recentVisits', 'todayEarnings'));
    }
}
