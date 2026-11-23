<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;

class Auth extends BaseController
{
    public function loginForm(): string|\CodeIgniter\HTTP\RedirectResponse
    {
        if (session()->get('admin_user_id')) {
            return redirect()->to(site_url('admin'));
        }

        return view('admin/login', [
            'title' => 'Masuk ke panel admin',
            'error' => session()->getFlashdata('error'),
        ]);
    }

    public function login(): \CodeIgniter\HTTP\RedirectResponse
    {
        $email = strtolower(trim((string) $this->request->getPost('email')));
        $password = (string) $this->request->getPost('password');
        $now = time();
        $attempts = array_values(array_filter(
            session()->get('admin_login_attempts') ?? [],
            static fn ($attempt): bool => is_int($attempt) && $attempt > $now - 300,
        ));

        if (count($attempts) >= 6) {
            session()->set('admin_login_attempts', $attempts);
            session()->setFlashdata('error', 'Terlalu banyak percobaan. Silakan tunggu beberapa menit.');
            return redirect()->to(site_url('admin/login'));
        }

        $user = db_connect()->table('admin_users')->where('email', $email)->get()->getRowArray();

        if ($user && password_verify($password, $user['password_hash'])) {
            session()->regenerate(true);
            session()->remove('admin_login_attempts');
            session()->set([
                'admin_user_id' => (int) $user['id'],
                'admin_user_name' => $user['name'],
                'admin_user_email' => $user['email'],
            ]);

            return redirect()->to(site_url('admin'));
        }

        $attempts[] = $now;
        session()->set('admin_login_attempts', $attempts);
        session()->setFlashdata('error', 'Email atau kata sandi belum cocok.');

        return redirect()->to(site_url('admin/login'));
    }

    public function logout(): \CodeIgniter\HTTP\RedirectResponse
    {
        session()->destroy();

        return redirect()->to(site_url('admin/login'));
    }

    public function passwordForm(): string
    {
        return view('admin/password', [
            'title' => 'Ubah kata sandi',
            'error' => session()->getFlashdata('error'),
            'success' => session()->getFlashdata('success'),
            'validation' => service('validation'),
        ]);
    }

    public function changePassword(): \CodeIgniter\HTTP\RedirectResponse
    {
        $rules = [
            'current_password' => 'required',
            'new_password' => 'required|min_length[12]',
            'confirm_password' => 'required|matches[new_password]',
        ];

        if (! $this->validate($rules)) {
            return redirect()->back()->with('validation', $this->validator);
        }

        $user = db_connect()->table('admin_users')
            ->where('id', session()->get('admin_user_id'))
            ->get()
            ->getRowArray();

        if (! $user || ! password_verify((string) $this->request->getPost('current_password'), $user['password_hash'])) {
            session()->setFlashdata('error', 'Kata sandi saat ini tidak cocok.');
            return redirect()->back();
        }

        db_connect()->table('admin_users')
            ->where('id', $user['id'])
            ->update([
                'password_hash' => password_hash((string) $this->request->getPost('new_password'), PASSWORD_DEFAULT),
                'updated_at' => date('Y-m-d H:i:s'),
            ]);

        session()->setFlashdata('success', 'Kata sandi berhasil diperbarui.');

        return redirect()->to(site_url('admin/password'));
    }
}
