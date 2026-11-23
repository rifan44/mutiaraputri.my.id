<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1"><meta name="robots" content="noindex, nofollow">
    <title><?= esc($title) ?> · Mutiara Putri</title>
    <link rel="preconnect" href="https://fonts.googleapis.com"><link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="icon" type="image/svg+xml" href="<?= base_url('assets/favicon.svg') ?>">
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700&family=Playfair+Display:wght@500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="<?= base_url('assets/css/admin.css') ?>">
</head>
<body class="login-body">
<main class="login-card">
    <a class="login-back" href="<?= site_url('/') ?>">← Kembali ke website</a>
    <a class="admin-brand login-brand" href="<?= site_url('/') ?>"><span class="admin-brand-mark">MP</span><span><strong>Mutiara Putri</strong><small>PORTFOLIO ADMIN</small></span></a>
    <div class="login-intro"><span class="admin-kicker">SELAMAT DATANG KEMBALI</span><h1>Masuk ke<br><em>ruang admin.</em></h1><p>Perbarui cerita, karya, dan perjalanan profesionalmu.</p></div>
    <?php if (! empty($error)): ?><div class="notice notice-error"><?= esc($error) ?></div><?php endif; ?>
    <form class="admin-form login-form" action="<?= site_url('admin/login') ?>" method="post">
        <?= csrf_field() ?>
        <label for="email">Email</label><input id="email" name="email" type="email" value="<?= esc(old('email')) ?>" autocomplete="username" required autofocus>
        <label for="password">Kata sandi</label><input id="password" name="password" type="password" autocomplete="current-password" required>
        <button class="admin-button admin-button-primary" type="submit">Masuk ke dashboard <span aria-hidden="true">↗</span></button>
    </form>
    <p class="login-footnote">Akun admin dibuat melalui perintah CLI setelah database disiapkan.</p>
</main>
</body>
</html>
