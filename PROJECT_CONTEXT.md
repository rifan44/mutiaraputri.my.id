# PROJECT_CONTEXT.md

> Ringkasan handoff berdasarkan isi repository. Jangan menaruh credential, token, password, private key, atau data pribadi di file ini.

## 1. Identitas project

- **Nama:** Mutiara Putri Portfolio
- **Tujuan:** Website portofolio pribadi dwibahasa untuk kebutuhan kampus dan lamaran profesional, dengan panel admin serta ekspor CV dan portofolio PDF.
- **Status:** Aplikasi berjalan lokal melalui Laragon; MariaDB lokal, migration, dan seeder sudah aktif. Akun admin belum dibuat; domain dan home server belum dikonfigurasi.
- **Branch aktif:** `main`
- **Remote:** `origin` → `https://github.com/rifan44/mutiaraputri.my.id.git`
- **Terakhir diperbarui:** 2026-11-24

## 2. Tech stack aktual

| Area | Teknologi dan versi | Bukti |
|---|---|---|
| Frontend | PHP server-rendered views, CSS, JavaScript tanpa bundler | `app/Views/`, `public/assets/` |
| Backend | CodeIgniter 4.7.6; PHP `^8.2` | `composer.lock`, `composer.json` |
| Database | MariaDB 11.8.6 lokal pada `127.0.0.1:3307`; driver MySQLi | `app/Config/Database.php`, migration, konfigurasi lokal `.env` (diabaikan Git) |
| Query builder | CodeIgniter Database Forge dan Query Builder | Migration, seeder, controller |
| Authentication | Login berbasis session, `password_hash`, filter admin | `app/Controllers/Admin/Auth.php`, `app/Filters/AdminAuth.php` |
| Styling | CSS khusus cream dan emerald, responsif; tanpa Tailwind/build step | `public/assets/css/portfolio.css`, `public/assets/css/admin.css` |
| PDF | Dompdf 3.1.6 | `composer.json`, `composer.lock`, `app/Controllers/Export.php` |
| Runtime lokal yang terlihat | PHP 8.4.27, Node.js 24.13.0; tidak ada proses build frontend | CLI saat pemeriksaan awal |
| Testing | PHPUnit 10.5 tersedia dari app starter; belum dijalankan | `composer.json`, `composer.lock`, `phpunit.dist.xml` |
| Deployment | Belum dikonfigurasi; domain sudah dimiliki pengguna, home server belum disambungkan | `.env.example`, `README.md` |

## 3. Arsitektur dan struktur

```text
app/
  Commands/              pembuatan akun admin melalui CLI
  Config/                routes, database, filters, dan konfigurasi aplikasi
  Controllers/           website publik, ekspor, dan panel admin
  Database/Migrations/   skema admin, profil, pendidikan, pengalaman, proyek, keahlian, sertifikat
  Database/Seeds/        profil dan data studi awal
  Filters/               autentikasi admin
  Helpers/               teks terjemahan dan format periode
  Libraries/             pembacaan data portofolio
  Views/                 halaman publik, admin, dan dokumen PDF
public/assets/           stylesheet, JavaScript, favicon
public/uploads/          media unggahan; file media diabaikan Git
writable/                session, cache, log, dan file runtime CI
```

- **Entry point web:** `public/index.php`
- **Entry point CLI:** `spark`
- **Routing:** `app/Config/Routes.php`; auto routing dimatikan.
- **Data:** migration `2026-11-23-000001_CreatePortfolioTables.php`, seeder `PortfolioSeeder`.
- **Akun admin:** command `portfolio:create-admin`; akun tidak dibuat dengan password default.
- **PDF:** route CV ringkas dan portofolio penuh, A4; bahasa mengikuti route `id` atau `en`.
- **Konfigurasi deployment:** salin `.env.example` menjadi `.env`; `.env` tidak dilacak Git.

## 4. Fitur dan status

| Fitur | Status | Implementasi / catatan |
|---|---|---|
| Website publik Indonesia dan Inggris | Done | `/` dan `/en`; seluruh teks utama tersedia dalam dua bahasa. |
| Tampilan responsif | Done | CSS breakpoint ponsel, tablet, desktop; menu mobile. |
| Profil dan foto | Done | Form admin untuk ringkasan, headline, lokasi, kontak, foto, dan tautan; editor foto mendukung crop 4:5/1:1, drag posisi, zoom, dan penyesuaian otomatis. |
| Konten editable | Done | Pendidikan, pengalaman, proyek, keahlian, sertifikat; urutan dan visibilitas dapat diatur. |
| Panel `/admin` | Done | Login, dashboard, logout, ubah kata sandi, proteksi CSRF. |
| Unggah media | Done | JPG, PNG, WebP, maksimal 5 MB, nama acak; hasil crop disimpan dan dipakai di website serta PDF. |
| Ekspor PDF | Done | `/cv/{id|en}` dan `/portfolio/{id|en}/pdf`, menggunakan Dompdf; CV dan portofolio Indonesia/Inggris sudah dirender dan ditinjau sebagai PDF A4 satu halaman. |
| Data awal Mutiara Putri | Done | Nama, universitas, dan program studi ditampilkan sewajarnya di pendidikan; semester 5 hanya ada di deskripsi profil singkat. Kontak/proyek/pengalaman tidak dikarang. |
| MariaDB | Done (lokal) | MariaDB lokal terisolasi di port 3307; migration dan seeder selesai. Database produksi belum disiapkan. |
| Domain dan home server | Not started | DNS, HTTPS, reverse proxy/tunnel, dan document root `public/` belum dikonfigurasi. |

## 5. Keputusan teknis

| Tanggal | Keputusan | Alasan | Dampak |
|---|---|---|---|
| 2026-11-23 | CodeIgniter 4 app starter dan MariaDB/MySQLi | Mengikuti stack yang diminta pengguna. | Migrasi dan koneksi database dikelola lewat CI4. |
| 2026-11-23 | CSS khusus tanpa Tailwind build | Tampilan ringan, tidak memerlukan Node build saat deploy. | Tema dan layout tersimpan langsung di `public/assets/css/`. |
| 2026-11-23 | Dompdf 3.1.6 | Ekspor PDF server-side A4 dengan tata letak cetak terkendali. | `composer audit` setelah pembaruan tidak melaporkan advisory. |
| 2026-11-23 | Login admin dibuat melalui CLI | Tidak menyediakan kredensial default atau halaman setup publik. | Jalankan `php spark portfolio:create-admin` setelah migration. |
| 2026-11-23 | Route auto-routing dimatikan dan halaman tidak di-cache | Menjaga akses admin melalui route/filter eksplisit dan menghindari cache sesi admin. | Endpoint yang tersedia tercantum eksplisit di `Routes.php`. |

## 6. Pekerjaan aktif

- **Task:** Menyempurnakan UI, editor foto, dan menjalankan aplikasi lokal melalui Laragon; sinkronkan source ke GitHub.
- **Tujuan:** Menyediakan website portofolio yang bisa diedit, responsif, dwibahasa, dan menghasilkan dokumen PDF.
- **Acceptance criteria:** Website publik; panel admin terproteksi; isi awal sesuai fakta pengguna; file CV/portofolio A4; kode di repository GitHub.
- **File/area terkait:** `app/`, `public/assets/`, `app/Database/`, `composer.json`, `README.md`, `PROJECT_CONTEXT.md`.
- **Status terakhir:** Website aktif di `http://localhost/mutiaraputri/`; halaman publik, login admin, dan empat endpoint PDF merespons HTTP 200. Belum ada akun admin.

## 7. Bug dan kendala

| Masalah | Cara reproduksi | Status | Catatan |
|---|---|---|---|
| Akun admin lokal belum dibuat | Jalankan `php spark portfolio:create-admin` dari folder proyek | Menunggu tindakan pengguna | Buat akun dengan identitas dan kata sandi pilihan sendiri; jangan menyimpan kredensial di repo. |
| Domain belum diarahkan ke home server | Akses domain setelah DNS/HTTPS dikonfigurasi | Menunggu konfigurasi jaringan | Perlu memastikan akses publik dan status CGNAT. |

## 8. Pengujian

- **Test command tersedia:** `composer test` / PHPUnit dari app starter.
- **Lint command:** Belum ditambahkan.
- **Type-check:** Tidak digunakan.
- **Build command frontend:** Tidak digunakan.
- **Hasil terakhir:** `php -l` untuk file PHP yang berubah dan `node --check public/assets/js/photo-editor.js` lolos. Endpoint publik/admin/PDF mengembalikan HTTP 200; PDF A4 dirender untuk pemeriksaan visual.
- **Dependency audit:** `composer audit --no-interaction` setelah memperbarui Dompdf melaporkan tidak ada advisory.
- **Belum diuji:** Login admin, unggah/crop foto menggunakan foto pilihan, dan tampilan pada perangkat fisik. Suite PHPUnit tidak dijalankan.

## 9. Next tasks

1. [ ] Jalankan `php spark portfolio:create-admin` di Laragon, lalu isi foto/kontak/proyek dari `/admin`.
2. [ ] Tinjau hasil crop dengan foto pilihan dan lengkapi konten sebelum memakai PDF untuk pengajuan.
3. [ ] Arahkan document root ke `public/`, pasang HTTPS, dan konfigurasi DNS/server sesuai jaringan home server.

## 10. Handoff terakhir

- **Ringkasan perubahan:** Tampilan portofolio dibuat lebih umum, semester dihapus dari headline/pendidikan, editor foto crop ditambahkan, MariaDB lokal dan Laragon aktif, serta PDF A4 empat endpoint ditinjau secara visual. Perubahan source saat ini menunggu commit/push.
- **File yang berubah:** Controller, migration, seeder, filter, helper, view, CSS/JS, konfigurasi, dependency, README, dan konteks proyek.
- **Hal yang perlu diperiksa berikutnya:** Buat akun admin lokal, unggah foto pilihan dan coba crop, lengkapi konten, lalu siapkan domain/home server setelah pengguna siap.
- **Perintah untuk melanjutkan:** `php spark portfolio:create-admin` dari folder repository. Aplikasi aktif melalui Laragon di `http://localhost/mutiaraputri/`.
