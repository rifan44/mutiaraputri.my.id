<?php
$copy = [
    'availability' => ['id' => 'PORTOFOLIO PRIBADI', 'en' => 'PERSONAL PORTFOLIO'],
    'home' => ['id' => 'Beranda', 'en' => 'Home'],
    'about' => ['id' => 'Tentang', 'en' => 'About'],
    'education' => ['id' => 'Pendidikan', 'en' => 'Education'],
    'experience' => ['id' => 'Pengalaman', 'en' => 'Experience'],
    'projects' => ['id' => 'Proyek', 'en' => 'Projects'],
    'skills' => ['id' => 'Keahlian', 'en' => 'Skills'],
    'certificates' => ['id' => 'Sertifikat', 'en' => 'Certificates'],
    'contact' => ['id' => 'Kontak', 'en' => 'Contact'],
    'eyebrow' => ['id' => 'PROFIL & KARYA PILIHAN', 'en' => 'PROFILE & SELECTED WORK'],
    'intro' => ['id' => 'Mengenal lebih dekat,', 'en' => 'A little about'],
    'view_work' => ['id' => 'Lihat portofolio', 'en' => 'Explore portfolio'],
    'download_cv' => ['id' => 'Unduh CV', 'en' => 'Download CV'],
    'about_title' => ['id' => 'Perjalanan dan minat saya', 'en' => 'My background and interests'],
    'about_empty' => ['id' => 'Portofolio pribadi yang memuat profil, karya, dan perjalanan saya.', 'en' => 'A personal portfolio featuring my profile, selected work, and experience.'],
    'education_title' => ['id' => 'Pendidikan', 'en' => 'Education'],
    'experience_title' => ['id' => 'Pengalaman', 'en' => 'Experience'],
    'project_title' => ['id' => 'Proyek pilihan', 'en' => 'Selected projects'],
    'project_intro' => ['id' => 'Kumpulan karya dan proses belajar yang terus berkembang.', 'en' => 'A growing collection of projects and learning experiences.'],
    'project_empty' => ['id' => 'Proyek pilihan akan ditampilkan di sini.', 'en' => 'Selected projects will appear here.'],
    'skills_title' => ['id' => 'Keahlian', 'en' => 'Skills'],
    'certificates_title' => ['id' => 'Sertifikat & prestasi', 'en' => 'Certificates & recognition'],
    'contact_title' => ['id' => 'Mari terhubung', 'en' => 'Let’s connect'],
    'contact_intro' => ['id' => 'Untuk kebutuhan kampus, kolaborasi, atau kesempatan profesional, silakan hubungi saya.', 'en' => 'For academic opportunities, collaboration, or professional inquiries, feel free to reach out.'],
    'email_me' => ['id' => 'Kirim email', 'en' => 'Send an email'],
    'portfolio_pdf' => ['id' => 'Unduh portofolio lengkap', 'en' => 'Download full portfolio'],
    'footer' => ['id' => 'Dibuat dengan penuh perhatian.', 'en' => 'Made with care.'],
];
$t = static fn (string $key): string => portfolio_t($locale, $copy[$key]);
$nameParts = preg_split('/\s+/', trim($profile['full_name'] ?? 'Mutiara Putri')) ?: ['Mutiara', 'Putri'];
$firstName = array_shift($nameParts) ?: 'Mutiara';
$lastName = implode(' ', $nameParts);
$hasContact = ! empty($profile['email']) || ! empty($profile['linkedin_url']) || ! empty($profile['instagram_url']) || ! empty($profile['website']);
$heroMeta = ! empty($profile['location']) ? $profile['location'] : portfolio_t($locale, ['id' => 'Profil pribadi · Karya pilihan', 'en' => 'Personal profile · Selected work']);
?>
<!DOCTYPE html>
<html lang="<?= esc($locale) ?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="<?= esc(($profile['full_name'] ?? 'Mutiara Putri') . ' — ' . portfolio_localized($profile, 'headline', $locale, $locale === 'en' ? 'Personal Portfolio' : 'Portofolio Pribadi')) ?>">
    <meta name="theme-color" content="#f5f2e9">
    <link rel="icon" type="image/svg+xml" href="<?= base_url('assets/favicon.svg') ?>">
    <title><?= esc($profile['full_name'] ?? 'Mutiara Putri') ?> — <?= esc(portfolio_localized($profile, 'headline', $locale, $locale === 'en' ? 'Personal Portfolio' : 'Portofolio Pribadi')) ?></title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700&family=Playfair+Display:ital,wght@0,500;0,600;0,700;1,500;1,600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="<?= base_url('assets/css/portfolio.css') ?>">
</head>
<body>
<a class="skip-link" href="#main-content"><?= $locale === 'en' ? 'Skip to content' : 'Lewati ke konten' ?></a>
<header class="site-header">
    <div class="container nav-wrap">
        <a class="brand" href="<?= site_url($locale === 'id' ? '' : 'en') ?>" aria-label="<?= esc($profile['full_name'] ?? 'Mutiara Putri') ?>, <?= esc($t('home')) ?>">
            <span class="brand-mark">MP</span>
            <span class="brand-name"><?= esc($profile['full_name'] ?? 'Mutiara Putri') ?><small><?= esc($t('availability')) ?></small></span>
        </a>
        <button class="menu-toggle" type="button" aria-expanded="false" aria-controls="primary-nav"><span></span><span></span><span></span><span class="sr-only">Menu</span></button>
        <nav class="primary-nav" id="primary-nav" aria-label="<?= $locale === 'en' ? 'Main navigation' : 'Navigasi utama' ?>">
            <a href="#about"><?= esc($t('about')) ?></a>
            <a href="#education"><?= esc($t('education')) ?></a>
            <?php if ($experiences !== []): ?><a href="#experience"><?= esc($t('experience')) ?></a><?php endif; ?>
            <a href="#projects"><?= esc($t('projects')) ?></a>
            <?php if ($skills !== []): ?><a href="#skills"><?= esc($t('skills')) ?></a><?php endif; ?>
            <a href="#contact"><?= esc($t('contact')) ?></a>
            <span class="nav-divider"></span>
            <div class="language-switch" aria-label="Language">
                <a class="<?= $locale === 'id' ? 'active' : '' ?>" href="<?= site_url('/') ?>">ID</a>
                <span>/</span>
                <a class="<?= $locale === 'en' ? 'active' : '' ?>" href="<?= site_url('en') ?>">EN</a>
            </div>
        </nav>
    </div>
</header>

<main id="main-content">
    <section class="hero container" id="home">
        <div class="hero-copy">
            <div class="eyebrow"><span class="eyebrow-dot"></span><?= esc($t('eyebrow')) ?></div>
            <p class="hero-intro"><?= esc($t('intro')) ?></p>
            <h1><?= esc($firstName) ?><?php if ($lastName !== ''): ?><br><em><?= esc($lastName) ?></em><?php endif; ?></h1>
            <p class="hero-role"><?= esc(portfolio_localized($profile, 'headline', $locale, $locale === 'en' ? 'Personal Portfolio' : 'Portofolio Pribadi')) ?></p>
            <p class="hero-description"><?= nl2br(esc(portfolio_localized($profile, 'summary', $locale, $t('about_empty')))) ?></p>
            <div class="hero-actions">
                <a class="button button-primary" href="#projects"><?= esc($t('view_work')) ?><span aria-hidden="true">↗</span></a>
                <a class="button button-outline" href="<?= site_url('cv/' . $locale) ?>"><?= esc($t('download_cv')) ?><span aria-hidden="true">↓</span></a>
            </div>
            <div class="hero-note"><span class="note-line"></span><span><?= esc($heroMeta) ?></span></div>
        </div>
        <div class="hero-visual" aria-label="<?= esc($profile['full_name'] ?? 'Mutiara Putri') ?>">
            <div class="visual-backdrop"></div>
            <div class="visual-stamp"><span>PORTFOLIO</span><span><?= date('Y') ?></span></div>
            <?php if (! empty($profile['avatar_path'])): ?>
                <img class="portrait" src="<?= base_url(esc($profile['avatar_path'])) ?>" alt="Foto profil <?= esc($profile['full_name'] ?? 'Mutiara Putri') ?>">
            <?php else: ?>
                <div class="portrait-placeholder" aria-hidden="true"><span>MP</span><svg viewBox="0 0 360 390" role="presentation"><path d="M55 360c22-97 63-144 125-144s104 47 125 144"/><path d="M100 173c-5-69 24-113 80-113s85 44 80 113c-4 54-33 91-80 91s-76-37-80-91Z"/><path d="M115 130c32-10 56-34 67-63 19 34 43 51 76 57"/><path d="M75 318c-21-17-30-43-26-74M282 314c24-18 34-47 29-76"/></svg></div>
            <?php endif; ?>
            <div class="visual-card"><span class="card-kicker"><?= $locale === 'en' ? 'PERSONAL' : 'PORTOFOLIO' ?></span><strong>01</strong><span><?= $locale === 'en' ? 'Selected profile' : 'Profil pilihan' ?></span></div>
            <div class="visual-caption"><span class="caption-rule"></span><?= $locale === 'en' ? 'PERSONAL PROFILE<br>AND SELECTED WORK' : 'PROFIL PRIBADI<br>DAN KARYA PILIHAN' ?></div>
            <span class="visual-sparkle sparkle-one">✳</span><span class="visual-sparkle sparkle-two">✳</span>
        </div>
        <a class="scroll-cue" href="#about"><span></span><?= $locale === 'en' ? 'Scroll to explore' : 'Gulir untuk menjelajah' ?></a>
    </section>

    <section class="about-section section-pad" id="about">
        <div class="container about-grid">
            <div class="section-label"><span>01</span><span class="label-rule"></span><span><?= esc($t('about')) ?></span></div>
            <div class="about-content">
                <h2><?= esc($t('about_title')) ?></h2>
                <p class="about-text"><?= nl2br(esc(portfolio_localized($profile, 'summary', $locale, $t('about_empty')))) ?></p>
                <?php if (! empty($profile['location'])): ?><p class="location-line"><span aria-hidden="true">⌖</span> <?= esc($profile['location']) ?></p><?php endif; ?>
            </div>
        </div>
    </section>

    <section class="education-section section-pad" id="education">
        <div class="container">
            <div class="section-heading"><div class="section-label"><span>02</span><span class="label-rule"></span><span><?= esc($t('education')) ?></span></div><h2><?= esc($t('education_title')) ?></h2></div>
            <?php if ($education !== []): ?>
                <div class="education-list">
                    <?php foreach ($education as $item): ?>
                        <article class="education-item">
                            <span class="education-marker"></span>
                            <div class="education-period"><?= esc(portfolio_period($item['start_date'] ?? null, $item['end_date'] ?? null, (bool) ($item['is_current'] ?? false), $locale) ?: ($item['is_current'] ? ($locale === 'en' ? 'Current' : 'Saat ini') : '')) ?></div>
                            <div class="education-main"><h3><?= esc($item['institution']) ?></h3><p><?= esc(portfolio_localized($item, 'program', $locale)) ?></p><?php if (! empty($item['location'])): ?><span><?= esc($item['location']) ?></span><?php endif; ?><?php if (! empty(portfolio_localized($item, 'description', $locale))): ?><div class="rich-copy"><?= nl2br(esc(portfolio_localized($item, 'description', $locale))) ?></div><?php endif; ?></div>
                            <span class="education-arrow" aria-hidden="true">↗</span>
                        </article>
                    <?php endforeach; ?>
                </div>
            <?php else: ?>
                <div class="empty-line"><span>✳</span><p><?= esc($locale === 'en' ? 'Education details will be shared here.' : 'Detail pendidikan akan ditampilkan di sini.') ?></p></div>
            <?php endif; ?>
        </div>
    </section>

    <?php if ($experiences !== []): ?>
    <section class="experience-section section-pad" id="experience">
        <div class="container">
            <div class="section-heading"><div class="section-label"><span>03</span><span class="label-rule"></span><span><?= esc($t('experience')) ?></span></div><h2><?= esc($t('experience_title')) ?></h2></div>
            <div class="experience-grid">
                <?php foreach ($experiences as $item): ?>
                    <article class="experience-card"><div class="experience-date"><?= esc(portfolio_period($item['start_date'] ?? null, $item['end_date'] ?? null, (bool) ($item['is_current'] ?? false), $locale)) ?></div><h3><?= esc(portfolio_localized($item, 'role', $locale)) ?></h3><p class="experience-org"><?= esc($item['organization']) ?></p><?php if (! empty($item['location'])): ?><span class="muted-small"><?= esc($item['location']) ?></span><?php endif; ?><?php if (! empty(portfolio_localized($item, 'description', $locale))): ?><p class="rich-copy"><?= nl2br(esc(portfolio_localized($item, 'description', $locale))) ?></p><?php endif; ?></article>
                <?php endforeach; ?>
            </div>
        </div>
    </section>
    <?php endif; ?>

    <section class="projects-section section-pad" id="projects">
        <div class="container">
            <div class="projects-heading"><div><div class="section-label"><span>04</span><span class="label-rule"></span><span><?= esc($t('projects')) ?></span></div><h2><?= esc($t('project_title')) ?></h2><p><?= esc($t('project_intro')) ?></p></div><a class="text-link" href="<?= site_url('portfolio/' . $locale . '/pdf') ?>"><?= esc($t('portfolio_pdf')) ?><span aria-hidden="true">↗</span></a></div>
            <?php if ($projects !== []): ?>
                <div class="project-grid">
                    <?php foreach ($projects as $index => $project): ?>
                        <article class="project-card">
                            <div class="project-image">
                                <?php if (! empty($project['image_path'])): ?><img src="<?= base_url(esc($project['image_path'])) ?>" alt="<?= esc(portfolio_localized($project, 'title', $locale)) ?>" loading="lazy"><?php else: ?><div class="project-placeholder project-placeholder-<?= $index % 3 + 1 ?>"><span><?= str_pad((string) ($index + 1), 2, '0', STR_PAD_LEFT) ?></span><i aria-hidden="true">✳</i></div><?php endif; ?>
                                <?php if (! empty($project['category_id']) || ! empty($project['category_en'])): ?><span class="project-category"><?= esc(portfolio_localized($project, 'category', $locale)) ?></span><?php endif; ?>
                            </div>
                            <div class="project-meta"><span><?= esc(portfolio_localized($project, 'role', $locale, $locale === 'en' ? 'Project' : 'Proyek')) ?></span><span><?= esc(portfolio_period($project['start_date'] ?? null, $project['end_date'] ?? null, false, $locale)) ?></span></div>
                            <h3><?= esc(portfolio_localized($project, 'title', $locale)) ?></h3>
                            <?php if (! empty(portfolio_localized($project, 'description', $locale))): ?><p><?= nl2br(esc(portfolio_localized($project, 'description', $locale))) ?></p><?php endif; ?>
                            <?php if (! empty($project['tools'])): ?><div class="tag-row"><?php foreach (array_filter(array_map('trim', explode(',', $project['tools']))) as $tool): ?><span><?= esc($tool) ?></span><?php endforeach; ?></div><?php endif; ?>
                            <?php if (! empty($project['project_url'])): ?><a class="project-link" href="<?= esc($project['project_url']) ?>" target="_blank" rel="noopener noreferrer"><?= $locale === 'en' ? 'View project' : 'Lihat proyek' ?><span aria-hidden="true">↗</span></a><?php endif; ?>
                        </article>
                    <?php endforeach; ?>
                </div>
            <?php else: ?>
                <div class="project-empty"><span class="empty-flower">✳</span><p><?= esc($t('project_empty')) ?></p><span class="empty-note"><?= $locale === 'en' ? 'New work will be added as it grows.' : 'Karya baru akan ditambahkan seiring berkembang.' ?></span></div>
            <?php endif; ?>
        </div>
    </section>

    <?php if ($skills !== []): ?>
    <section class="skills-section section-pad" id="skills">
        <div class="container skills-grid"><div><div class="section-label"><span>05</span><span class="label-rule"></span><span><?= esc($t('skills')) ?></span></div><h2><?= esc($t('skills_title')) ?></h2></div><div class="skills-list"><?php foreach ($skills as $skill): ?><div class="skill-row"><div><strong><?= esc(portfolio_localized($skill, 'name', $locale)) ?></strong><?php if (! empty(portfolio_localized($skill, 'category', $locale))): ?><span><?= esc(portfolio_localized($skill, 'category', $locale)) ?></span><?php endif; ?></div><?php if (! empty(portfolio_localized($skill, 'level', $locale))): ?><small><?= esc(portfolio_localized($skill, 'level', $locale)) ?></small><?php endif; ?></div><?php endforeach; ?></div></div>
    </section>
    <?php endif; ?>

    <?php if ($certificates !== []): ?>
    <section class="certificates-section section-pad" id="certificates">
        <div class="container"><div class="section-heading"><div class="section-label"><span>06</span><span class="label-rule"></span><span><?= esc($t('certificates')) ?></span></div><h2><?= esc($t('certificates_title')) ?></h2></div><div class="certificate-grid"><?php foreach ($certificates as $certificate): ?><article class="certificate-item"><span class="certificate-icon" aria-hidden="true">✳</span><div><h3><?= esc(portfolio_localized($certificate, 'name', $locale)) ?></h3><?php if (! empty($certificate['issuer'])): ?><p><?= esc($certificate['issuer']) ?></p><?php endif; ?><span class="muted-small"><?= esc(portfolio_period($certificate['issue_date'] ?? null, null, false, $locale)) ?></span></div><?php if (! empty($certificate['credential_url'])): ?><a href="<?= esc($certificate['credential_url']) ?>" target="_blank" rel="noopener noreferrer" aria-label="<?= $locale === 'en' ? 'Verify certificate' : 'Verifikasi sertifikat' ?>">↗</a><?php endif; ?></article><?php endforeach; ?></div></div>
    </section>
    <?php endif; ?>

    <section class="contact-section section-pad" id="contact">
        <div class="container contact-panel"><div class="section-label"><span>07</span><span class="label-rule"></span><span><?= esc($t('contact')) ?></span></div><div class="contact-content"><div><p class="eyebrow"><?= esc($locale === 'en' ? 'OPEN TO MEANINGFUL CONNECTIONS' : 'TERBUKA UNTUK TERHUBUNG') ?></p><h2><?= esc($t('contact_title')) ?></h2><p><?= esc($t('contact_intro')) ?></p></div><div class="contact-actions">
            <?php if (! empty($profile['email'])): ?><a class="button button-light" href="mailto:<?= esc($profile['email']) ?>"><?= esc($t('email_me')) ?><span aria-hidden="true">↗</span></a><?php endif; ?>
            <?php if (! empty($profile['linkedin_url'])): ?><a href="<?= esc($profile['linkedin_url']) ?>" target="_blank" rel="noopener noreferrer">LinkedIn ↗</a><?php endif; ?>
            <?php if (! empty($profile['instagram_url'])): ?><a href="<?= esc($profile['instagram_url']) ?>" target="_blank" rel="noopener noreferrer">Instagram ↗</a><?php endif; ?>
            <?php if (! empty($profile['website'])): ?><a href="<?= esc($profile['website']) ?>" target="_blank" rel="noopener noreferrer">Website ↗</a><?php endif; ?>
            <?php if (! $hasContact): ?><p class="contact-hint"><?= $locale === 'en' ? 'Add a public email or social link from the admin panel.' : 'Tambahkan email atau tautan sosial publik melalui panel admin.' ?></p><?php endif; ?>
        </div></div><span class="contact-decoration" aria-hidden="true">✳</span></div>
    </section>
</main>

<footer class="site-footer"><div class="container footer-content"><a href="#home" class="footer-brand"><?= esc($profile['full_name'] ?? 'Mutiara Putri') ?><span>✳</span></a><p>© <?= date('Y') ?> <?= esc($profile['full_name'] ?? 'Mutiara Putri') ?> · <?= esc($t('footer')) ?></p><a href="<?= site_url('admin/login') ?>" class="admin-link"><?= $locale === 'en' ? 'Admin' : 'Admin' ?></a></div></footer>
<script src="<?= base_url('assets/js/portfolio.js') ?>" defer></script>
</body>
</html>
