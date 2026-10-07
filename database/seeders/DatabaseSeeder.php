<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Doctor;
use App\Models\Patient;
use App\Models\Visit;
use App\Models\Specialization;
use App\Models\Complaint;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

/**
 * Idempotent Database Seeder.
 * Populates and updates Clinic tables, Specializations, Complaints, and default accounts
 * safely without breaking existing user-registered data.
 */
class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Create Specializations (using firstOrCreate)
        $specUmum = Specialization::firstOrCreate(['name' => 'Dokter Umum']);
        $specMata = Specialization::firstOrCreate(['name' => 'Dokter Mata']);
        $specGigi = Specialization::firstOrCreate(['name' => 'Dokter Gigi']);
        $specAnak = Specialization::firstOrCreate(['name' => 'Dokter Anak']);
        $specKulit = Specialization::firstOrCreate(['name' => 'Dokter Kulit']);

        // 2. Create Complaints mapped to specializations (using firstOrCreate)
        // Dokter Umum
        Complaint::firstOrCreate(['name' => 'Demam'], ['specialization_id' => $specUmum->id]);
        Complaint::firstOrCreate(['name' => 'Batuk & Pilek'], ['specialization_id' => $specUmum->id]);
        Complaint::firstOrCreate(['name' => 'Sakit Kepala'], ['specialization_id' => $specUmum->id]);
        Complaint::firstOrCreate(['name' => 'Lemas'], ['specialization_id' => $specUmum->id]);

        // Dokter Mata
        Complaint::firstOrCreate(['name' => 'Sakit Mata'], ['specialization_id' => $specMata->id]);
        Complaint::firstOrCreate(['name' => 'Mata Merah'], ['specialization_id' => $specMata->id]);
        Complaint::firstOrCreate(['name' => 'Penglihatan Kabur'], ['specialization_id' => $specMata->id]);

        // Dokter Gigi
        Complaint::firstOrCreate(['name' => 'Sakit Gigi'], ['specialization_id' => $specGigi->id]);
        Complaint::firstOrCreate(['name' => 'Gusi Berdarah'], ['specialization_id' => $specGigi->id]);
        Complaint::firstOrCreate(['name' => 'Cabut Gigi'], ['specialization_id' => $specGigi->id]);

        // Dokter Anak
        Complaint::firstOrCreate(['name' => 'Demam Anak'], ['specialization_id' => $specAnak->id]);
        Complaint::firstOrCreate(['name' => 'Diare Anak'], ['specialization_id' => $specAnak->id]);
        Complaint::firstOrCreate(['name' => 'Tumbuh Kembang'], ['specialization_id' => $specAnak->id]);

        // Dokter Kulit
        Complaint::firstOrCreate(['name' => 'Gatal-gatal'], ['specialization_id' => $specKulit->id]);
        Complaint::firstOrCreate(['name' => 'Jerawat'], ['specialization_id' => $specKulit->id]);
        Complaint::firstOrCreate(['name' => 'Alergi Kulit'], ['specialization_id' => $specKulit->id]);

        // 3. Create Admin Account
        User::firstOrCreate(
            ['email' => 'admin@siklinik.com'],
            [
                'name' => 'Administrator SiKlinik',
                'password' => Hash::make('admin123'),
                'role' => 'admin',
            ]
        );

        // 4. Create/Update Doctors linked to Specializations
        $doctor1 = Doctor::updateOrCreate(
            ['name' => 'dr. Budi Santoso, Sp.A'],
            [
                'specialization' => 'Spesialis Anak',
                'specialization_id' => $specAnak->id,
                'schedule' => 'Senin - Kamis, 08:00 - 12:00',
                'phone' => '08111222333',
                'consultation_fee' => 100000,
            ]
        );

        $doctor2 = Doctor::updateOrCreate(
            ['name' => 'dr. Siti Aminah, Sp.PD'],
            [
                'specialization' => 'Spesialis Penyakit Dalam',
                'specialization_id' => $specUmum->id,
                'schedule' => 'Selasa & Jumat, 13:00 - 16:00',
                'phone' => '08444555666',
                'consultation_fee' => 75000,
            ]
        );

        $doctor3 = Doctor::updateOrCreate(
            ['name' => 'dr. Hendra Wijaya, Sp.M'],
            [
                'specialization' => 'Dokter Mata',
                'specialization_id' => $specMata->id,
                'schedule' => 'Rabu - Jumat, 09:00 - 13:00',
                'phone' => '08777111222',
                'consultation_fee' => 150000,
            ]
        );

        $doctor4 = Doctor::updateOrCreate(
            ['name' => 'drg. Shinta Lestari'],
            [
                'specialization' => 'Dokter Gigi',
                'specialization_id' => $specGigi->id,
                'schedule' => 'Senin & Kamis, 14:00 - 18:00',
                'phone' => '08999333444',
                'consultation_fee' => 125000,
            ]
        );

        $doctor5 = Doctor::updateOrCreate(
            ['name' => 'dr. Sarah Connor, Sp.KK'],
            [
                'specialization' => 'Dokter Kulit',
                'specialization_id' => $specKulit->id,
                'schedule' => 'Selasa & Kamis, 10:00 - 14:00',
                'phone' => '08111555666',
                'consultation_fee' => 120000,
            ]
        );

        // 5. Create Patients + Patient Accounts
        // Patient 1
        $userPatient1 = User::firstOrCreate(
            ['email' => 'andi@email.com'],
            [
                'name' => 'Andi Wijaya',
                'password' => Hash::make('pasien123'),
                'role' => 'patient',
            ]
        );

        $patient1 = Patient::updateOrCreate(
            ['user_id' => $userPatient1->id],
            [
                'name' => 'Andi Wijaya',
                'nik' => '1234567890123456',
                'birth_date' => '1995-08-15',
                'phone' => '08777888999',
                'address' => 'Jl. Mawar No. 12, Kebayoran Baru, Jakarta Selatan',
            ]
        );

        // Patient 2
        $userPatient2 = User::firstOrCreate(
            ['email' => 'susi@email.com'],
            [
                'name' => 'Susi Susanti',
                'password' => Hash::make('pasien123'),
                'role' => 'patient',
            ]
        );

        $patient2 = Patient::updateOrCreate(
            ['user_id' => $userPatient2->id],
            [
                'name' => 'Susi Susanti',
                'nik' => '6543210987654321',
                'birth_date' => '1998-11-22',
                'phone' => '08999000111',
                'address' => 'Jl. Melati No. 45, Coblong, Bandung',
            ]
        );

        // 6. Create Historical and Active Visits
        // Visit 1: Past visit (Patient 1 with Doctor 1)
        Visit::firstOrCreate(
            [
                'patient_id' => $patient1->id,
                'doctor_id' => $doctor1->id,
                'visit_date' => Carbon::now()->subDays(10)->toDateString(),
            ],
            [
                'complaint' => 'Demam tinggi sejak 2 hari yang lalu, flu berat disertai sakit kepala dan nyeri tenggorokan.',
                'diagnosis' => 'Influenza Tipe A. Diberikan paracetamol 500mg (3x1), vitamin C 500mg (1x1), obat kumur antiseptik, serta disarankan istirahat total selama 3 hari.',
            ]
        );

        // Visit 2: Past visit (Patient 2 with Doctor 1)
        Visit::firstOrCreate(
            [
                'patient_id' => $patient2->id,
                'doctor_id' => $doctor1->id,
                'visit_date' => Carbon::now()->subDays(5)->toDateString(),
            ],
            [
                'complaint' => 'Batuk berdahak tidak kunjung sembuh selama satu minggu, dada terasa agak sesak.',
                'diagnosis' => 'Bronkitis akut ringan. Diberikan ambroxol sirup 120ml (3x1 sendok makan), amoxicillin 500mg (3x1 habiskan), dan disarankan minum banyak air hangat.',
            ]
        );

        // Visit 3: Today's visit (Patient 1 with Doctor 2)
        Visit::firstOrCreate(
            [
                'patient_id' => $patient1->id,
                'doctor_id' => $doctor2->id,
                'visit_date' => Carbon::today()->toDateString(),
            ],
            [
                'complaint' => 'Nyeri lambung parah (ulu hati perih) setelah mengonsumsi makanan ekstra pedas kemarin malam, disertai mual-mual.',
                'diagnosis' => 'Gastritis Akut (Maag). Diresepkan antasida tablet kunyah sebelum makan (3x1) dan omeprazole kapsul 20mg sebelum sarapan pagi (1x1). Hindari makanan pedas dan asam.',
            ]
        );
    }
}
