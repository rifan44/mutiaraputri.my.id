<?= $this->extend('admin/layout') ?>
<?= $this->section('content') ?>
<div class="form-heading"><a class="back-link" href="<?= site_url('admin/' . $resource) ?>">← Kembali ke <?= esc(strtolower($title)) ?></a><span class="admin-kicker">FORMULIR PORTOFOLIO</span><h1><?= esc($title) ?></h1><p>Isi bagian bahasa Inggris jika ingin menampilkan konten dwibahasa.</p></div>
<?php if (session()->getFlashdata('error')): ?><div class="notice notice-error"><?= esc(session()->getFlashdata('error')) ?></div><?php endif; ?>
<form class="admin-panel admin-form edit-form" action="<?= site_url('admin/' . $resource . '/save') ?>" method="post" enctype="multipart/form-data">
    <?= csrf_field() ?><input type="hidden" name="id" value="<?= (int) ($row['id'] ?? 0) ?>">
    <div class="form-grid">
        <?php foreach ($config['fields'] as $name => $field): ?>
            <?php $value = old($name, $row[$name] ?? (($field['type'] ?? '') === 'checkbox' ? (! empty($field['checked']) ? 1 : 0) : '')); $fieldId = 'field-' . $name; ?>
            <?php if (($field['type'] ?? '') === 'checkbox'): ?>
                <label class="checkbox-field"><input id="<?= esc($fieldId) ?>" type="checkbox" name="<?= esc($name) ?>" value="1" <?= $value ? 'checked' : '' ?>><span class="checkmark"></span><span><?= esc($field['label']) ?></span></label>
            <?php elseif (($field['type'] ?? '') === 'image'): ?>
                <div class="form-field form-field-wide"><label for="image_upload"><?= esc($field['label']) ?></label><input id="image_upload" name="image_upload" type="file" accept="image/jpeg,image/png,image/webp"><small>JPG, PNG, WebP · Maksimal 5 MB.</small><?php if (! empty($row[$name])): ?><div class="current-image"><img src="<?= base_url(esc($row[$name])) ?>" alt="Foto saat ini"><span>Foto yang tersimpan saat ini</span></div><?php endif; ?><?php if ($validation->hasError('image_upload')): ?><small class="field-error"><?= esc($validation->getError('image_upload')) ?></small><?php endif; ?></div>
            <?php else: ?>
                <div class="form-field <?= ($field['type'] ?? '') === 'textarea' ? 'form-field-wide' : '' ?>"><label for="<?= esc($fieldId) ?>"><?= esc($field['label']) ?><?= ! empty($field['required']) ? ' *' : '' ?></label>
                    <?php if (($field['type'] ?? '') === 'textarea'): ?><textarea id="<?= esc($fieldId) ?>" name="<?= esc($name) ?>" rows="4" <?= ! empty($field['required']) ? 'required' : '' ?>><?= esc($value) ?></textarea>
                    <?php else: ?><input id="<?= esc($fieldId) ?>" name="<?= esc($name) ?>" type="<?= esc($field['type'] ?? 'text') ?>" value="<?= esc($value) ?>" <?= ! empty($field['required']) ? 'required' : '' ?> <?= ($field['type'] ?? '') === 'number' ? 'min="0"' : '' ?>><?php endif; ?>
                    <?php if ($validation->hasError($name)): ?><small class="field-error"><?= esc($validation->getError($name)) ?></small><?php endif; ?>
                </div>
            <?php endif; ?>
        <?php endforeach; ?>
    </div>
    <div class="form-actions"><a href="<?= site_url('admin/' . $resource) ?>" class="admin-button admin-button-muted">Batal</a><button class="admin-button admin-button-primary" type="submit">Simpan perubahan <span aria-hidden="true">→</span></button></div>
</form>
<?= $this->endSection() ?>
