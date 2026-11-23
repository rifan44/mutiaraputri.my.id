<?= $this->extend('admin/layout') ?>
<?= $this->section('content') ?>
<div class="section-title-row content-title-row"><div><span class="admin-kicker">PENGELOLAAN KONTEN</span><h1><?= esc($title) ?></h1><p>Atur informasi yang tampil pada website dan dokumen PDF.</p></div><a class="admin-button admin-button-primary" href="<?= site_url('admin/' . $resource . '/new') ?>"><span aria-hidden="true">＋</span> Tambah data</a></div>
<?php if (! empty($success)): ?><div class="notice notice-success"><?= esc($success) ?></div><?php endif; ?>
<?php if (! empty($error)): ?><div class="notice notice-error"><?= esc($error) ?></div><?php endif; ?>
<div class="admin-panel table-panel">
    <?php if ($rows === []): ?>
        <div class="empty-admin"><span aria-hidden="true">✳</span><h2>Belum ada data di bagian ini.</h2><p>Tambahkan informasi yang ingin ditampilkan pada website publik.</p><a class="admin-button admin-button-primary" href="<?= site_url('admin/' . $resource . '/new') ?>">Tambah <?= esc(strtolower($title)) ?> <span aria-hidden="true">→</span></a></div>
    <?php else: ?>
        <div class="table-scroll"><table class="content-table"><thead><tr><th>INFORMASI</th><th>URUTAN</th><th>STATUS</th><th class="actions-column">AKSI</th></tr></thead><tbody>
        <?php foreach ($rows as $row): ?>
            <?php $primary = (string) ($row[$config['primary']] ?? 'Data tanpa judul'); $secondary = ''; foreach ($config['columns'] as $column) { if ($column !== $config['primary'] && ! empty($row[$column])) { $secondary = (string) $row[$column]; break; } } ?>
            <tr><td><strong><?= esc($primary) ?></strong><?php if ($secondary !== ''): ?><small><?= esc($secondary) ?></small><?php endif; ?></td><td><?= (int) ($row['sort_order'] ?? 0) ?></td><td><span class="status-pill <?= ! empty($row['is_visible']) ? 'status-visible' : 'status-hidden' ?>"><?= ! empty($row['is_visible']) ? 'Tampil' : 'Disembunyikan' ?></span></td><td class="row-actions"><a class="edit-link" href="<?= site_url('admin/' . $resource . '/' . (int) $row['id']) ?>">Ubah</a><form action="<?= site_url('admin/' . $resource . '/delete/' . (int) $row['id']) ?>" method="post" onsubmit="return confirm('Hapus data ini?')"><?= csrf_field() ?><button class="delete-link" type="submit">Hapus</button></form></td></tr>
        <?php endforeach; ?>
        </tbody></table></div>
        <div class="table-footnote"><?= count($rows) ?> data · Urutkan dari nilai yang paling kecil.</div>
    <?php endif; ?>
</div>
<?= $this->endSection() ?>
