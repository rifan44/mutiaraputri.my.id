<?php

namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

class AdminAuth implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        if (session()->get('admin_user_id')) {
            return null;
        }

        return redirect()->to(site_url('admin/login'));
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        return null;
    }
}
