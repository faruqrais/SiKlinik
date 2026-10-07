<?php

namespace App\Http\Controllers\Patient;

use App\Http\Controllers\Controller;
use App\Http\Requests\BookingRequest;
use App\Models\Complaint;
use App\Models\Doctor;
use App\Models\Visit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BookingController extends Controller
{
    /**
     * Show the booking step wizard form.
     */
    public function index()
    {
        $patient = Auth::user()->patient;

        if (!$patient) {
            Auth::logout();
            return redirect()->route('login')->with('error', 'Profil pasien tidak ditemukan.');
        }

        // Fetch all available complaints for Step 1
        $complaints = Complaint::orderBy('name', 'asc')->get();

        return view('patient.booking.index', compact('complaints'));
    }

    /**
     * AJAX endpoint to fetch doctors matching a complaint's specialization.
     * Route: GET /patient/booking/doctors?complaint_id={id}
     */
    public function getDoctor(Request $request)
    {
        $complaintId = $request->query('complaint_id');

        if (!$complaintId) {
            return response()->json(['doctors' => []]);
        }

        $complaint = Complaint::find($complaintId);

        if (!$complaint) {
            return response()->json(['doctors' => []]);
        }

        // Fetch doctors with the same specialization
        $doctors = Doctor::where('specialization_id', $complaint->specialization_id)
            ->orderBy('name', 'asc')
            ->get();

        // Map doctors to match requested response format
        $mappedDoctors = $doctors->map(function ($doctor) {
            return [
                'id' => $doctor->id,
                'name' => $doctor->name,
                'specialization' => $doctor->specialization, // original string specialization
                'schedule' => $doctor->schedule,
                'consultation_fee' => $doctor->consultation_fee,
                'consultation_fee_formatted' => 'Rp ' . number_format($doctor->consultation_fee, 0, ',', '.'),
            ];
        });

        return response()->json(['doctors' => $mappedDoctors]);
    }

    /**
     * Store the visit booking request.
     */
    public function store(BookingRequest $request)
    {
        $patient = Auth::user()->patient;

        if (!$patient) {
            return redirect()->route('login')->with('error', 'Profil pasien tidak ditemukan.');
        }

        // Fetch selected doctor and complaint models
        $doctorModel = Doctor::findOrFail($request->doctor_id);
        $complaintModel = Complaint::find($request->complaint_id);

        // Generate unique booking code: SKL-{YEAR}{MONTH}{DAY}-{4 random digits}
        $dateStr = now()->format('Ymd');
        do {
            $randomDigits = str_pad(rand(0, 9999), 4, '0', STR_PAD_LEFT);
            $bookingCode = "SKL-{$dateStr}-{$randomDigits}";
        } while (Visit::where('booking_code', $bookingCode)->exists());

        // Copy pricing structure from doctor table to secure transaction details
        $consultationFee = $doctorModel->consultation_fee;
        $adminFee = 5000;
        $totalFee = $consultationFee + $adminFee;

        // Create Visit record
        Visit::create([
            'patient_id' => $patient->id,
            'doctor_id' => $request->doctor_id,
            'complaint_id' => $request->complaint_id,
            'visit_date' => $request->booking_date,
            'complaint' => $complaintModel ? $complaintModel->name : 'Keluhan Kustom',
            'diagnosis' => 'Menunggu diagnosa dokter.', // default pending text
            'status' => 'menunggu',
            'booking_date' => $request->booking_date,
            'booking_time' => $request->booking_time,
            'booking_code' => $bookingCode,
            'consultation_fee' => $consultationFee,
            'admin_fee' => $adminFee,
            'total_fee' => $totalFee,
            'payment_status' => 'belum_bayar',
        ]);

        return redirect()->route('patient.booking.struk', $bookingCode)->with('success', 'Booking kunjungan Anda berhasil didaftarkan.');
    }

    /**
     * Display the booking history of the patient.
     */
    public function history()
    {
        $patient = Auth::user()->patient;

        if (!$patient) {
            Auth::logout();
            return redirect()->route('login')->with('error', 'Profil pasien tidak ditemukan.');
        }

        // Retrieve patient's bookings (visits with booking details)
        $bookings = Visit::with(['doctor', 'complaint'])
            ->where('patient_id', $patient->id)
            ->whereNotNull('booking_date') // filter only booking visits
            ->orderBy('booking_date', 'desc')
            ->orderBy('booking_time', 'desc')
            ->paginate(10);

        return view('patient.booking.history', compact('bookings'));
    }

    /**
     * Cancel a pending booking.
     * Route: PATCH /patient/booking/{id}/cancel
     */
    public function cancel($id)
    {
        $patient = Auth::user()->patient;

        if (!$patient) {
            return redirect()->route('login')->with('error', 'Profil pasien tidak ditemukan.');
        }

        // Find the booking and ensure it belongs to the logged-in patient
        $booking = Visit::where('id', $id)
            ->where('patient_id', $patient->id)
            ->firstOrFail();

        // Check if the booking is still pending
        if ($booking->status !== 'menunggu') {
            return back()->with('error', 'Booking tidak dapat dibatalkan karena statusnya sudah berubah.');
        }

        // Update status to dibatalkan
        $booking->update([
            'status' => 'dibatalkan',
        ]);

        return back()->with('success', 'Booking kunjungan berhasil dibatalkan.');
    }

    /**
     * Display the booking receipt/struk page.
     * Route: GET /patient/booking/{booking_code}/struk
     */
    public function struk($bookingCode)
    {
        $patient = Auth::user()->patient;

        if (!$patient) {
            return redirect()->route('login')->with('error', 'Profil pasien tidak ditemukan.');
        }

        // Fetch the visit booking along with related patient and doctor models
        $booking = Visit::with(['doctor', 'complaint', 'patient'])
            ->where('booking_code', $bookingCode)
            ->where('patient_id', $patient->id)
            ->firstOrFail();

        return view('patient.booking.struk', compact('booking'));
    }

    /**
     * Generate and download the booking receipt as a PDF.
     * Route: GET /patient/booking/{booking_code}/download-pdf
     */
    public function downloadPdf($bookingCode)
    {
        $patient = Auth::user()->patient;

        if (!$patient) {
            return redirect()->route('login')->with('error', 'Profil pasien tidak ditemukan.');
        }

        // Fetch booking details
        $booking = Visit::with(['doctor', 'complaint', 'patient'])
            ->where('booking_code', $bookingCode)
            ->where('patient_id', $patient->id)
            ->firstOrFail();

        // Render PDF view using barryvdh/laravel-dompdf
        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('patient.booking.struk_pdf', compact('booking'))
            ->setPaper('a5', 'portrait');

        return $pdf->download("Struk-Booking-{$bookingCode}.pdf");
    }
}
