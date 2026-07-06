<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\ModelWilayah;
use App\Models\ModelSetting;

class Wilayah extends BaseController
{
    protected $ModelWilayah;
    protected $ModelSetting;

    public function __construct()
    {
        // Pastikan session aktif agar flashdata error terbaca
        session(); 
        $this->ModelWilayah = new ModelWilayah();
        $this->ModelSetting = new ModelSetting();
    }

    public function index()
    {
        $data = [
            'menu' => 'wilayah',
            'page' => 'admin/superadmin/wilayah/v_index',
            'wilayah' => $this->ModelWilayah->AllData(),
            'web' => $this->ModelSetting->DataWeb(),
        ];
        return view('admin/v_template_back_end', $data);
    }

    public function input()
    {
        $data = [
            'menu' => 'wilayah',
            'page' => 'admin/superadmin/wilayah/v_input',
        ];
        return view('admin/v_template_back_end', $data);
    }

    public function InsertData()
    {
        if ($this->validate([
            'nama_wilayah' => [
                'label' => 'Nama Wilayah',
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} tidak boleh kosong',
                ]
            ],
            'geojson' => [
                'label' => 'Geojson',
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} tidak boleh kosong',
                ]
            ],
            'warna' => [
                'label' => 'Warna',
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} tidak boleh kosong',
                ]
            ],
        ])) {
            # jika validasi berhasil
            $data = [
                'nama_wilayah' => $this->request->getPost('nama_wilayah'),
                'geojson' => $this->request->getPost('geojson'),
                'warna' => $this->request->getPost('warna'),
            ];
            $this->ModelWilayah->InsertData($data);
            session()->setFlashdata('Insert', 'Data berhasil disimpan');
            return redirect()->to('Wilayah');
        } else {
            // jika validasi gagal
            session()->setFlashdata('errors', \Config\Services::validation()->getErrors());
            return redirect()->to('Wilayah/input')->withInput();
        }
    }

    public function Edit($id_wilayah)
    {
        $data = [
            'menu' => 'wilayah',
            'page' => 'admin/superadmin/wilayah/v_edit',
            'wilayah' => $this->ModelWilayah->DetailData($id_wilayah),
            'web' => $this->ModelSetting->DataWeb(), // Ditambahkan agar template tidak error kekurangan data web
        ];
        return view('admin/v_template_back_end', $data);
    }

    // PERBAIKAN: Menambahkan parameter $id_wilayah agar sistem tahu data mana yang sedang di-update
    public function UpdateData($id_wilayah)
    {
        if ($this->validate([
            'nama_wilayah' => [
                'label' => 'Nama Wilayah',
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} tidak boleh kosong',
                ]
            ],
            'geojson' => [
                'label' => 'Geojson',
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} tidak boleh kosong',
                ]
            ],
            'warna' => [
                'label' => 'Warna',
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} tidak boleh kosong',
                ]
            ],
        ])) {
            # jika validasi berhasil
            $data = [
                'id_wilayah' => $id_wilayah, // Sekarang $id_wilayah sudah aman terdefinisi dari parameter
                'nama_wilayah' => $this->request->getPost('nama_wilayah'),
                'geojson' => $this->request->getPost('geojson'),
                'warna' => $this->request->getPost('warna'),
            ];
            $this->ModelWilayah->UpdateData($data);
            session()->setFlashdata('Update', 'Data berhasil diUpdate');
            return redirect()->to('Wilayah');
        } else {
            // jika validasi gagal
            session()->setFlashdata('errors', \Config\Services::validation()->getErrors());
            // PERBAIKAN: Redirect dikembalikan ke halaman Edit wilayah tersebut, bukan ke halaman input baru
            return redirect()->to('Wilayah/Edit/' . $id_wilayah)->withInput('validation', \Config\Services::validation()->getErrors()) ;
        }
    }

    public function Delete($id_wilayah)
    {
        $data = [
                'id_wilayah' => $id_wilayah, // Sekarang $id_wilayah sudah aman terdefinisi dari parameter
            ];
            $this->ModelWilayah->DeleteData($data);
            session()->setFlashdata('delete', 'Data berhasil diDelete !!.');
            return redirect()->to('Wilayah');
    }
}