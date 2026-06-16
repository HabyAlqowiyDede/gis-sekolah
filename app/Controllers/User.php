<?php

namespace App\Controllers;

use App\Models\ProfilModel;

class User extends BaseController
{
    protected $profilModel;

    public function __construct()
    {
        $this->profilModel = new ProfilModel();
    }

    public function index()
    {
        $data = [
            'menu' => 'profil',
            'profil' => $this->profilModel->first() ?? [],
            'page' => 'profil/v_index',
        ];

        return view('v_template_back_end', $data);
    }

    public function edit()
    {
        $data = [
            'menu' => 'profil',
            'profil' => $this->profilModel->first() ?? [],
            'page' => 'profil/v_edit',
        ];

        return view('v_template_back_end', $data);
    }

    public function UpdateProfil()
    {
        $validation = \Config\Services::validation();

        $rules = [
            'nama_dinas' => 'required|min_length[5]',
            'logo' => 'if_exist|is_image[logo]|max_size[logo,2048]',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $id = 1;
        $dataProfil = [
            'nama_dinas' => $this->request->getPost('nama_dinas'),
            'kepala_dinas' => $this->request->getPost('kepala_dinas'),
            'nip_kepala' => $this->request->getPost('nip_kepala'),
            'alamat' => $this->request->getPost('alamat'),
            'telepon' => $this->request->getPost('telepon'),
            'email' => $this->request->getPost('email'),
            'website' => $this->request->getPost('website'),
        ];

        // Handle logo upload
        $logo = $this->request->getFile('logo');
        if ($logo && $logo->isValid() && !$logo->hasMoved()) {
            $oldProfil = $this->profilModel->find($id);

            // Delete old logo
            if ($oldProfil && !empty($oldProfil['logo'])) {
                $oldLogoPath = FCPATH . 'profil' . DIRECTORY_SEPARATOR . $oldProfil['logo'];
                if (file_exists($oldLogoPath)) {
                    unlink($oldLogoPath);
                }
            }

            // Upload new logo
            $newName = $logo->getRandomName();
            $logo->move(FCPATH . 'profil', $newName);
            $dataProfil['logo'] = $newName;
        }

        $existingProfil = $this->profilModel->find($id);

        if ($existingProfil) {
            $this->profilModel->update($id, $dataProfil);
            return redirect()->to('User')->with('success', 'Profil berhasil diperbarui');
        } else {
            $dataProfil['id_profil'] = $id;
            $this->profilModel->insert($dataProfil);
            return redirect()->to('User')->with('success', 'Profil berhasil disimpan');
        }
    }
}
