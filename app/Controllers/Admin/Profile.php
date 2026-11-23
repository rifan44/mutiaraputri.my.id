<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\Files\UploadedFile;

class Profile extends BaseController
{
    private const RULES = [
        'full_name' => 'required|max_length[120]',
        'headline_id' => 'required|max_length[180]',
        'headline_en' => 'required|max_length[180]',
        'email' => 'permit_empty|valid_email|max_length[190]',
        'phone' => 'permit_empty|max_length[40]',
        'website' => 'permit_empty|valid_url_strict|max_length[255]',
        'linkedin_url' => 'permit_empty|valid_url_strict|max_length[255]',
        'instagram_url' => 'permit_empty|valid_url_strict|max_length[255]',
    ];

    public function edit(): string
    {
        $profile = db_connect()->table('portfolio_profile')->where('id', 1)->get()->getRowArray() ?? [];

        return view('admin/profile', [
            'title' => 'Profil utama',
            'profile' => $profile,
            'success' => session()->getFlashdata('success'),
            'error' => session()->getFlashdata('error'),
            'validation' => service('validation'),
        ]);
    }

    public function save(): \CodeIgniter\HTTP\RedirectResponse
    {
        if (! $this->validate(self::RULES)) {
            return redirect()->back()->withInput()->with('validation', $this->validator);
        }

        $fields = array_keys(self::RULES);
        $data = [];
        foreach ($fields as $field) {
            $value = trim((string) $this->request->getPost($field));
            $data[$field] = $value === '' ? null : $value;
        }
        $data['summary_id'] = trim((string) $this->request->getPost('summary_id')) ?: null;
        $data['summary_en'] = trim((string) $this->request->getPost('summary_en')) ?: null;
        $data['location'] = trim((string) $this->request->getPost('location')) ?: null;

        $upload = $this->request->getFile('avatar');
        if ($upload && $upload->getError() !== UPLOAD_ERR_NO_FILE) {
            $error = $this->validateAvatar($upload);
            if ($error !== null) {
                session()->setFlashdata('error', $error);
                return redirect()->back()->withInput();
            }

            $directory = FCPATH . 'uploads/profile';
            if (! is_dir($directory)) {
                mkdir($directory, 0755, true);
            }
            $filename = bin2hex(random_bytes(16)) . '.' . $this->extensionFor($upload->getMimeType());
            $upload->move($directory, $filename);
            $data['avatar_path'] = 'uploads/profile/' . $filename;
        }

        $db = db_connect();
        $builder = $db->table('portfolio_profile');
        $existing = $builder->where('id', 1)->get()->getRowArray();
        $oldAvatar = $existing['avatar_path'] ?? null;
        $data['updated_at'] = date('Y-m-d H:i:s');

        if ($existing) {
            $builder->where('id', 1)->update($data);
        } else {
            $builder->insert(['id' => 1, 'created_at' => date('Y-m-d H:i:s')] + $data);
        }

        if ($oldAvatar && isset($data['avatar_path'])) {
            $this->deleteAvatar($oldAvatar);
        }

        session()->setFlashdata('success', 'Profil berhasil diperbarui.');
        return redirect()->to(site_url('admin/profile'));
    }

    private function validateAvatar(UploadedFile $file): ?string
    {
        if (! $file->isValid() || $file->hasMoved()) {
            return 'Foto profil tidak berhasil diunggah. Silakan pilih file lagi.';
        }
        if (($file->getSize() ?: 0) > 5 * 1024 * 1024) {
            return 'Ukuran foto profil maksimal 5 MB.';
        }
        if (! in_array($file->getMimeType(), ['image/jpeg', 'image/png', 'image/webp'], true)) {
            return 'Gunakan foto berformat JPG, PNG, atau WebP.';
        }

        return null;
    }

    private function deleteAvatar(?string $relativePath): void
    {
        if (! $relativePath || ! str_starts_with($relativePath, 'uploads/profile/')) {
            return;
        }
        $path = realpath(FCPATH . $relativePath);
        $root = realpath(FCPATH . 'uploads/profile');
        if ($path && $root && str_starts_with($path, $root . DIRECTORY_SEPARATOR) && is_file($path)) {
            unlink($path);
        }
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
}
