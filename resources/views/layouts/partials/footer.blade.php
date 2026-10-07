<!-- Global Footer -->
<footer class="site-footer">
    <div class="footer-top">
        <div class="footer-grid">
            <!-- Kolom 1 — Tentang SiKlinik -->
            <div class="footer-about">
                <div class="footer-brand">
                    <span class="footer-brand-logo">
                        <i class="ti ti-stethoscope"></i>
                    </span>
                    <span class="footer-brand-name">SiKlinik</span>
                </div>
                <p class="footer-about-desc">
                    Sistem Informasi Klinik modern yang memudahkan manajemen pasien, dokter, dan kunjungan dalam satu platform.
                </p>
                <div class="footer-socials">
                    <a href="https://www.facebook.com/profile.php?id=100038856766016" class="footer-social-link" title="Facebook"><i class="ti ti-brand-facebook"></i></a>
                    <a href="https://www.instagram.com/faruq.rais/" class="footer-social-link" title="Instagram"><i class="ti ti-brand-instagram"></i></a>
                    <a href="https://www.instagram.com/faruq.rais/" class="footer-social-link" title="Twitter"><i class="ti ti-brand-twitter"></i></a>
                </div>
            </div>

            <!-- Kolom 2 — Menu Navigasi -->
            <div class="footer-nav">
                <!-- Sub-kolom Menu -->
                <div class="footer-nav-col">
                    <h4 class="footer-title">Menu</h4>
                    <ul class="footer-links">
                        <li>
                            <a href="{{ auth()->check() ? (auth()->user()->role === 'admin' ? route('admin.dashboard') : route('patient.dashboard')) : url('/') }}">
                                Beranda
                            </a>
                        </li>
                        <li>
                            <a href="{{ auth()->check() ? (auth()->user()->role === 'admin' ? route('admin.bookings.index') : route('patient.booking.index')) : route('login') }}">
                                Booking Kunjungan
                            </a>
                        </li>
                        <li>
                            <a href="{{ auth()->check() ? (auth()->user()->role === 'admin' ? route('visits.index') : route('patient.visits.index')) : route('login') }}">
                                Riwayat Kunjungan
                            </a>
                        </li>
                        <li>
                            <a href="{{ auth()->check() ? (auth()->user()->role === 'admin' ? route('admin.dashboard') : route('patient.profile.edit')) : route('login') }}">
                                Profil Saya
                            </a>
                        </li>
                    </ul>
                </div>

                <!-- Sub-kolom Kategori Dokter -->
                <div class="footer-nav-col">
                    <h4 class="footer-title">Kategori Dokter</h4>
                    <ul class="footer-links">
                        <li><span>Dokter Umum</span></li>
                        <li><span>Dokter Mata</span></li>
                        <li><span>Dokter Gigi</span></li>
                        <li><span>Dokter Anak</span></li>
                        <li><span>Dokter Kulit</span></li>
                    </ul>
                </div>
            </div>

            <!-- Kolom 3 — Contact -->
            <div class="footer-contact">
                <h4 class="footer-title">Contact</h4>
                <ul class="footer-contact-list">
                    <li class="footer-contact-item">
                        <i class="ti ti-map-pin"></i>
                        <span>Jl. Jeumpet. 12, Aceh Besar, Aceh 23111</span>
                    </li>
                    <li class="footer-contact-item">
                        <i class="ti ti-mail"></i>
                        <span>siklinik@siklinik.id</span>
                    </li>
                    <li class="footer-contact-item">
                        <i class="ti ti-phone"></i>
                        <span>+62 82367276289</span>
                    </li>
                    <li class="footer-contact-item">
                        <i class="ti ti-clock"></i>
                        <span>Senin - Sabtu, 08.00 - 17.00 WIB</span>
                    </li>
                </ul>
            </div>
        </div>
    </div>

    <!-- Baris Bawah Footer (Copyright Bar) -->
    <div class="footer-bottom">
        <div class="footer-bottom-container">
            <div class="footer-bottom-left">
                © 2025 SiKlinik. Semua hak dilindungi.
            </div>
            <div class="footer-bottom-right">
                Dibuat dengan <i class="ti ti-heart footer-heart"></i> untuk pelayanan kesehatan yang lebih baik
            </div>
        </div>
    </div>
</footer>
