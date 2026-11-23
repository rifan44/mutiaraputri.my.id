# Mutiara Putri — Portfolio

Website portofolio pribadi dwibahasa untuk Mutiara Putri. Dibangun dengan CodeIgniter 4, MariaDB, dan Dompdf. Website publik menggunakan Bahasa Indonesia dan Inggris, dengan panel admin untuk mengelola data serta ekspor CV dan portofolio PDF berukuran A4.

## Kebutuhan

- PHP 8.2 atau lebih baru dengan ekstensi `intl`, `mbstring`, `mysqli`, `dom`, dan `fileinfo`.
- Composer 2.
- MariaDB 10.4+ (atau MySQL 8+) dengan database berkarakter `utf8mb4`.
- Apache dengan `mod_rewrite`, atau Nginx yang diarahkan ke folder `public/`.

## Menyiapkan aplikasi

1. Pasang dependency:

   ```bash
   composer install
   ```

2. Salin `.env.example` menjadi `.env`, lalu isi `app.baseURL` dan akses MariaDB. Jangan commit `.env`.

3. Buat database dan user MariaDB. Contoh:

   ```sql
   CREATE DATABASE mutiaraputri_portfolio CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
   CREATE USER 'portfolio_user'@'localhost' IDENTIFIED BY 'ganti-dengan-kata-sandi-kuat';
   GRANT ALL PRIVILEGES ON mutiaraputri_portfolio.* TO 'portfolio_user'@'localhost';
   FLUSH PRIVILEGES;
   ```

4. Jalankan migrasi dan data awal:

   ```bash
   php spark migrate
   php spark db:seed PortfolioSeeder
   ```

   Seeder hanya menambahkan nama, program studi, universitas, dan semester yang sudah disediakan. Kontak, pengalaman, proyek, sertifikat, dan keahlian bisa ditambahkan melalui admin.

5. Buat akun admin dari terminal. Kata sandi diminta secara interaktif dan hanya disimpan sebagai hash:

   ```bash
   php spark portfolio:create-admin
   ```

6. Untuk pengembangan lokal:

   ```bash
   php spark serve
   ```

   Buka `http://localhost:8080/`; panel admin berada di `/admin`.

## Hosting di home server

- Arahkan document root web server langsung ke folder `public/`, bukan ke root repository.
- Pastikan folder `writable/` dapat ditulis oleh user PHP. File media yang diunggah disimpan di `public/uploads/` dan tidak masuk ke Git.
- Gunakan HTTPS, batasi hak akses MariaDB, dan jangan membuka port MariaDB ke internet.
- Arahkan DNS domain ke endpoint publik server. Jika jaringan ISP memakai CGNAT atau alamat IP berubah, siapkan tunnel/reverse proxy atau DDNS sesuai kondisi jaringan.
- Untuk Apache, aktifkan `mod_rewrite` dan izinkan aturan `.htaccess` pada folder `public/`. Untuk Nginx, gunakan konfigurasi CodeIgniter dengan `root` mengarah ke `public/` dan larang eksekusi PHP di `/uploads/`.
- Pada server production, ubah `CI_ENVIRONMENT` menjadi `production`, atur `app.baseURL` ke `https://mutiaraputri.my.id/`, lalu pasang dependency tanpa paket development:

  ```bash
  composer install --no-dev --optimize-autoloader
  php spark migrate
  ```

## Halaman dan fitur

- `/` — website portofolio Bahasa Indonesia.
- `/en` — website portofolio Bahasa Inggris.
- `/admin` — panel admin terlindungi login.
- `/admin/profile` — profil, foto, kontak, dan tautan.
- `/admin/education`, `/admin/experiences`, `/admin/projects`, `/admin/skills`, `/admin/certificates` — kelola konten dan visibilitas.
- `/cv/id` dan `/cv/en` — ekspor CV ringkas sebagai PDF A4.
- `/portfolio/id/pdf` dan `/portfolio/en/pdf` — ekspor portofolio lengkap sebagai PDF A4.

Foto yang diunggah dibatasi ke JPG, PNG, atau WebP dengan ukuran maksimal 5 MB. CV dan portofolio PDF mengambil data yang sama dengan website, memilih bahasa dari URL, dan melewati bagian yang belum diisi.
