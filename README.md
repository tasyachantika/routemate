# RouteMate

RouteMate adalah aplikasi web perencanaan perjalanan wisata (domestik dan internasional):
pengguna dapat mencari destinasi, melihat lokasinya pada peta interaktif, menyusun itinerary
secara manual (urutan, tanggal, dan jam kunjungan), serta mencatat perkiraan anggaran dengan
mata uang yang dipilih manual. Proyek ini dibuat untuk mata kuliah Cyber Security dengan
penekanan pada penerapan keamanan di dalam kode aplikasi.

## Teknologi

- Laravel 12 (PHP 8.2), MySQL, Blade, Bootstrap 5
- Leaflet dan OpenStreetMap (peta interaktif)
- Cloudflare Turnstile (CAPTCHA pada registrasi dan login)

## Fitur

- Registrasi dan login pengguna; login admin terpisah di /admin/login (tanpa registrasi)
- Daftar, pencarian, dan filter destinasi; halaman detail destinasi
- Peta interaktif berisi penanda semua destinasi
- Itinerary: buat trip, tambah destinasi, urutan manual naik/turun, jadwal kunjungan, zona waktu
- Anggaran per trip dengan kategori biaya dan total per mata uang (tanpa konversi kurs otomatis)
- Panel admin: kelola kategori dan destinasi (termasuk unggah foto tervalidasi)

## Keamanan yang Diterapkan

- Password di-hash dengan bcrypt; tidak ada password tersimpan sebagai teks biasa
- Pencegahan SQL Injection melalui Eloquent ORM dan parameter binding
- Output di-escape oleh Blade untuk mencegah XSS; popup peta dibangun dengan textContent
- Session diregenerasi setelah login dan dimusnahkan (invalidate) saat logout
- RBAC: area admin dilindungi middleware admin di sisi server
- Pencegahan IDOR: pengguna hanya dapat mengakses data miliknya; pelanggaran dijawab 404
- Proteksi CSRF pada semua formulir; rate limiting pada login (throttle)
- CAPTCHA Cloudflare Turnstile dengan verifikasi token di sisi server (fail closed)
- Validasi server pada semua input, termasuk koordinat dan unggah foto (gambar, maks 2 MB)
- Secret disimpan di .env yang tidak diunggah ke GitHub; .env.example disediakan sebagai templat

## Menjalankan Secara Lokal

1. `composer install`
2. Salin `.env.example` menjadi `.env`, isi konfigurasi database dan kunci Turnstile
3. `php artisan key:generate`
4. Buat database MySQL `routemate_db`, lalu `php artisan migrate --seed`
5. `php artisan storage:link`
6. `php artisan serve`, buka http://127.0.0.1:8000

Akun admin dan akun demo dibuat oleh seeder dari nilai ADMIN_* dan DEMO_USER_* pada .env
masing-masing pemasang, sehingga tidak ada kata sandi yang ditulis di repository ini.

## Pengujian Keamanan

Pengujian dilakukan secara manual terdokumentasi, meliputi: SQL Injection pada pencarian dan
login, XSS tersimpan, pemeriksaan hashing password, CSRF tanpa token (HTTP 419), rate limiting
login (HTTP 429), sesi setelah logout, RBAC (HTTP 403), IDOR antar-pengguna (HTTP 404),
verifikasi CAPTCHA sisi server, validasi unggah berkas, dan `composer audit`.
Hasil rinci beserta bukti tangkapan layar terdapat pada laporan proyek.
