<?php

namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

class AuthFilter implements FilterInterface
{
   public function before(RequestInterface $request, $arguments = null)
{
    $uri = trim($request->getUri()->getPath(), '/');

    // Halaman yang boleh diakses tanpa login
    if (preg_match('#(^|/)admin/(login|ceklogin|logout)$#i', $uri)) {
        return;
    }

    // Cek login
    if (!session()->get('is_admin_login')) {
        session()->setFlashdata('error', 'Silakan login terlebih dahulu.');
        return redirect()->to(site_url('Admin/login'));
    }

    // Jika route meminta role tertentu
    if (!empty($arguments)) {
        $role = session()->get('role');

        if (!in_array($role, $arguments)) {
            session()->setFlashdata('error', 'Anda tidak memiliki hak akses.');
            return redirect()->to(site_url('Admin'));
        }
    }
}

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        //
    }
}
