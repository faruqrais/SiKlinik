<?php

namespace Database\Seeders;

use App\Models\Doctor;
use Illuminate\Database\Seeder;

/**
 * Seeder to populate/update the consultation fees of existing doctors
 * based on their specialization type.
 */
class DoctorFeeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $doctors = Doctor::all();

        foreach ($doctors as $doctor) {
            $fee = 0;
            // Retrieve the specialization name from the relationship to avoid attribute collision
            $specName = $doctor->specialization()->first()?->name ?? '';

            // Map based on specialization name or the doctor's specialization string field
            if (stripos($specName, 'Umum') !== false || stripos($doctor->specialization, 'Umum') !== false || stripos($doctor->specialization, 'Dalam') !== false) {
                $fee = 75000;
            } elseif (stripos($specName, 'Mata') !== false || stripos($doctor->specialization, 'Mata') !== false) {
                $fee = 150000;
            } elseif (stripos($specName, 'Gigi') !== false || stripos($doctor->specialization, 'Gigi') !== false) {
                $fee = 125000;
            } elseif (stripos($specName, 'Anak') !== false || stripos($doctor->specialization, 'Anak') !== false) {
                $fee = 100000;
            } elseif (stripos($specName, 'Kulit') !== false || stripos($doctor->specialization, 'Kulit') !== false) {
                $fee = 120000;
            } else {
                $fee = 75000; // default fallback
            }

            $doctor->update([
                'consultation_fee' => $fee
            ]);
        }
    }
}
