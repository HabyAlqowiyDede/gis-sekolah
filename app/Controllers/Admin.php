<?php

namespace App\Controllers;

use App\Models\ModelSekolah;
use App\Models\ModelSetting;
use App\Models\ModelUser;
use App\Models\ModelWilayah;
use App\Models\ProfilModel;

class Admin extends BaseController
{
    protected $ModelSetting;
    protected $ModelUser;
    protected $ModelSekolah;
    protected $ModelWilayah;
    protected $profilModel;

    public function __construct()
    {
        session();
        $this->ModelSetting = new ModelSetting();
        $this->ModelUser = new ModelUser();
        $this->ModelSekolah = new ModelSekolah();
        $this->ModelWilayah = new ModelWilayah();
        $this->profilModel = new ProfilModel();
    }

    public function login()
    {
        if (session()->get('is_admin_login')) {
            $role = session()->get('role');
            if ($role === 'super_admin') {
                return redirect()->to(site_url('Admin'));
            }
            return redirect()->to(site_url('Sekolah'));
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
        session()->remove([
            'is_admin_login',
            'id_user',
            'id_sekolah',
            'nama_user',
            'email_user',
            'role'
        ]);
        session()->set([
            'is_admin_login' => true,
            'id_user'        => $user['id_user'],
            'id_sekolah'     => $user['id_sekolah'] ?? null,
            'nama_user'      => $user['nama_user'],
            'email_user'     => $user['email'],
            'role'           => $user['role'],
        ]);
      session()->remove('school_form_draft');
        if (($user['role'] ?? '') === 'super_admin') {
            return redirect()->to(site_url('Admin'));
        }

        return redirect()->to(site_url('Sekolah'));
    }

    public function logout()
    {
        session()->destroy();

        return redirect()->to(site_url('Admin/login'));
    }

    public function index()
    {
        if (isAdminSekolah()) {
            return redirect()->to(site_url('Sekolah'));
        }

        // Jika superadmin, tampilkan dashboard superadmin dengan semua data
        $all = $this->ModelSekolah->AllData();
        $wilayahData = $this->ModelWilayah->AllData();

        // Ambil beberapa statistik dasar dari model
        $data = [
            'menu' => 'dashboard',
            'page' => 'admin/superadmin/dashboard',
            'jumlah_tk' => $this->ModelSekolah->JumlahTK(),
            'jumlah_sd' => $this->ModelSekolah->JumlahSD(),
            'jumlah_smp' => $this->ModelSekolah->JumlahSMP(),
            'jumlah_sekolah' => $this->ModelSekolah->JumlahSekolah(),
            'jumlah_wilayah' => count($wilayahData),
            'data_terbaru' => array_slice($all, 0, 5),
            'sekolah' => $all,
            'wilayah' => $wilayahData,
        ];

        return view('admin/v_template_back_end', $data);
    }

    public function Setting()
    {

        $data = [
            'menu' => 'setting',
            'page' => 'admin/superadmin/setting',
            'web' => $this->ModelSetting->DataWeb(),
            'profil' => $this->profilModel->first() ?? [],
        ];
        return view('admin/v_template_back_end', $data);
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
