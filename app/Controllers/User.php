<?php

namespace App\Controllers;

use App\Models\ProfilModel;
use App\Models\ModelUser;

class User extends BaseController
{
    protected $profilModel;
    protected $ModelUser;

    public function __construct()
    {
        $this->profilModel = new ProfilModel();
        $this->ModelUser = new ModelUser();
    }

    public function index()
    {
        $data = [
            'menu' => 'profil',
            'profil' => $this->profilModel->first() ?? [],
            'page' => 'admin/superadmin/profil/v_index',
            'users' => isSuperAdmin() ? $this->ModelUser->getUsersWithSchool() : [],
        ];

        return view('admin/v_template_back_end', $data);
    }

    public function edit()
    {
        $data = [
            'menu' => 'profil',
            'profil' => $this->profilModel->first() ?? [],
            'page' => 'admin/superadmin/profil/v_edit',
        ];

        return view('admin/v_template_back_end', $data);
    }

    /**
     * Menampilkan halaman setting sederhana untuk user yang sedang login (operator sekolah)
     */
    public function setting()
    {
        // Hanya untuk pengguna yang sudah login (filter auth sudah diterapkan di route)
        $data = [
            'menu' => 'setting',
            'page' => 'admin/user_setting',
            'profil' => $this->profilModel->first() ?? [],
        ];

        return view('admin/v_template_back_end', $data);
    }

    // public function UpdateProfil()
    // {
    //     $validation = \Config\Services::validation();

    //     $rules = [
    //         'nama_dinas' => 'required|min_length[5]',
    //         'logo' => 'if_exist|is_image[logo]|max_size[logo,2048]',
    //     ];

    //     if (!$this->validate($rules)) {
    //         return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
    //     }

    //     $id = 1;
    //     $dataProfil = [
    //         'nama_dinas' => $this->request->getPost('nama_dinas'),
    //         'kepala_dinas' => $this->request->getPost('kepala_dinas'),
    //         'nip_kepala' => $this->request->getPost('nip_kepala'),
    //         'alamat' => $this->request->getPost('alamat'),
    //         'telepon' => $this->request->getPost('telepon'),
    //         'email' => $this->request->getPost('email'),
    //         'website' => $this->request->getPost('website'),
    //     ];

    //     // Handle logo upload
    //     $logo = $this->request->getFile('logo');
    //     if ($logo && $logo->isValid() && !$logo->hasMoved()) {
    //         $oldProfil = $this->profilModel->find($id);

    //         // Delete old logo
    //         if ($oldProfil && !empty($oldProfil['logo'])) {
    //             $oldLogoPath = FCPATH . 'profil' . DIRECTORY_SEPARATOR . $oldProfil['logo'];
    //             if (file_exists($oldLogoPath)) {
    //                 unlink($oldLogoPath);
    //             }
    //         }

    //         // Upload new logo
    //         $newName = $logo->getRandomName();
    //         $logo->move(FCPATH . 'profil', $newName);
    //         $dataProfil['logo'] = $newName;
    //     }

    //     $existingProfil = $this->profilModel->find($id);

    //     if ($existingProfil) {
    //         $this->profilModel->update($id, $dataProfil);
    //         return redirect()->to('setting')->with('success', 'Profil berhasil diperbarui');
    //     } else {
    //         $dataProfil['id_profil'] = $id;
    //         $this->profilModel->insert($dataProfil);
    //         return redirect()->to('setting')->with('success', 'Profil berhasil disimpan');
    //     }
    // }

    public function UpdatePassword()
    {
        $rules = [
            'id_user'      => 'required|is_natural_no_zero',
            'password'     => 'required|min_length[6]',
            'pass_confirm' => 'required|matches[password]',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()
                ->withInput()
                ->with('errors', $this->validator->getErrors());
        }

        $idUser      = (int) $this->request->getPost('id_user');
        $newPassword = $this->request->getPost('password');

        if (isSuperAdmin()) {

            $this->ModelUser->update($idUser, [
                'password' => password_hash($newPassword, PASSWORD_DEFAULT),
            ]);

            return redirect()->back()
                ->with('pesan', 'Password berhasil diperbarui.');
        }

        if (isAdminSekolah()) {

            if (session()->get('id_user') != $idUser) {
                return redirect()->back()
                    ->with('errors', [
                        'access' => 'Anda hanya boleh mengubah password akun sendiri.'
                    ]);
            }

            $this->ModelUser->update($idUser, [
                'password' => password_hash($newPassword, PASSWORD_DEFAULT),
            ]);

            return redirect()->back()
                ->with('pesan', 'Password berhasil diperbarui.');
        }
        return redirect()->back()
            ->with('errors', [
                'access' => 'Akses ditolak.'
            ]);
    }
    public function UpdateEmail()
    {
        $validation = \Config\Services::validation();
        $rules = [
            'id_user' => 'required|is_natural_no_zero',
            'email' => 'required|min_length[3]|max_length[255]',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $idUser = (int) $this->request->getPost('id_user');
        $email = $this->request->getPost('email');

        $existing = $this->ModelUser->where('email', $email)
            ->where('id_user !=', $idUser)
            ->first();

        if ($existing) {
            return redirect()->back()->withInput()->with('errors', ['email' => 'Email sudah terdaftar pada akun lain.']);
        }

        $this->ModelUser->update($idUser, ['email' => $email]);
        return redirect()->to(site_url('User'))->with('success', 'Email pengguna berhasil diperbarui.');
    }
}
