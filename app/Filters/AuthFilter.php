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

        if (preg_match('#(^|/)admin/(login|ceklogin|logout)$#i', $uri)) {
            return;
        }

        if (! session()->get('is_admin_login')) {
            session()->setFlashdata('error', 'Silakan login terlebih dahulu.');
            return redirect()->to(site_url('Admin/login'));
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        //
    }
}
