<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Visit;
use Illuminate\Http\Request;

class BookingManagementController extends Controller
{
    /**
     * Display a listing of all bookings with filters.
     */
    public function index(Request $request)
    {
        $query = Visit::with(['patient', 'doctor', 'complaint'])
            ->whereNotNull('booking_date'); // only show visits that were booked

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Filter by date
        if ($request->filled('date')) {
            $query->whereDate('booking_date', $request->date);
        }

        // Retrieve paginated bookings
        $bookings = $query->orderBy('booking_date', 'desc')
            ->orderBy('booking_time', 'desc')
            ->paginate(15);

        // Keep filter inputs in pagination links
        $bookings->appends($request->all());

        return view('admin.bookings.index', compact('bookings'));
    }

    /**
     * Update the status of a visit booking.
     * Route: PATCH /admin/bookings/{id}/status
     */
    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => ['required', 'in:menunggu,dikonfirmasi,selesai,dibatalkan'],
        ], [
            'status.in' => 'Status yang dipilih tidak valid.',
        ]);

        $booking = Visit::findOrFail($id);
        
        $oldStatus = $booking->status;
        $newStatus = $request->status;

        // Perform status update
        $booking->update([
            'status' => $newStatus,
        ]);

        // If booking status transitions to "selesai", let's update diagnosis text if default is still active
        if ($newStatus === 'selesai' && $booking->diagnosis === 'Menunggu diagnosa dokter.') {
            $booking->update([
                'diagnosis' => 'Pemeriksaan selesai. (Silakan perbarui diagnosis detail di Rekam Medis Kunjungan)',
            ]);
        }

        return back()->with('success', 'Status booking #' . $id . ' berhasil diubah dari "' . $oldStatus . '" menjadi "' . $newStatus . '".');
    }

    /**
     * Update the payment status of a visit booking to 'sudah_bayar'.
     * Route: PATCH /admin/bookings/{id}/payment
     */
    public function updatePaymentStatus($id)
    {
        $booking = Visit::findOrFail($id);

        // Update payment status
        $booking->update([
            'payment_status' => 'sudah_bayar',
        ]);

        return back()->with('success', 'Pembayaran untuk booking ' . ($booking->booking_code ?? '#' . $booking->id) . ' berhasil dikonfirmasi (Sudah Bayar).');
    }
}
