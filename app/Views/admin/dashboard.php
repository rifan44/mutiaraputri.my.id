<?= $this->extend('admin/layout') ?>
<?= $this->section('content') ?>
<div class="welcome-banner"><div><span class="admin-kicker">DASHBOARD</span><h1>Halo, <?= esc($userName) ?>.</h1><p>Atur isi portofolio dan CV-mu dari satu tempat.</p></div><a class="admin-button admin-button-light" href="<?= site_url('/') ?>" target="_blank" rel="noopener noreferrer">Lihat website <span aria-hidden="true">↗</span></a><span class="welcome-flower" aria-hidden="true">✳</span></div>
<div class="section-title-row"><div><span class="admin-kicker">KONTEN</span><h2>Ringkasan portofolio</h2></div><a class="admin-text-link" href="<?= site_url('admin/profile') ?>">Perbarui profil utama <span aria-hidden="true">→</span></a></div>
<div class="stats-grid">
    <?php $stats = [
        'projects' => ['label' => 'Proyek', 'description' => 'Karya pilihan'],
        'education' => ['label' => 'Pendidikan', 'description' => 'Riwayat pendidikan'],
        'experiences' => ['label' => 'Pengalaman', 'description' => 'Organisasi & pekerjaan'],
        'skills' => ['label' => 'Keahlian', 'description' => 'Kemampuan utama'],
        'certificates' => ['label' => 'Sertifikat', 'description' => 'Sertifikat & prestasi'],
    ]; ?>
    <?php foreach ($stats as $key => $stat): ?><a class="stat-card" href="<?= site_url('admin/' . $key) ?>"><span class="stat-count"><?= (int) ($counts[$key] ?? 0) ?></span><strong><?= esc($stat['label']) ?></strong><span><?= esc($stat['description']) ?></span><span class="stat-arrow" aria-hidden="true">↗</span></a><?php endforeach; ?>
</div>
<div class="dashboard-bottom-grid">
    <section class="admin-panel checklist-panel"><div class="panel-heading"><div><span class="admin-kicker">LANGKAH SELANJUTNYA</span><h2>Lengkapi portofolio</h2></div><span class="panel-flower" aria-hidden="true">✳</span></div><div class="checklist-item done"><span>✓</span><div><strong>Informasi studi</strong><small>Universitas dan program studi sudah ditambahkan.</small></div></div><div class="checklist-item"><span>02</span><div><strong>Tambahkan foto & kontak</strong><small>Isi foto profil dan email publik bila siap dibagikan.</small></div><a href="<?= site_url('admin/profile') ?>">Atur ↗</a></div><div class="checklist-item"><span>03</span><div><strong>Unggah proyek pilihan</strong><small>Masukkan tugas, riset, kegiatan lapangan, atau karya yang relevan.</small></div><a href="<?= site_url('admin/projects/new') ?>">Tambah ↗</a></div></section>
    <section class="admin-panel export-panel"><span class="admin-kicker">DOKUMEN SIAP KIRIM</span><h2>CV & portofolio</h2><p>Ekspor PDF A4 dalam bahasa Indonesia atau Inggris. Data yang belum diisi otomatis dilewati.</p><div class="export-links"><a href="<?= site_url('cv/id') ?>">CV · ID <span>↓</span></a><a href="<?= site_url('cv/en') ?>">CV · EN <span>↓</span></a><a href="<?= site_url('portfolio/id/pdf') ?>">Portofolio · ID <span>↓</span></a><a href="<?= site_url('portfolio/en/pdf') ?>">Portofolio · EN <span>↓</span></a></div></section>
</div>
<?= $this->endSection() ?>
