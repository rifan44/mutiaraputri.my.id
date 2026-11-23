<?= $this->extend('admin/layout') ?>
<?= $this->section('content') ?>
<div class="form-heading"><span class="admin-kicker">KEAMANAN AKUN</span><h1>Ubah kata sandi</h1><p>Pilih kata sandi baru yang kuat dan unik.</p></div>
<?php if (! empty($success)): ?><div class="notice notice-success"><?= esc($success) ?></div><?php endif; ?>
<?php if (! empty($error)): ?><div class="notice notice-error"><?= esc($error) ?></div><?php endif; ?>
<form class="admin-panel admin-form password-form" action="<?= site_url('admin/password') ?>" method="post"><?= csrf_field() ?>
    <?php foreach ([['current_password', 'Kata sandi saat ini', 'current-password'], ['new_password', 'Kata sandi baru', 'new-password'], ['confirm_password', 'Ulangi kata sandi baru', 'new-password']] as [$name, $label, $autocomplete]): ?><div class="form-field"><label for="<?= esc($name) ?>"><?= esc($label) ?></label><input id="<?= esc($name) ?>" name="<?= esc($name) ?>" type="password" autocomplete="<?= esc($autocomplete) ?>" required><?php if ($validation->hasError($name)): ?><small class="field-error"><?= esc($validation->getError($name)) ?></small><?php endif; ?></div><?php endforeach; ?>
    <small class="password-guidance">Minimal 12 karakter. Gunakan kombinasi kata yang mudah kamu ingat dan sulit ditebak.</small><div class="form-actions"><button class="admin-button admin-button-primary" type="submit">Perbarui kata sandi <span aria-hidden="true">→</span></button></div>
</form>
<?= $this->endSection() ?>
