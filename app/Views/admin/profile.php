<?= $this->extend('admin/layout') ?>
<?= $this->section('content') ?>
<div class="form-heading"><span class="admin-kicker">IDENTITAS PUBLIK</span><h1>Profil utama</h1><p>Informasi ini digunakan pada beranda, CV, dan portofolio PDF.</p></div>
<?php if (! empty($success)): ?><div class="notice notice-success"><?= esc($success) ?></div><?php endif; ?>
<?php if (! empty($error)): ?><div class="notice notice-error"><?= esc($error) ?></div><?php endif; ?>
<?php $photoUrl = ! empty($profile['avatar_path']) ? base_url(esc($profile['avatar_path'])) : ''; ?>
<form id="profile-form" class="admin-panel admin-form edit-form" action="<?= site_url('admin/profile/save') ?>" method="post" enctype="multipart/form-data">
    <?= csrf_field() ?>
    <section class="photo-editor-card" aria-labelledby="photo-editor-title">
        <div class="photo-editor-heading"><div><span class="admin-kicker">FOTO PROFIL</span><h2 id="photo-editor-title">Atur foto utama</h2><p>Geser, perbesar, atau perkecil foto sampai pas di bingkai. Crop akan dipakai pada website dan PDF.</p></div><span class="photo-editor-mark" aria-hidden="true">✳</span></div>
        <label class="photo-upload-label" for="avatar">Upload foto profil</label>
        <input id="avatar" name="avatar" type="file" accept="image/jpeg,image/png,image/webp">
        <small class="photo-file-note">JPG, PNG, atau WebP · Maksimal 5 MB.</small>
        <div id="photo-editor" class="photo-editor" <?= $photoUrl === '' ? 'hidden' : '' ?>>
            <div class="photo-preview-column">
                <div id="photo-crop-stage" class="photo-crop-stage" aria-label="Area crop foto profil"><img id="avatar-crop-image" src="<?= esc($photoUrl) ?>" alt="Pratinjau foto profil" draggable="false"><span class="crop-corner crop-corner-tl"></span><span class="crop-corner crop-corner-tr"></span><span class="crop-corner crop-corner-bl"></span><span class="crop-corner crop-corner-br"></span></div>
                <small id="photo-crop-help" class="photo-crop-help">Seret foto di dalam bingkai untuk mengatur posisi.</small>
            </div>
            <div class="photo-settings">
                <div class="photo-setting"><label for="avatar-ratio">Rasio crop</label><select id="avatar-ratio"><option value="0.8">Potret · 4:5</option><option value="1">Kotak · 1:1</option></select></div>
                <div class="photo-setting"><div class="range-label"><label for="avatar-zoom">Perbesar / perkecil</label><output id="avatar-zoom-value" for="avatar-zoom">100%</output></div><input id="avatar-zoom" type="range" min="1" max="3" step="0.01" value="1"></div>
                <button id="photo-crop-reset" class="photo-reset-button" type="button"><span aria-hidden="true">↺</span> Sesuaikan otomatis</button>
                <p class="photo-settings-note">Hasil akhir dibuat tajam untuk foto profil dan dokumen A4.</p>
            </div>
        </div>
        <p id="photo-status" class="photo-status" role="status" aria-live="polite"><?= $photoUrl !== '' ? 'Crop saat ini sudah tersimpan.' : 'Pilih foto untuk membuka pengaturan crop.' ?></p>
    </section>
    <div class="form-grid">
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
    </div><div class="form-actions"><button class="admin-button admin-button-primary" type="submit">Simpan profil <span aria-hidden="true">→</span></button></div>
</form>
<script src="<?= base_url('assets/js/photo-editor.js') ?>" defer></script>
<?= $this->endSection() ?>
