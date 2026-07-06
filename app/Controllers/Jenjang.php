<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\ModelJenjang;

class Jenjang extends BaseController
{
    protected $ModelJenjang;

    public function __construct()
    {
        session();
        $this->ModelJenjang = new ModelJenjang();
    }

    public function index()
    {
        $data = [   
            'menu' => 'jenjang',
            'page' => 'v_jenjang',
            'jenjang' => $this->ModelJenjang->AllData(),
        ];

        return view('admin/v_template_back_end', $data);
    }

    public function InsertData()
    {
        if (! $this->validate([
            'jenjang' => [
                'label' => 'Jenjang',
                'rules' => 'required|is_unique[tbl_jenjang.jenjang]',
                'errors' => [
                    'required' => '{field} wajib diisi.',
                    'is_unique' => '{field} sudah terdaftar.',
                ],
            ],
            'marker' => [
                'label' => 'Marker',
                'rules' => 'uploaded[marker]|is_image[marker]|max_size[marker,2048]|ext_in[marker,png,jpg,jpeg,webp]',
                'errors' => [
                    'uploaded' => '{field} wajib diunggah.',
                    'is_image' => '{field} harus berupa gambar.',
                    'max_size' => 'Ukuran {field} maksimal 2 MB.',
                    'ext_in' => 'Format {field} harus png, jpg, jpeg, atau webp.',
                ],
            ],
        ])) {
            session()->setFlashdata('errors', $this->validator->getErrors());
            return redirect()->to(site_url('Jenjang'))->withInput();
        }

        $markerName = $this->uploadMarker();

        $this->ModelJenjang->InsertData([
            'jenjang' => trim((string) $this->request->getPost('jenjang')),
            'marker' => $markerName,
        ]);

        session()->setFlashdata('Insert', 'Data jenjang berhasil ditambahkan.');
        return redirect()->to(site_url('Jenjang'));
    }

    public function UpdateData($id_jenjang)
    {
        $jenjang = $this->ModelJenjang->DetailData($id_jenjang);

        if (! $jenjang) {
            session()->setFlashdata('delete', 'Data jenjang tidak ditemukan.');
            return redirect()->to(site_url('Jenjang'));
        }

        $rules = [
            'jenjang' => [
                'label' => 'Jenjang',
                'rules' => 'required|is_unique[tbl_jenjang.jenjang,id_jenjang,' . $id_jenjang . ']',
                'errors' => [
                    'required' => '{field} wajib diisi.',
                    'is_unique' => '{field} sudah terdaftar.',
                ],
            ],
        ];

        $marker = $this->request->getFile('marker');
        if ($marker && $marker->getError() !== UPLOAD_ERR_NO_FILE) {
            $rules['marker'] = [
                'label' => 'Marker',
                'rules' => 'is_image[marker]|max_size[marker,2048]|ext_in[marker,png,jpg,jpeg,webp]',
                'errors' => [
                    'is_image' => '{field} harus berupa gambar.',
                    'max_size' => 'Ukuran {field} maksimal 2 MB.',
                    'ext_in' => 'Format {field} harus png, jpg, jpeg, atau webp.',
                ],
            ];
        }

        if (! $this->validate($rules)) {
            session()->setFlashdata('errors', $this->validator->getErrors());
            return redirect()->to(site_url('Jenjang'))->withInput();
        }

        $data = [
            'id_jenjang' => $id_jenjang,
            'jenjang' => trim((string) $this->request->getPost('jenjang')),
        ];

        if ($marker && $marker->getError() !== UPLOAD_ERR_NO_FILE) {
            $data['marker'] = $this->uploadMarker();
        }

        $this->ModelJenjang->UpdateData($data);
        session()->setFlashdata('Update', 'Data jenjang berhasil diperbarui.');
        return redirect()->to(site_url('Jenjang'));
    }

    public function DeleteData($id_jenjang)
    {
        $jenjang = $this->ModelJenjang->DetailData($id_jenjang);

        if (! $jenjang) {
            session()->setFlashdata('delete', 'Data jenjang tidak ditemukan.');
            return redirect()->to(site_url('Jenjang'));
        }

        $this->ModelJenjang->DeleteData(['id_jenjang' => $id_jenjang]);
        session()->setFlashdata('delete', 'Data jenjang berhasil dihapus.');
        return redirect()->to(site_url('Jenjang'));
    }

    private function uploadMarker(): string
    {
        $marker = $this->request->getFile('marker');
        $markerName = $marker->getRandomName();
        $uploadPath = FCPATH . 'marker';

        if (! is_dir($uploadPath)) {
            mkdir($uploadPath, 0775, true);
        }

        $marker->move($uploadPath, $markerName);

        return $markerName;
    }
}
