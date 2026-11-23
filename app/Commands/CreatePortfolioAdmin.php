<?php

namespace App\Commands;

use CodeIgniter\CLI\BaseCommand;
use CodeIgniter\CLI\CLI;

class CreatePortfolioAdmin extends BaseCommand
{
    protected $group = 'Portfolio';
    protected $name = 'portfolio:create-admin';
    protected $description = 'Buat akun admin untuk panel portofolio.';
    protected $usage = 'portfolio:create-admin';
    protected $arguments = [];
    protected $options = [];

    public function run(array $params)
    {
        $name = trim(CLI::prompt('Nama admin', null, 'required'));
        $email = strtolower(trim(CLI::prompt('Email admin', null, 'required|valid_email')));

        if (db_connect()->table('admin_users')->where('email', $email)->countAllResults()) {
            CLI::error('Email tersebut sudah memiliki akun admin.');
            return EXIT_ERROR;
        }

        $password = CLI::prompt('Kata sandi (minimal 12 karakter)', null, 'required');
        $confirmation = CLI::prompt('Ulangi kata sandi', null, 'required');

        if (strlen($password) < 12 || ! hash_equals($password, $confirmation)) {
            CLI::error('Kata sandi harus minimal 12 karakter dan kedua input harus sama.');
            return EXIT_ERROR;
        }

        db_connect()->table('admin_users')->insert([
            'name' => $name,
            'email' => $email,
            'password_hash' => password_hash($password, PASSWORD_DEFAULT),
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ]);

        CLI::write('Akun admin berhasil dibuat.', 'green');

        return EXIT_SUCCESS;
    }
}
