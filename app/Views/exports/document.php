<?php
$copy = [
    'cv' => ['id' => 'CURRICULUM VITAE', 'en' => 'CURRICULUM VITAE'],
    'portfolio' => ['id' => 'PORTOFOLIO', 'en' => 'PORTFOLIO'],
    'profile' => ['id' => 'PROFIL', 'en' => 'PROFILE'],
    'education' => ['id' => 'PENDIDIKAN', 'en' => 'EDUCATION'],
    'experience' => ['id' => 'PENGALAMAN', 'en' => 'EXPERIENCE'],
    'projects' => ['id' => 'PROYEK PILIHAN', 'en' => 'SELECTED PROJECTS'],
    'skills' => ['id' => 'KEAHLIAN', 'en' => 'SKILLS'],
    'certificates' => ['id' => 'SERTIFIKAT & PRESTASI', 'en' => 'CERTIFICATES & RECOGNITION'],
    'current' => ['id' => 'Saat ini', 'en' => 'Present'],
];
$t = static fn (string $key): string => portfolio_t($locale, $copy[$key]);
$name = $profile['full_name'] ?? 'Mutiara Putri';
$maxProjects = $fullPortfolio ? count($projects) : 3;
$maxExperiences = $fullPortfolio ? count($experiences) : 4;
$maxSkills = $fullPortfolio ? count($skills) : 12;
$maxCertificates = $fullPortfolio ? count($certificates) : 6;
$shownProjects = array_slice($projects, 0, $maxProjects);
$shownExperiences = array_slice($experiences, 0, $maxExperiences);
$shownSkills = array_slice($skills, 0, $maxSkills);
$shownCertificates = array_slice($certificates, 0, $maxCertificates);
$website = ! empty($profile['website']) ? $profile['website'] : 'mutiaraputri.my.id';
$formatPeriod = static function (array $row) use ($locale): string {
    return portfolio_period($row['start_date'] ?? null, $row['end_date'] ?? null, (bool) ($row['is_current'] ?? false), $locale);
};
?>
<!DOCTYPE html>
<html lang="<?= esc($locale) ?>">
<head>
    <meta charset="UTF-8">
    <style>
        @page { size: A4 portrait; margin: 15mm 16mm 17mm; }
        * { box-sizing: border-box; }
        body { margin: 0; color: #29332d; font-family: "DejaVu Sans", sans-serif; font-size: 9.2pt; line-height: 1.52; }
        .topline { width: 100%; height: 4px; background: #145d49; margin-bottom: 17px; }
        .header { width: 100%; border-collapse: collapse; border-bottom: 1px solid #dfe4dc; padding-bottom: 13px; }
        .header td { vertical-align: middle; }
        .header-main { width: 79%; }
        .doc-type { margin-bottom: 5px; color: #668373; font-size: 7.3pt; font-weight: bold; letter-spacing: 1.5px; }
        h1 { margin: 0; color: #0d4235; font-family: "DejaVu Serif", serif; font-size: 25pt; font-weight: normal; line-height: 1.12; }
        .headline { margin-top: 5px; color: #4d6c59; font-size: 10pt; }
        .profile-image { width: 82px; max-height: 82px; border: 2px solid #d7e4dc; border-radius: 50%; }
        .contact { margin-top: 9px; color: #657168; font-size: 8pt; }
        .contact span { margin-right: 13px; }
        .summary { margin: 13px 0 17px; color: #58635a; font-size: 9pt; line-height: 1.6; }
        .section { margin-top: 15px; }
        .section-title { margin: 0 0 7px; padding-bottom: 4px; border-bottom: 1px solid #d9e2d9; color: #145d49; font-size: 8pt; font-weight: bold; letter-spacing: 1.15px; }
        .entry { page-break-inside: avoid; margin: 0 0 8px; }
        .entry-table { width: 100%; border-collapse: collapse; }
        .entry-table td { vertical-align: top; }
        .entry-title { color: #27332b; font-size: 9.3pt; font-weight: bold; }
        .entry-subtitle { margin-top: 1px; color: #5d6d61; font-size: 8.5pt; }
        .entry-date { width: 140px; color: #78867b; font-size: 7.7pt; text-align: right; }
        .entry-text { margin-top: 4px; color: #5f6961; font-size: 8.1pt; line-height: 1.55; }
        .entry-tags { margin-top: 3px; color: #6f8474; font-size: 7.4pt; }
        .project-image { max-width: 100%; max-height: 175px; margin: 7px 0 5px; object-fit: cover; }
        .skill-line { margin: 0; color: #48584c; font-size: 8.4pt; }
        .skill-line strong { color: #0d4235; }
        .footer { position: fixed; bottom: -10mm; left: 0; right: 0; padding-top: 4px; border-top: 1px solid #e2e6df; color: #879188; font-size: 7pt; }
        .footer td:last-child { text-align: right; }
    </style>
</head>
<body>
<div class="topline"></div>
<table class="header"><tr><td class="header-main"><div class="doc-type"><?= esc($fullPortfolio ? $t('portfolio') : $t('cv')) ?></div><h1><?= esc($name) ?></h1><div class="headline"><?= esc(portfolio_localized($profile, 'headline', $locale, $locale === 'en' ? 'Personal Portfolio' : 'Portofolio Pribadi')) ?></div></td><td><?php if (! empty($profile['avatar_data'])): ?><img class="profile-image" src="<?= esc($profile['avatar_data']) ?>" alt=""><?php endif; ?></td></tr></table>
<div class="contact">
    <?php if (! empty($profile['email'])): ?><span><?= esc($profile['email']) ?></span><?php endif; ?>
    <?php if (! empty($profile['phone'])): ?><span><?= esc($profile['phone']) ?></span><?php endif; ?>
    <?php if (! empty($profile['location'])): ?><span><?= esc($profile['location']) ?></span><?php endif; ?>
    <?php if (! empty($profile['linkedin_url'])): ?><span><?= esc($profile['linkedin_url']) ?></span><?php endif; ?>
    <?php if (! empty($profile['instagram_url'])): ?><span><?= esc($profile['instagram_url']) ?></span><?php endif; ?>
    <span><?= esc($website) ?></span>
</div>
<?php if (! empty(portfolio_localized($profile, 'summary', $locale))): ?><p class="summary"><?= nl2br(esc(portfolio_localized($profile, 'summary', $locale))) ?></p><?php endif; ?>

<?php if ($education !== []): ?><section class="section"><h2 class="section-title"><?= esc($t('education')) ?></h2><?php foreach ($education as $item): ?><div class="entry"><table class="entry-table"><tr><td><div class="entry-title"><?= esc($item['institution']) ?></div><div class="entry-subtitle"><?= esc(portfolio_localized($item, 'program', $locale)) ?><?= ! empty($item['location']) ? ' · ' . esc($item['location']) : '' ?></div></td><td class="entry-date"><?= esc($formatPeriod($item) ?: (! empty($item['is_current']) ? $t('current') : '')) ?></td></tr></table><?php if (! empty(portfolio_localized($item, 'description', $locale))): ?><div class="entry-text"><?= nl2br(esc(portfolio_localized($item, 'description', $locale))) ?></div><?php endif; ?></div><?php endforeach; ?></section><?php endif; ?>

<?php if ($shownExperiences !== []): ?><section class="section"><h2 class="section-title"><?= esc($t('experience')) ?></h2><?php foreach ($shownExperiences as $item): ?><div class="entry"><table class="entry-table"><tr><td><div class="entry-title"><?= esc(portfolio_localized($item, 'role', $locale)) ?></div><div class="entry-subtitle"><?= esc($item['organization']) ?><?= ! empty($item['location']) ? ' · ' . esc($item['location']) : '' ?></div></td><td class="entry-date"><?= esc($formatPeriod($item)) ?></td></tr></table><?php if (! empty(portfolio_localized($item, 'description', $locale))): ?><div class="entry-text"><?= nl2br(esc(portfolio_localized($item, 'description', $locale))) ?></div><?php endif; ?></div><?php endforeach; ?></section><?php endif; ?>

<?php if ($shownProjects !== []): ?><section class="section"><h2 class="section-title"><?= esc($t('projects')) ?></h2><?php foreach ($shownProjects as $item): ?><div class="entry"><table class="entry-table"><tr><td><div class="entry-title"><?= esc(portfolio_localized($item, 'title', $locale)) ?></div><div class="entry-subtitle"><?= esc(portfolio_localized($item, 'role', $locale)) ?><?= ! empty($item['project_url']) ? ' · ' . esc($item['project_url']) : '' ?></div></td><td class="entry-date"><?= esc($formatPeriod($item)) ?></td></tr></table><?php if ($fullPortfolio && ! empty($item['image_data'])): ?><img class="project-image" src="<?= esc($item['image_data']) ?>" alt=""><?php endif; ?><?php if (! empty(portfolio_localized($item, 'description', $locale))): ?><div class="entry-text"><?= nl2br(esc(portfolio_localized($item, 'description', $locale))) ?></div><?php endif; ?><?php if (! empty($item['tools'])): ?><div class="entry-tags"><?= esc(($locale === 'en' ? 'Tools: ' : 'Keahlian / alat: ') . $item['tools']) ?></div><?php endif; ?></div><?php endforeach; ?></section><?php endif; ?>

<?php if ($shownSkills !== []): ?><section class="section"><h2 class="section-title"><?= esc($t('skills')) ?></h2><p class="skill-line"><?php foreach ($shownSkills as $index => $skill): ?><?= $index ? ' · ' : '' ?><strong><?= esc(portfolio_localized($skill, 'name', $locale)) ?></strong><?php if (! empty(portfolio_localized($skill, 'level', $locale))): ?> <span>(<?= esc(portfolio_localized($skill, 'level', $locale)) ?>)</span><?php endif; ?><?php endforeach; ?></p></section><?php endif; ?>

<?php if ($shownCertificates !== []): ?><section class="section"><h2 class="section-title"><?= esc($t('certificates')) ?></h2><?php foreach ($shownCertificates as $item): ?><div class="entry"><table class="entry-table"><tr><td><div class="entry-title"><?= esc(portfolio_localized($item, 'name', $locale)) ?></div><div class="entry-subtitle"><?= esc($item['issuer'] ?? '') ?><?= ! empty($item['credential_url']) ? ' · ' . esc($item['credential_url']) : '' ?></div></td><td class="entry-date"><?= esc(portfolio_period($item['issue_date'] ?? null, null, false, $locale)) ?></td></tr></table></div><?php endforeach; ?></section><?php endif; ?>

<table class="footer"><tr><td><?= esc($name) ?> · <?= esc($fullPortfolio ? $t('portfolio') : $t('cv')) ?></td><td><?= esc($website) ?></td></tr></table>
</body>
</html>
