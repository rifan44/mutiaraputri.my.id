# PROJECT_CONTEXT.md

> Ringkasan handoff berdasarkan isi repository. Jangan menaruh credential, token, password, private key, atau data pribadi di file ini.

## 1. Identitas project

- **Nama:** Mutiara Putri Portfolio
- **Tujuan:** Website portofolio pribadi dwibahasa untuk kebutuhan kampus dan lamaran profesional, dengan panel admin serta ekspor CV dan portofolio PDF.
- **Status:** Source siap deploy dan sudah dipush. Domain sudah didelegasikan ke nameserver Cloudflare; record web, Nginx vhost, dan Cloudflare Tunnel untuk website ini belum dibuat.
- **Branch aktif:** `main`
- **Remote:** `origin` → `https://github.com/rifan44/mutiaraputri.my.id.git`
- **Terakhir diperbarui:** 2026-11-28

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
| Deployment | Persiapan terkonfirmasi via SSH: Ubuntu 26.04, Nginx, MariaDB, PHP-FPM 8.5 aktif; `cloudflared` terpasang tapi service belum aktif | Pemeriksaan SSH read-only; vhost/domain belum ada |

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
| Domain dan home server | In Progress | NS Cloudflare aktif dan SOA terjawab; apex/`www` belum memiliki record web. Belum ada vhost Nginx atau tunnel bernama proyek ini. |

## 5. Keputusan teknis

| Tanggal | Keputusan | Alasan | Dampak |
|---|---|---|---|
| 2026-11-23 | CodeIgniter 4 app starter dan MariaDB/MySQLi | Mengikuti stack yang diminta pengguna. | Migrasi dan koneksi database dikelola lewat CI4. |
| 2026-11-23 | CSS khusus tanpa Tailwind build | Tampilan ringan, tidak memerlukan Node build saat deploy. | Tema dan layout tersimpan langsung di `public/assets/css/`. |
| 2026-11-23 | Dompdf 3.1.6 | Ekspor PDF server-side A4 dengan tata letak cetak terkendali. | `composer audit` setelah pembaruan tidak melaporkan advisory. |
| 2026-11-23 | Login admin dibuat melalui CLI | Tidak menyediakan kredensial default atau halaman setup publik. | Jalankan `php spark portfolio:create-admin` setelah migration. |
| 2026-11-23 | Route auto-routing dimatikan dan halaman tidak di-cache | Menjaga akses admin melalui route/filter eksplisit dan menghindari cache sesi admin. | Endpoint yang tersedia tercantum eksplisit di `Routes.php`. |

## 6. Pekerjaan aktif

- **Task:** Menyiapkan deployment website melalui Nginx dan Cloudflare Tunnel pada home server.
- **Tujuan:** Menyediakan website portofolio yang bisa diedit, responsif, dwibahasa, dan menghasilkan dokumen PDF.
- **Acceptance criteria:** Website publik; panel admin terproteksi; isi awal sesuai fakta pengguna; file CV/portofolio A4; kode di repository GitHub.
- **File/area terkait:** `app/`, `public/assets/`, `app/Database/`, `composer.json`, `README.md`, `PROJECT_CONTEXT.md`.
- **Status terakhir:** Repository `main` bersih dan sinkron dengan GitHub. Server Ubuntu 26.04 terjangkau via SSH; Nginx/MariaDB/PHP-FPM aktif, `cloudflared` tersedia tetapi belum berjalan. Nameserver publik Cloudflare menjawab SOA; record A/AAAA/CNAME website belum ada. Kredensial akun tidak disimpan di repository.

## 7. Bug dan kendala

| Masalah | Cara reproduksi | Status | Catatan |
|---|---|---|---|
| MariaDB lokal sempat berhenti | Cek listener port 3307 dan nyalakan `mariadbd` dengan konfigurasi data proyek bila perlu | Pulih | MySQL Laragon di port 3306 tidak terdampak; data MariaDB lokal tetap utuh. |
| Website belum dipublikasikan | Akses apex atau `www` setelah deploy | Menunggu deployment | Buat production DB/`.env`, Nginx vhost ke `public/`, public hostname tunnel, dan CNAME; tidak perlu port-forward router. |

## 8. Pengujian

- **Test command tersedia:** `composer test` / PHPUnit dari app starter.
- **Lint command:** Belum ditambahkan.
- **Type-check:** Tidak digunakan.
- **Build command frontend:** Tidak digunakan.
- **Hasil terakhir:** `php -l` untuk file PHP yang berubah dan `node --check public/assets/js/photo-editor.js` lolos. Endpoint publik/admin/PDF mengembalikan HTTP 200; PDF A4 dirender untuk pemeriksaan visual.
- **Dependency audit:** `composer audit --no-interaction` setelah memperbarui Dompdf melaporkan tidak ada advisory.
- **Belum diuji:** Login admin, unggah/crop foto menggunakan foto pilihan, dan tampilan pada perangkat fisik. Suite PHPUnit tidak dijalankan.

## 9. Next tasks

1. [ ] Deploy source ke home server, buat database produksi baru, siapkan `.env` production dan Nginx vhost.
2. [ ] Buat/aktifkan Cloudflare Tunnel dan public hostname apex/`www`; verifikasi HTTPS.
3. [ ] Buat akun admin production, ganti kata sandi sementara, unggah foto pilihan, dan lengkapi konten.

## 10. Handoff terakhir

- **Ringkasan perubahan:** Tampilan portofolio dan editor foto selesai; source dipush. Pemeriksaan deployment menemukan nameserver sudah Cloudflare, tetapi record web, Nginx vhost, dan tunnel website belum ada.
- **File yang berubah:** Controller, migration, seeder, filter, helper, view, CSS/JS, konfigurasi, dependency, README, dan konteks proyek.
- **Hal yang perlu diperiksa berikutnya:** Siapkan Nginx/production DB, aktifkan Cloudflare Tunnel hostname, lalu login admin production dan verifikasi upload/PDF.
- **Perintah untuk melanjutkan:** Ikuti urutan deploy dari pembahasan; jalankan perintah `sudo` sendiri di SSH bila diminta password, jangan membagikan password atau tunnel token.
