# SiKlinik - Sistem Informasi Manajemen Klinik & Antrean Online

Aplikasi Sistem Informasi Manajemen Klinik berbasis Laravel yang dilengkapi dengan Patient Portal, Manajemen Dokter, Booking Antrean Online, Rekam Medis Kunjungan, dan Integrasi Kontainerisasi Docker.

Proyek ini dikembangkan untuk memenuhi penilaian **UTS Praktik Pengembangan Otomasi & Perangkat Lunak (POPL)** dengan metodologi Agile/Scrum.

---

## 🔗 Link Docker Hub Repository
- **Docker Hub Repository**: [https://hub.docker.com/r/raisulakram/siklinik](https://hub.docker.com/r/raisulakram/siklinik)
- **Tag Pengumpulan**: `raisulakram/siklinik:v1-UTS`

---

## 📌 Pembagian Backlog & Tanggung Jawab Tim

### Anggota 2: Patient Portal, Booking & Antrean System, UI Styling & Design Patterns
| Kode | Tipe | User Story / Task | Story Points | Assignee |
| :--- | :--- | :--- | :---: | :---: |
| **KLINIK-6** | Task | Merancang UI Wireframe/Design Pattern (Container-Presenter Pattern / Hooks) untuk modul Pasien. | 3 | Anggota 2 |
| **KLINIK-7** | Story | Sebagai Pasien, saya ingin memuat Profil Pasien dan riwayat medis terdahulu. | 5 | Anggota 2 |
| **KLINIK-8** | Story | Sebagai Pasien, saya ingin melakukan Booking Antrean Online dan memilih Jadwal Dokter. | 8 | Anggota 2 |
| **KLINIK-9** | Story | Sebagai Petugas Klinik, saya ingin Memanggil dan Mengubah Status Antrean pasien secara real-time. | 5 | Anggota 2 |
| **KLINIK-10** | Task | Docker Hub Integration: Menguji run kontainer lokal dari image, push ke Docker Hub publik, dan update README.md. | 5 | Anggota 2 |

---

## 🏛️ Dokumentasi Design Pattern

Aplikasi ini menerapkan standar arsitektur dan pola desain perangkat lunak:
1. **Model-View-Controller (MVC)**:
   - **Model (`app/Models`)**: Menangani representasi data dan relasi basis data (User, Patient, Doctor, Visit).
   - **View (`resources/views`)**: Antarmuka pengguna responsif berbasis Blade templating.
   - **Controller (`app/Http/Controllers`)**: Menangani alur logika bisnis, otorisasi, dan validasi input.
2. **Container-Presenter Pattern (Modul Pasien)**:
   - Memisahkan *data handling/state* (Container di Controller & Blade layout) dari *presentational components* (kartu dokter, status badge antrean, struk ringkasan kunjungan).

---

## 🚀 Fitur Utama Modul Pasien & Antrean
1. **Patient Portal (KLINIK-6)**: Dashboard antarmuka modern untuk memantau status antrean aktif dan riwayat kunjungan.
2. **Profil & Rekam Medis (KLINIK-7)**: Memuat biodata pasien dan riwayat diagnosa serta catatan resep dokter terdahulu.
3. **Booking Antrean Online (KLINIK-8)**: Reservasi jadwal periksa dokter secara online disertai cetak bukti booking/struk antrean (PDF).
4. **Manajemen Antrean Real-time (KLINIK-9)**: Pemanggilan pasien dan perubahan status kunjungan (*menunggu*, *dikonfirmasi*, *selesai*, *dibatalkan*).

---

## 💻 Panduan Instalasi Lokal

1. **Clone Repositori:**
   ```bash
   git clone https://github.com/faruqrais/SiKlinik.git
   cd SiKlinik
   ```

2. **Install Dependensi:**
   ```bash
   composer install
   npm install
   ```

3. **Konfigurasi Environment:**
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

4. **Migrasi & Seeding Database:**
   ```bash
   php artisan migrate --seed
   ```

5. **Jalankan Aplikasi:**
   ```bash
   npm run build
   php artisan serve
   ```
   Akses di browser: `http://localhost:8000`

---

## 🐳 Kontainerisasi Docker (KLINIK-10)

Sesuai instruksi UTS Praktik POPL, aplikasi dikontainerisasi dengan penamaan tag berakhiran `-UTS`:

### 1. Build & Tag Docker Image
```bash
docker build -t raisulakram/siklinik:v1-UTS .
```

### 2. Menguji Run Kontainer Lokal
```bash
docker run -d -p 8000:8000 --name siklinik-app raisulakram/siklinik:v1-UTS
```
Verifikasi dengan membuka `http://localhost:8000` di web browser.

### 3. Push ke Docker Hub Publik
```bash
docker login
docker push raisulakram/siklinik:v1-UTS
```

---
*UTS Praktik POPL - Semester 5*
