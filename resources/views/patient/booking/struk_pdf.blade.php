<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Struk Booking {{ $booking->booking_code }}</title>
    <style>
        /* CSS reset and printable constraints compatible with DomPDF */
        body {
            font-family: 'Courier New', Courier, monospace;
            font-size: 11pt;
            color: #333;
            line-height: 1.4;
            margin: 0;
            padding: 0;
            background-color: #fff;
        }
        .struk-card {
            width: 100%;
            max-width: 100%;
            margin: 0 auto;
            padding: 10px;
        }
        .text-center {
            text-align: center;
        }
        .text-right {
            text-align: right;
        }
        .font-bold {
            font-weight: bold;
        }
        .uppercase {
            text-transform: uppercase;
        }
        .mb-2 {
            margin-bottom: 8px;
        }
        .mb-4 {
            margin-bottom: 16px;
        }
        .my-4 {
            margin-top: 16px;
            margin-bottom: 16px;
        }
        .header-title {
            font-size: 16pt;
            font-weight: bold;
            margin: 0;
            color: #000;
        }
        .header-subtitle {
            font-size: 9pt;
            color: #666;
            margin: 2px 0;
        }
        .divider {
            border-bottom: 1px dashed #666;
            margin: 12px 0;
        }
        .solid-line {
            border-bottom: 1px solid #ccc;
            margin: 6px 0;
        }
        .section-title {
            font-size: 9pt;
            font-weight: bold;
            color: #000;
            margin-bottom: 6px;
            letter-spacing: 1px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        table td {
            padding: 3px 0;
            vertical-align: top;
            font-size: 10pt;
        }
        .fee-label {
            font-size: 10pt;
        }
        .fee-value {
            font-size: 10pt;
            text-align: right;
        }
        .total-row td {
            font-size: 11pt;
            font-weight: bold;
            color: #000;
            padding-top: 6px;
        }
        .footer-message {
            font-size: 9pt;
            color: #555;
            margin-top: 25px;
            line-height: 1.5;
        }
    </style>
</head>
<body>

    <div class="struk-card">
        
        <!-- Header -->
        <div class="text-center">
            <div class="header-title">SiKlinik</div>
            <div class="header-subtitle">Sistem Informasi Klinik</div>
            <div class="header-subtitle">Jl. Kesehatan No.12, Banda Aceh</div>
            <div class="header-subtitle">Telp: (0651) 123-4567</div>
        </div>

        <div class="divider"></div>

        <!-- Title -->
        <div class="text-center font-bold uppercase mb-4" style="letter-spacing: 1px;">
            BUKTI BOOKING KUNJUNGAN
        </div>

        <!-- Meta Info -->
        <table>
            <tr>
                <td>Kode Booking</td>
                <td class="text-right font-bold" style="color: #000;">{{ $booking->booking_code }}</td>
            </tr>
            <tr>
                <td>Tanggal Cetak</td>
                <td class="text-right">{{ now()->format('d-m-Y H:i') }}</td>
            </tr>
            <tr>
                <td>Status</td>
                <td class="text-right font-bold" style="color: #0284c7;">
                    @if($booking->status === 'menunggu')
                        Menunggu Konfirmasi
                    @elseif($booking->status === 'dikonfirmasi')
                        Dikonfirmasi
                    @elseif($booking->status === 'selesai')
                        Selesai
                    @elseif($booking->status === 'dibatalkan')
                        Dibatalkan
                    @else
                        {{ ucfirst($booking->status) }}
                    @endif
                </td>
            </tr>
        </table>

        <div class="divider"></div>

        <!-- Patient Section -->
        <div class="section-title">DATA PASIEN</div>
        <table>
            <tr>
                <td style="width: 100px;">Nama</td>
                <td style="width: 15px;">:</td>
                <td class="font-bold">{{ $booking->patient->name ?? 'Pasien' }}</td>
            </tr>
            <tr>
                <td>NIK</td>
                <td>:</td>
                <td>{{ $booking->patient->nik ?? '-' }}</td>
            </tr>
        </table>

        <div class="divider"></div>

        <!-- Appointment Section -->
        <div class="section-title">DETAIL KUNJUNGAN</div>
        <table>
            <tr>
                <td style="width: 100px;">Keluhan</td>
                <td style="width: 15px;">:</td>
                <td class="font-bold">{{ $booking->complaint }}</td>
            </tr>
            <tr>
                <td>Dokter</td>
                <td>:</td>
                <td class="font-bold">{{ $booking->doctor->name ?? '-' }}</td>
            </tr>
            <tr>
                <td>Spesialisasi</td>
                <td>:</td>
                <td>{{ $booking->doctor->specialization ?? '-' }}</td>
            </tr>
            <tr>
                <td>Tanggal</td>
                <td>:</td>
                <td class="font-bold">
                    @php
                        $days = ['Sunday' => 'Minggu', 'Monday' => 'Senin', 'Tuesday' => 'Selasa', 'Wednesday' => 'Rabu', 'Thursday' => 'Kamis', 'Friday' => 'Jumat', 'Saturday' => 'Sabtu'];
                        $months = ['Jan' => 'Jan', 'Feb' => 'Feb', 'Mar' => 'Mar', 'Apr' => 'Apr', 'May' => 'Mei', 'Jun' => 'Jun', 'Jul' => 'Jul', 'Aug' => 'Agu', 'Sep' => 'Sep', 'Oct' => 'Okt', 'Nov' => 'Nov', 'Dec' => 'Des'];
                        
                        $carbonDate = \Carbon\Carbon::parse($booking->booking_date);
                        $dayName = $days[$carbonDate->format('l')] ?? $carbonDate->format('l');
                        $dayNum = $carbonDate->format('j');
                        $monthName = $months[$carbonDate->format('M')] ?? $carbonDate->format('M');
                        $year = $carbonDate->format('Y');
                        $formattedDate = "{$dayName}, {$dayNum} {$monthName} {$year}";
                    @endphp
                    {{ $formattedDate }}
                </td>
            </tr>
            <tr>
                <td>Waktu</td>
                <td>:</td>
                <td class="font-bold">{{ $booking->booking_time ? substr($booking->booking_time, 0, 5) : '-' }} WIB</td>
            </tr>
        </table>

        <div class="divider"></div>

        <!-- Cost Section -->
        <div class="section-title">RINCIAN BIAYA</div>
        <table>
            <tr>
                <td class="fee-label">Tarif Konsultasi</td>
                <td class="fee-value">Rp {{ number_format($booking->consultation_fee, 0, ',', '.') }}</td>
            </tr>
            <tr>
                <td class="fee-label">Biaya Admin</td>
                <td class="fee-value">Rp {{ number_format($booking->admin_fee, 0, ',', '.') }}</td>
            </tr>
            <tr class="total-row">
                <td style="border-top: 1px solid #ccc; padding-top: 6px;">TOTAL</td>
                <td style="border-top: 1px solid #ccc; padding-top: 6px; text-align: right;">Rp {{ number_format($booking->total_fee, 0, ',', '.') }}</td>
            </tr>
            <tr>
                <td style="font-size: 8pt; color: #555; padding-top: 4px;">Metode Bayar</td>
                <td style="font-size: 8pt; color: #555; padding-top: 4px; text-align: right; font-weight: bold; text-transform: uppercase;">Bayar di Klinik</td>
            </tr>
        </table>

        <div class="divider"></div>

        <!-- Footer Message -->
        <div class="text-center footer-message">
            <div>Harap tunjukkan bukti ini</div>
            <div>kepada petugas saat tiba di klinik</div>
            <div style="margin-top: 15px; font-weight: bold;">Terima kasih telah mempercayakan</div>
            <div style="font-weight: bold;">kesehatan Anda kepada SiKlinik</div>
        </div>

    </div>

</body>
</html>
