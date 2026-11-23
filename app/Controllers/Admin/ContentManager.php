<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use CodeIgniter\Exceptions\PageNotFoundException;

class ContentManager extends BaseController
{
    private const RESOURCES = [
        'education' => [
            'label' => 'Pendidikan', 'label_en' => 'Education', 'table' => 'education', 'primary' => 'institution',
            'columns' => ['institution', 'program_id', 'location'],
            'fields' => [
                'institution' => ['label' => 'Institusi', 'type' => 'text', 'required' => true, 'rules' => 'required|max_length[180]'],
                'program_id' => ['label' => 'Program / jurusan (Indonesia)', 'type' => 'text', 'required' => true, 'rules' => 'required|max_length[180]'],
                'program_en' => ['label' => 'Program / major (English)', 'type' => 'text', 'rules' => 'permit_empty|max_length[180]'],
                'description_id' => ['label' => 'Keterangan (Indonesia)', 'type' => 'textarea'],
                'description_en' => ['label' => 'Description (English)', 'type' => 'textarea'],
                'location' => ['label' => 'Lokasi', 'type' => 'text', 'rules' => 'permit_empty|max_length[160]'],
                'start_date' => ['label' => 'Tanggal mulai', 'type' => 'date', 'rules' => 'permit_empty|valid_date[Y-m-d]'],
                'end_date' => ['label' => 'Tanggal selesai', 'type' => 'date', 'rules' => 'permit_empty|valid_date[Y-m-d]'],
                'is_current' => ['label' => 'Masih berlangsung', 'type' => 'checkbox'],
                'sort_order' => ['label' => 'Urutan tampil', 'type' => 'number'],
                'is_visible' => ['label' => 'Tampilkan di website', 'type' => 'checkbox', 'checked' => true],
            ],
        ],
        'experiences' => [
            'label' => 'Pengalaman', 'label_en' => 'Experience', 'table' => 'experiences', 'primary' => 'organization',
            'columns' => ['organization', 'role_id', 'location'],
            'fields' => [
                'organization' => ['label' => 'Organisasi / perusahaan', 'type' => 'text', 'required' => true, 'rules' => 'required|max_length[180]'],
                'role_id' => ['label' => 'Peran (Indonesia)', 'type' => 'text', 'required' => true, 'rules' => 'required|max_length[180]'],
                'role_en' => ['label' => 'Role (English)', 'type' => 'text', 'rules' => 'permit_empty|max_length[180]'],
                'description_id' => ['label' => 'Deskripsi (Indonesia)', 'type' => 'textarea'],
                'description_en' => ['label' => 'Description (English)', 'type' => 'textarea'],
                'location' => ['label' => 'Lokasi', 'type' => 'text', 'rules' => 'permit_empty|max_length[160]'],
                'start_date' => ['label' => 'Tanggal mulai', 'type' => 'date', 'rules' => 'permit_empty|valid_date[Y-m-d]'],
                'end_date' => ['label' => 'Tanggal selesai', 'type' => 'date', 'rules' => 'permit_empty|valid_date[Y-m-d]'],
                'is_current' => ['label' => 'Masih berlangsung', 'type' => 'checkbox'],
                'sort_order' => ['label' => 'Urutan tampil', 'type' => 'number'],
                'is_visible' => ['label' => 'Tampilkan di website', 'type' => 'checkbox', 'checked' => true],
            ],
        ],
        'projects' => [
            'label' => 'Proyek', 'label_en' => 'Projects', 'table' => 'projects', 'primary' => 'title_id',
            'columns' => ['title_id', 'category_id', 'tools'],
            'fields' => [
                'title_id' => ['label' => 'Nama proyek (Indonesia)', 'type' => 'text', 'required' => true, 'rules' => 'required|max_length[180]'],
                'title_en' => ['label' => 'Project title (English)', 'type' => 'text', 'rules' => 'permit_empty|max_length[180]'],
                'category_id' => ['label' => 'Kategori (Indonesia)', 'type' => 'text', 'rules' => 'permit_empty|max_length[120]'],
                'category_en' => ['label' => 'Category (English)', 'type' => 'text', 'rules' => 'permit_empty|max_length[120]'],
                'description_id' => ['label' => 'Deskripsi (Indonesia)', 'type' => 'textarea'],
                'description_en' => ['label' => 'Description (English)', 'type' => 'textarea'],
                'role_id' => ['label' => 'Peran (Indonesia)', 'type' => 'text', 'rules' => 'permit_empty|max_length[160]'],
                'role_en' => ['label' => 'Role (English)', 'type' => 'text', 'rules' => 'permit_empty|max_length[160]'],
                'tools' => ['label' => 'Keahlian / alat yang dipakai', 'type' => 'text', 'rules' => 'permit_empty|max_length[255]'],
                'project_url' => ['label' => 'Tautan proyek', 'type' => 'url', 'rules' => 'permit_empty|valid_url_strict|max_length[255]'],
                'image_path' => ['label' => 'Foto proyek', 'type' => 'image'],
                'start_date' => ['label' => 'Tanggal mulai', 'type' => 'date', 'rules' => 'permit_empty|valid_date[Y-m-d]'],
                'end_date' => ['label' => 'Tanggal selesai', 'type' => 'date', 'rules' => 'permit_empty|valid_date[Y-m-d]'],
                'is_featured' => ['label' => 'Tandai sebagai proyek pilihan', 'type' => 'checkbox'],
                'sort_order' => ['label' => 'Urutan tampil', 'type' => 'number'],
                'is_visible' => ['label' => 'Tampilkan di website', 'type' => 'checkbox', 'checked' => true],
            ],
        ],
        'skills' => [
            'label' => 'Keahlian', 'label_en' => 'Skills', 'table' => 'skills', 'primary' => 'name_id',
            'columns' => ['name_id', 'category_id', 'level_id'],
            'fields' => [
                'name_id' => ['label' => 'Nama keahlian (Indonesia)', 'type' => 'text', 'required' => true, 'rules' => 'required|max_length[120]'],
                'name_en' => ['label' => 'Skill name (English)', 'type' => 'text', 'rules' => 'permit_empty|max_length[120]'],
                'category_id' => ['label' => 'Kategori (Indonesia)', 'type' => 'text', 'rules' => 'permit_empty|max_length[120]'],
                'category_en' => ['label' => 'Category (English)', 'type' => 'text', 'rules' => 'permit_empty|max_length[120]'],
                'level_id' => ['label' => 'Tingkat / konteks penggunaan (opsional)', 'type' => 'text', 'rules' => 'permit_empty|max_length[80]'],
                'level_en' => ['label' => 'Level / context (optional)', 'type' => 'text', 'rules' => 'permit_empty|max_length[80]'],
                'sort_order' => ['label' => 'Urutan tampil', 'type' => 'number'],
                'is_visible' => ['label' => 'Tampilkan di website', 'type' => 'checkbox', 'checked' => true],
            ],
        ],
        'certificates' => [
            'label' => 'Sertifikat & prestasi', 'label_en' => 'Certificates & awards', 'table' => 'certificates', 'primary' => 'name_id',
            'columns' => ['name_id', 'issuer', 'issue_date'],
            'fields' => [
                'name_id' => ['label' => 'Nama (Indonesia)', 'type' => 'text', 'required' => true, 'rules' => 'required|max_length[180]'],
                'name_en' => ['label' => 'Name (English)', 'type' => 'text', 'rules' => 'permit_empty|max_length[180]'],
                'issuer' => ['label' => 'Penerbit / penyelenggara', 'type' => 'text', 'rules' => 'permit_empty|max_length[180]'],
                'issue_date' => ['label' => 'Tanggal terbit', 'type' => 'date', 'rules' => 'permit_empty|valid_date[Y-m-d]'],
                'credential_url' => ['label' => 'Tautan verifikasi', 'type' => 'url', 'rules' => 'permit_empty|valid_url_strict|max_length[255]'],
                'image_path' => ['label' => 'Foto sertifikat (opsional)', 'type' => 'image'],
                'sort_order' => ['label' => 'Urutan tampil', 'type' => 'number'],
                'is_visible' => ['label' => 'Tampilkan di website', 'type' => 'checkbox', 'checked' => true],
            ],
        ],
    ];

    public function index(string $resource): string
    {
        $config = $this->resource($resource);
        $rows = db_connect()->table($config['table'])->orderBy('sort_order', 'ASC')->orderBy('id', 'DESC')->get()->getResultArray();

        return view('admin/content_list', [
            'title' => $config['label'],
            'resource' => $resource,
            'config' => $config,
            'rows' => $rows,
            'success' => session()->getFlashdata('success'),
            'error' => session()->getFlashdata('error'),
        ]);
    }

    public function form(string $resource, ?int $id = null): string
    {
        $config = $this->resource($resource);
        $row = $id ? db_connect()->table($config['table'])->where('id', $id)->get()->getRowArray() : null;

        if ($id && ! $row) {
            throw PageNotFoundException::forPageNotFound();
        }

        return view('admin/content_form', [
            'title' => ($id ? 'Ubah ' : 'Tambah ') . $config['label'],
            'resource' => $resource,
            'config' => $config,
            'row' => $row ?? [],
            'validation' => service('validation'),
        ]);
    }

    public function save(string $resource): \CodeIgniter\HTTP\RedirectResponse
    {
        $config = $this->resource($resource);
        $id = (int) $this->request->getPost('id');
        $rules = [];
        $data = [];

        foreach ($config['fields'] as $field => $definition) {
            if (($definition['type'] ?? '') === 'image') {
                continue;
            }

            if (isset($definition['rules'])) {
                $rules[$field] = $definition['rules'];
            }

            if (($definition['type'] ?? '') === 'checkbox') {
                $data[$field] = $this->request->getPost($field) ? 1 : 0;
                continue;
            }

            if (($definition['type'] ?? '') === 'number') {
                $data[$field] = max(0, (int) $this->request->getPost($field));
                continue;
            }

            $value = trim((string) $this->request->getPost($field));
            $data[$field] = $value === '' ? null : $value;
        }

        if ($rules !== [] && ! $this->validate($rules)) {
            return redirect()->back()->withInput()->with('validation', $this->validator);
        }

        $upload = $this->request->getFile('image_upload');
        $imageField = isset($config['fields']['image_path']) ? 'image_path' : null;

        if ($imageField && $upload && $upload->getError() !== UPLOAD_ERR_NO_FILE) {
            $error = $this->validateImage($upload);
            if ($error !== null) {
                session()->setFlashdata('error', $error);
                return redirect()->back()->withInput();
            }

            $directory = FCPATH . 'uploads/' . $resource;
            if (! is_dir($directory)) {
                mkdir($directory, 0755, true);
            }

            $filename = bin2hex(random_bytes(16)) . '.' . $this->extensionFor($upload->getMimeType());
            $upload->move($directory, $filename);
            $data[$imageField] = 'uploads/' . $resource . '/' . $filename;
        }

        $table = db_connect()->table($config['table']);
        $oldImage = null;
        if ($id) {
            $existing = $table->where('id', $id)->get()->getRowArray();
            if (! $existing) {
                throw PageNotFoundException::forPageNotFound();
            }
            $oldImage = $existing[$imageField ?? ''] ?? null;
            $data['updated_at'] = date('Y-m-d H:i:s');
            $table->where('id', $id)->update($data);
        } else {
            $data['created_at'] = date('Y-m-d H:i:s');
            $data['updated_at'] = date('Y-m-d H:i:s');
            $table->insert($data);
        }

        if ($oldImage && isset($data[$imageField ?? ''])) {
            $this->deleteUploadedImage($oldImage, $resource);
        }

        session()->setFlashdata('success', $config['label'] . ' berhasil disimpan.');

        return redirect()->to(site_url('admin/' . $resource));
    }

    public function delete(string $resource, int $id): \CodeIgniter\HTTP\RedirectResponse
    {
        $config = $this->resource($resource);
        $table = db_connect()->table($config['table']);
        $row = $table->where('id', $id)->get()->getRowArray();

        if ($row) {
            $table->where('id', $id)->delete();
            $this->deleteUploadedImage($row['image_path'] ?? null, $resource);
            session()->setFlashdata('success', 'Data berhasil dihapus.');
        }

        return redirect()->to(site_url('admin/' . $resource));
    }

    private function resource(string $resource): array
    {
        if (! isset(self::RESOURCES[$resource])) {
            throw PageNotFoundException::forPageNotFound();
        }

        return self::RESOURCES[$resource];
    }

    private function validateImage(\CodeIgniter\HTTP\Files\UploadedFile $file): ?string
    {
        if (! $file->isValid() || $file->hasMoved()) {
            return 'Foto tidak berhasil diunggah. Silakan pilih file lagi.';
        }

        if (($file->getSize() ?: 0) > 5 * 1024 * 1024) {
            return 'Ukuran foto maksimal 5 MB.';
        }

        if (! in_array($file->getMimeType(), ['image/jpeg', 'image/png', 'image/webp'], true)) {
            return 'Gunakan foto berformat JPG, PNG, atau WebP.';
        }

        return null;
    }

    private function extensionFor(string $mime): string
    {
        return match ($mime) {
            'image/jpeg' => 'jpg',
            'image/png' => 'png',
            'image/webp' => 'webp',
            default => 'jpg',
        };
    }

    private function deleteUploadedImage(?string $relativePath, string $resource): void
    {
        $prefix = 'uploads/' . $resource . '/';
        if (! $relativePath || ! str_starts_with($relativePath, $prefix)) {
            return;
        }

        $path = realpath(FCPATH . $relativePath);
        $root = realpath(FCPATH . $prefix);
        if ($path && $root && str_starts_with($path, $root . DIRECTORY_SEPARATOR) && is_file($path)) {
            unlink($path);
        }
    }
}
