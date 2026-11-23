<?= $this->extend('admin/layout') ?>
<?= $this->section('content') ?>
<div class="form-heading"><span class="admin-kicker">IDENTITAS PUBLIK</span><h1>Profil utama</h1><p>Informasi ini digunakan pada beranda, CV, dan portofolio PDF.</p></div>
<?php if (! empty($success)): ?><div class="notice notice-success"><?= esc($success) ?></div><?php endif; ?>
<?php if (! empty($error)): ?><div class="notice notice-error"><?= esc($error) ?></div><?php endif; ?>
<form class="admin-panel admin-form edit-form" action="<?= site_url('admin/profile/save') ?>" method="post" enctype="multipart/form-data">
    <?= csrf_field() ?><div class="form-grid">
        <?php $fields = [
            'full_name' => ['label' => 'Nama lengkap', 'type' => 'text', 'wide' => true],
            'headline_id' => ['label' => 'Headline (Indonesia)', 'type' => 'text'],
            'headline_en' => ['label' => 'Headline (English)', 'type' => 'text'],
            'summary_id' => ['label' => 'Profil singkat (Indonesia)', 'type' => 'textarea', 'wide' => true],
            'summary_en' => ['label' => 'Short profile (English)', 'type' => 'textarea', 'wide' => true],
            'location' => ['label' => 'Lokasi', 'type' => 'text'],
            'email' => ['label' => 'Email publik', 'type' => 'email'],
            'phone' => ['label' => 'Nomor telepon publik', 'type' => 'tel'],
            'website' => ['label' => 'Website', 'type' => 'url'],
            'linkedin_url' => ['label' => 'LinkedIn', 'type' => 'url'],
            'instagram_url' => ['label' => 'Instagram', 'type' => 'url'],
        ]; ?>
        <?php foreach ($fields as $name => $field): ?>
            <div class="form-field <?= ! empty($field['wide']) ? 'form-field-wide' : '' ?>"><label for="field-<?= esc($name) ?>"><?= esc($field['label']) ?><?= $name === 'full_name' || str_starts_with($name, 'headline') ? ' *' : '' ?></label>
                <?php if ($field['type'] === 'textarea'): ?><textarea id="field-<?= esc($name) ?>" name="<?= esc($name) ?>" rows="4"><?= esc(old($name, $profile[$name] ?? '')) ?></textarea><?php else: ?><input id="field-<?= esc($name) ?>" name="<?= esc($name) ?>" type="<?= esc($field['type']) ?>" value="<?= esc(old($name, $profile[$name] ?? '')) ?>" <?= $name === 'full_name' || str_starts_with($name, 'headline') ? 'required' : '' ?>><?php endif; ?>
                <?php if ($validation->hasError($name)): ?><small class="field-error"><?= esc($validation->getError($name)) ?></small><?php endif; ?>
            </div>
        <?php endforeach; ?>
        <div class="form-field form-field-wide"><label for="avatar">Foto profil</label><input id="avatar" name="avatar" type="file" accept="image/jpeg,image/png,image/webp"><small>Gunakan gambar JPG, PNG, atau WebP hingga 5 MB.</small><?php if (! empty($profile['avatar_path'])): ?><div class="current-image"><img src="<?= base_url(esc($profile['avatar_path'])) ?>" alt="Foto profil saat ini"><span>Foto profil saat ini</span></div><?php endif; ?></div>
    </div><div class="form-actions"><button class="admin-button admin-button-primary" type="submit">Simpan profil <span aria-hidden="true">→</span></button></div>
</form>
<?= $this->endSection() ?>
