<?php

namespace App\Filters;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;

class RoleFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        // Cek apakah sudah login
        if (!session()->get('is_admin_login')) {
            return redirect()->to('/Admin/login');
        }

        // Ambil role dari session
        $role = session()->get('role');

        // Jika tidak ada role yang dikirim, lanjutkan
        if (empty($arguments)) {
            return;
        }

        // Jika role tidak sesuai, tolak akses
        if (!in_array($role, $arguments)) {
            return redirect()->to('/L')
                ->with('error', 'Anda tidak memiliki hak akses untuk halaman ini.');
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // Tidak perlu diisi
    }
}