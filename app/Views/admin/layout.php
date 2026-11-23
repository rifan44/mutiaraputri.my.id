<?php
$current = service('uri')->getSegment(2) ?? '';
$userName = session()->get('admin_user_name') ?? 'Admin';
$nav = [
    ['path' => 'admin', 'label' => 'Ringkasan', 'icon' => '⌂'],
    ['path' => 'admin/profile', 'label' => 'Profil utama', 'icon' => '◉'],
    ['path' => 'admin/education', 'label' => 'Pendidikan', 'icon' => '▤'],
    ['path' => 'admin/experiences', 'label' => 'Pengalaman', 'icon' => '↗'],
    ['path' => 'admin/projects', 'label' => 'Proyek', 'icon' => '✳'],
    ['path' => 'admin/skills', 'label' => 'Keahlian', 'icon' => '◇'],
    ['path' => 'admin/certificates', 'label' => 'Sertifikat & prestasi', 'icon' => '✧'],
];
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="robots" content="noindex, nofollow">
    <link rel="icon" type="image/svg+xml" href="<?= base_url('assets/favicon.svg') ?>">
    <title><?= esc($title ?? 'Panel Admin') ?> · Mutiara Putri</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700&family=Playfair+Display:wght@500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="<?= base_url('assets/css/admin.css') ?>">
</head>
<body class="admin-body">
<div class="admin-shell">
    <aside class="admin-sidebar">
        <a class="admin-brand" href="<?= site_url('admin') ?>"><span class="admin-brand-mark">MP</span><span><strong>Mutiara Putri</strong><small>PORTFOLIO ADMIN</small></span></a>
        <div class="sidebar-label">MENU UTAMA</div>
        <nav class="admin-nav" aria-label="Navigasi admin">
            <?php foreach ($nav as $item): ?>
                <?php $segment = trim(str_replace('admin/', '', $item['path']), '/'); ?>
                <a class="<?= ($current === $segment || ($current === '' && $item['path'] === 'admin')) ? 'active' : '' ?>" href="<?= site_url($item['path']) ?>"><span class="nav-icon" aria-hidden="true"><?= esc($item['icon']) ?></span><?= esc($item['label']) ?></a>
            <?php endforeach; ?>
        </nav>
        <div class="sidebar-bottom">
            <a href="<?= site_url('/') ?>" target="_blank" rel="noopener noreferrer" class="view-site"><span aria-hidden="true">↗</span> Lihat website</a>
            <div class="admin-user"><span class="user-avatar"><?= esc(mb_strtoupper(mb_substr($userName, 0, 1))) ?></span><span><strong><?= esc($userName) ?></strong><small><?= esc(session()->get('admin_user_email') ?? 'Admin') ?></small></span></div>
            <a href="<?= site_url('admin/password') ?>" class="password-link <?= $current === 'password' ? 'active' : '' ?>">Ubah kata sandi</a>
            <form action="<?= site_url('admin/logout') ?>" method="post"><?= csrf_field() ?><button class="logout-button" type="submit">Keluar dari admin <span aria-hidden="true">↗</span></button></form>
        </div>
    </aside>
    <main class="admin-main">
        <header class="admin-topbar"><div><span class="admin-kicker">RUANG KERJA</span><strong><?= esc($title ?? 'Dashboard') ?></strong></div><span class="topbar-date"><?= esc(date('d M Y')) ?></span></header>
        <div class="admin-content"><?= $this->renderSection('content') ?></div>
        <footer class="admin-footer">Portfolio Content Studio <span>·</span> Mutiara Putri</footer>
    </main>
</div>
</body>
</html>
