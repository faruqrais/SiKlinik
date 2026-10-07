/**
 * SiKlinik - Booking Portal Form Wizard and AJAX Filters
 * Controls step navigations, dynamically loads doctors, and populates booking summaries.
 */

document.addEventListener('DOMContentLoaded', () => {
    let currentStep = 1;
    const totalSteps = 4;

    // Elements
    const prevBtn = document.getElementById('prev-btn');
    const nextBtn = document.getElementById('next-btn');
    const submitBtn = document.getElementById('submit-btn');
    const complaintSelect = document.getElementById('complaint_id');
    const doctorIdInput = document.getElementById('doctor_id');
    const doctorContainer = document.getElementById('doctor-container');
    const doctorLoading = document.getElementById('doctor-loading');
    const doctorEmpty = document.getElementById('doctor-empty');

    const bookingDateInput = document.getElementById('booking_date');
    const bookingTimeInput = document.getElementById('booking_time');

    // Summary Elements
    const summaryComplaint = document.getElementById('summary-complaint');
    const summaryDoctorName = document.getElementById('summary-doctor-name');
    const summaryDoctorSpec = document.getElementById('summary-doctor-spec');
    const summaryDoctorSchedule = document.getElementById('summary-doctor-schedule');
    const summaryBookingDatetime = document.getElementById('summary-booking-datetime');

    // Object to hold active selections for the summary step
    let selectedDoctorData = {
        name: '',
        specialization: '',
        schedule: ''
    };

    // 1. AJAX FETCH: Fetch doctors list when complaint is chosen
    if (complaintSelect) {
        complaintSelect.addEventListener('change', () => {
            const complaintId = complaintSelect.value;
            
            // Reset selected doctor
            doctorIdInput.value = '';
            
            // Show Loader and Clear cards
            doctorContainer.innerHTML = '';
            doctorEmpty.classList.add('hidden');
            doctorLoading.classList.remove('hidden');

            // Execute fetch API
            fetch(`/patient/booking/doctors?complaint_id=${complaintId}`)
                .then(response => response.json())
                .then(data => {
                    doctorLoading.classList.add('hidden');
                    
                    if (data.doctors.length === 0) {
                        doctorEmpty.classList.remove('hidden');
                        return;
                    }

                    // Render doctor cards
                    data.doctors.forEach(doctor => {
                        const card = document.createElement('div');
                        card.className = 'doctor-select-card bg-white rounded-xl p-4 flex flex-col justify-between gap-3 border shadow-sm relative overflow-hidden';
                        card.setAttribute('data-id', doctor.id);
                        card.setAttribute('data-name', doctor.name);
                        card.setAttribute('data-spec', doctor.specialization);
                        card.setAttribute('data-schedule', doctor.schedule);

                        card.innerHTML = `
                            <div class="flex items-start justify-between">
                                <div class="flex flex-col gap-0.5">
                                    <h4 class="font-bold text-slate-800 text-sm">${doctor.name}</h4>
                                    <span class="text-xs font-semibold px-2 py-0.5 self-start rounded bg-blue-50 text-blue-700 mt-1">${doctor.specialization}</span>
                                    <span class="text-sm font-semibold text-slate-700 mt-2">${doctor.consultation_fee_formatted}</span>
                                </div>
                                <div class="flex flex-col items-end gap-2">
                                    <span class="select-badge px-2.5 py-1 rounded-full text-xs font-bold border border-slate-200 text-slate-500 bg-slate-50 transition select-none">Pilih Dokter</span>
                                    <span class="check-badge opacity-0 scale-95 transition p-1 bg-blue-600 text-white rounded-full">
                                        <svg class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                                        </svg>
                                    </span>
                                </div>
                            </div>
                            <div class="border-t border-slate-100 pt-2 flex flex-col gap-0.5 text-xs text-slate-500">
                                <span class="font-bold uppercase tracking-wider text-[9px] text-slate-400">Jadwal Praktek</span>
                                <span class="font-medium text-slate-700">${doctor.schedule}</span>
                            </div>
                        `;

                        // Add Select Click Handler
                        card.addEventListener('click', () => {
                            // Remove selection class from others
                            document.querySelectorAll('.doctor-select-card').forEach(c => {
                                c.classList.remove('selected');
                                const badge = c.querySelector('.select-badge');
                                if (badge) {
                                    badge.textContent = 'Pilih Dokter';
                                    badge.className = 'select-badge px-2.5 py-1 rounded-full text-xs font-bold border border-slate-200 text-slate-500 bg-slate-50 transition select-none';
                                }
                                const check = c.querySelector('.check-badge');
                                if (check) check.classList.add('opacity-0');
                            });

                            // Select current card
                            card.classList.add('selected');
                            const badge = card.querySelector('.select-badge');
                            if (badge) {
                                badge.textContent = '✓ Terpilih';
                                badge.className = 'select-badge px-2.5 py-1 rounded-full text-xs font-bold border border-blue-600 text-white bg-blue-600 transition select-none';
                            }
                            const check = card.querySelector('.check-badge');
                            if (check) check.classList.remove('opacity-0');
                            
                            // Bind value to input
                            doctorIdInput.value = doctor.id;

                            // Cache details for summary page
                            selectedDoctorData.name = doctor.name;
                            selectedDoctorData.specialization = doctor.specialization;
                            selectedDoctorData.schedule = doctor.schedule;
                            selectedDoctorData.consultation_fee = doctor.consultation_fee;
                            selectedDoctorData.consultation_fee_formatted = doctor.consultation_fee_formatted;
                        });

                        doctorContainer.appendChild(card);
                    });
                })
                .catch(error => {
                    console.error('Error fetching doctors:', error);
                    doctorLoading.classList.add('hidden');
                    doctorEmpty.classList.remove('hidden');
                });
        });
    }

    // 2. WIZARD NAVIGATION: Next/Back step triggers
    if (nextBtn && prevBtn && submitBtn) {
        
        nextBtn.addEventListener('click', () => {
            if (validateStep(currentStep)) {
                // If transitioning to Step 4, populate summary card
                if (currentStep === 3) {
                    populateSummary();
                }

                // Update Step indicators
                document.getElementById(`ind-${currentStep}`).classList.remove('active');
                document.getElementById(`ind-${currentStep}`).classList.add('completed');
                
                // Hide current panel
                document.getElementById(`step-panel-${currentStep}`).classList.add('hidden');
                
                // Show next panel
                currentStep++;
                document.getElementById(`step-panel-${currentStep}`).classList.remove('hidden');
                document.getElementById(`ind-${currentStep}`).classList.add('active');

                updateWizardControls();
            }
        });

        prevBtn.addEventListener('click', () => {
            // Update Step indicators
            document.getElementById(`ind-${currentStep}`).classList.remove('active');
            
            // Hide current panel
            document.getElementById(`step-panel-${currentStep}`).classList.add('hidden');
            
            // Show prev panel
            currentStep--;
            document.getElementById(`step-panel-${currentStep}`).classList.remove('hidden');
            document.getElementById(`ind-${currentStep}`).classList.remove('completed');
            document.getElementById(`ind-${currentStep}`).classList.add('active');

            updateWizardControls();
        });
    }

    // Helper to toggle visible buttons based on steps
    function updateWizardControls() {
        // Prev button visibility
        if (currentStep === 1) {
            prevBtn.classList.add('hidden');
        } else {
            prevBtn.classList.remove('hidden');
        }

        // Next / Submit button visibility
        if (currentStep === totalSteps) {
            nextBtn.classList.add('hidden');
            submitBtn.classList.remove('hidden');
        } else {
            nextBtn.classList.remove('hidden');
            submitBtn.classList.add('hidden');
        }
    }

    // Input Validations per step
    function validateStep(step) {
        if (step === 1) {
            if (!complaintSelect.value) {
                alert('Silakan pilih keluhan Anda terlebih dahulu.');
                return false;
            }
        } else if (step === 2) {
            if (!doctorIdInput.value) {
                alert('Silakan pilih salah satu dokter spesialis yang tersedia.');
                return false;
            }
        } else if (step === 3) {
            if (!bookingDateInput.value) {
                alert('Silakan tentukan tanggal kunjungan.');
                return false;
            }
            if (!bookingTimeInput.value) {
                alert('Silakan tentukan jam kunjungan.');
                return false;
            }

            // Ensure date is not in the past
            const selectedDate = new Date(bookingDateInput.value);
            selectedDate.setHours(0,0,0,0);
            const today = new Date();
            today.setHours(0,0,0,0);

            if (selectedDate < today) {
                alert('Tanggal kunjungan tidak boleh di masa lalu.');
                return false;
            }
        }
        return true;
    }

    // Helper to format date as Indonesian weekday, day Month year (e.g. Senin, 2 Jun 2025)
    function formatIndonesianDate(dateString) {
        const parts = dateString.split('-'); // [YYYY, MM, DD]
        if (parts.length !== 3) return dateString;
        const year = parseInt(parts[0], 10);
        const month = parseInt(parts[1], 10) - 1; // 0-based index
        const day = parseInt(parts[2], 10);
        
        const date = new Date(year, month, day);
        
        const days = ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];
        const months = ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'];
        
        const dayName = days[date.getDay()];
        const monthName = months[date.getMonth()];
        
        return `${dayName}, ${day} ${monthName} ${year}`;
    }

    // Helper to format numbers as Rupiah currency
    function formatRupiah(amount) {
        return new Intl.NumberFormat('id-ID', { minimumFractionDigits: 0 }).format(amount);
    }

    // Bind values to final Confirmation step
    function populateSummary() {
        const selectedComplaintText = complaintSelect.options[complaintSelect.selectedIndex].text;
        summaryComplaint.textContent = selectedComplaintText;

        summaryDoctorName.textContent = selectedDoctorData.name;
        summaryDoctorSpec.textContent = selectedDoctorData.specialization;
        summaryDoctorSchedule.textContent = selectedDoctorData.schedule;

        // Formats date to Indonesian format (e.g. Senin, 2 Jun 2025)
        const formattedDate = formatIndonesianDate(bookingDateInput.value);
        const timeVal = bookingTimeInput.value;

        summaryBookingDatetime.textContent = `${formattedDate} pukul ${timeVal} WIB`;

        // Calculate and render price breakdown
        const consultationFee = parseFloat(selectedDoctorData.consultation_fee) || 0;
        const adminFee = 5000;
        const totalFee = consultationFee + adminFee;

        document.getElementById('summary-consultation-fee').textContent = 'Rp ' + formatRupiah(consultationFee);
        document.getElementById('summary-admin-fee').textContent = 'Rp ' + formatRupiah(adminFee);
        document.getElementById('summary-total-fee').textContent = 'Rp ' + formatRupiah(totalFee);
    }
});
