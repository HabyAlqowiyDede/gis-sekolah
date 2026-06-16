<?php

namespace App\Controllers;

use App\Models\ModelSetting;
use App\Models\ModelUser;

class Admin extends BaseController
{
    protected $ModelSetting;
    protected $ModelUser;

    public function __construct()
    {
        session();
        $this->ModelSetting = new ModelSetting();
        $this->ModelUser = new ModelUser();
    }
    
    public function login()
    {
        if (session()->get('is_admin_login')) {
            return redirect()->to(site_url('Admin'));
        }

        $data = [
            'judul' => 'login',
        ];
        return view('Auth/login_admin', $data);
    }

    public function cekLogin()
    {
        $login = trim((string) $this->request->getPost('email'));
        $password = (string) $this->request->getPost('password');

        if ($login === '' || $password === '') {
            session()->setFlashdata('error', 'Email/username dan password wajib diisi.');
            return redirect()->to(site_url('Admin/login'))->withInput();
        }

        $user = $this->ModelUser->getByEmailOrUsername($login);

        if (!$user || !$this->passwordCocok($password, (string) $user['password'])) {
            session()->setFlashdata('error', 'Email/username atau password salah.');
            return redirect()->to(site_url('Admin/login'))->withInput();
        }

        session()->regenerate();
        session()->set([
            'is_admin_login' => true,
            'id_user' => $user['id_user'],
            'nama_user' => $user['nama_user'],
            'email_user' => $user['email'],
        ]);

        return redirect()->to(site_url('Admin'));
    }

    public function logout()
    {
        session()->remove(['is_admin_login', 'id_user', 'nama_user', 'email_user']);
        session()->setFlashdata('success', 'Anda berhasil logout.');

        return redirect()->to(site_url('Admin/login'));
    }

    public function index()
    {
        $data = [
            'judul' => 'Dashboard',
            'menu' => 'dashboard',
            'page' => 'v_dashboard'
        ];
        return view('v_template_back_end', $data);
    }

    public function Setting()
    {
        
        $data = [
            'menu' => 'setting',
            'page' => 'v_setting',
            'web' => $this->ModelSetting->DataWeb(),
        ];
        return view('v_template_back_end', $data);
    }
    
    public function UpdateSetting()
    {
        $data = [
            'id' => 1,
            'nama_web' => $this->request->getPost('nama_web'),
            'coordinat_wilayah' => $this->request->getPost('coordinat_wilayah'),
            'zoom_view' => $this->request->getPost('zoom_view'),
        ];
        $this->ModelSetting->UpdateSetting($data);
        session()->setFlashdata('pesan', 'Settingan Web berhasil diupdate');
        return redirect()->to('Admin/Setting');
    }

    private function passwordCocok(string $inputPassword, string $storedPassword): bool
    {
        if ($storedPassword === '') {
            return false;
        }

        $passwordInfo = password_get_info($storedPassword);

        if ($passwordInfo['algo'] !== 0 && $passwordInfo['algo'] !== null) {
            return password_verify($inputPassword, $storedPassword);
        }

        return hash_equals($storedPassword, $inputPassword)
            || hash_equals($storedPassword, md5($inputPassword));
    }
}
