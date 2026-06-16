<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\ModelSetting;
use App\Models\ModelSekolah;
use App\Models\ModelJenjang;


class Sekolah extends BaseController
{
    protected $ModelSetting;
    protected $ModelSekolah;
    protected $ModelJenjang;

    public function __construct()
    {
        // Pastikan session aktif agar flashdata error terbaca
        session();
        $this->ModelSetting = new ModelSetting();
        $this->ModelSekolah = new ModelSekolah();
        $this->ModelJenjang = new ModelJenjang();
    }
    public function index()
    {
        $data = [
            'menu' => 'sekolah',
            'page' => 'sekolah/v_index',
            'sekolah' => $this->ModelSekolah->AllData(),
        ];
        return view('v_template_back_end', $data);
    }

    public function input()
    {
        $data = [
            'menu' => 'sekolah',
            'page' => 'sekolah/v_input',
            'web' => $this->ModelSetting->DataWeb(),
            'kabupaten' => $this->ModelSekolah->allKabupaten(),
            'jenjang' => $this->ModelJenjang->AllData(),
        ];
        return view('v_template_back_end', $data);
    }

    public function InsertData()
    {
        if ($this->validate([
            'nama_sekolah' => [
                'label' => 'Nama Sekolah',
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} tidak boleh kosong',
                ]
            ],
            'status' => [
                'label' => 'Status',
                'rules' => 'required|in_list[Negeri,Swasta]',
                'errors' => [
                    'required' => '{field} tidak boleh kosong',
                    'in_list' => '{field} harus Negeri atau Swasta',
                ]
            ],
            'akreditasi' => [
                'label' => 'Akreditasi',
                'rules' => 'required|in_list[A,B,C,D]',
                'errors' => [
                    'required' => '{field} tidak boleh kosong',
                    'in_list' => '{field} harus A, B, C, atau D',
                ]
            ],
            'id_jenjang' => [
                'label' => 'Jenjang',
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} tidak boleh kosong',
                ]
            ],
            'coordinat' => [
                'label' => 'Coordinat',
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} tidak boleh kosong',
                ]
            ],
            'id_kabupaten' => [
                'label' => 'Kabupaten',
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} tidak boleh kosong',
                ]
            ],
            'id_kecamatan' => [
                'label' => 'Kecamatan',
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} tidak boleh kosong',
                ]
            ],
            'id_nagari' => [
                'label' => 'Nagari',
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} tidak boleh kosong',
                ]
            ],
            'alamat' => [
                'label' => 'Alamat',
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} tidak boleh kosong',
                ]
            ],
            'foto' => [
                'label' => 'Foto Sekolah',
                'rules' => 'uploaded[foto]|is_image[foto]|max_size[foto,2048]|ext_in[foto,jpg,jpeg,png,webp]',
                'errors' => [
                    'uploaded' => '{field} tidak boleh kosong',
                    'is_image' => '{field} harus berupa gambar',
                    'max_size' => 'Ukuran {field} maksimal 2 MB',
                    'ext_in' => 'Format {field} harus jpg, jpeg, png, atau webp',
                ]
            ],
        ])) {
            $foto = $this->request->getFile('foto');
            $nama_file_foto = $this->uploadFoto($foto);
            # jika validasi berhasil
            $data = [
                'nama_sekolah' => $this->request->getPost('nama_sekolah'),
                'status' => $this->request->getPost('status'),
                'akreditasi' => $this->request->getPost('akreditasi'),
                'id_jenjang' => $this->request->getPost('id_jenjang'),
                'coordinat' => $this->request->getPost('coordinat'),
                'id_kabupaten' => $this->request->getPost('id_kabupaten'),
                'id_kecamatan' => $this->request->getPost('id_kecamatan'),
                'id_nagari' => $this->request->getPost('id_nagari'),
                'alamat' => $this->request->getPost('alamat'),
                'foto' => $nama_file_foto,

            ];
            $this->ModelSekolah->InsertData($data);
            session()->setFlashdata('Insert', 'Data sekolah berhasil ditambahkan.');
            return redirect()->to(site_url('Sekolah'));
        } else {
            // jika validasi gagal
            session()->setFlashdata('errors', \Config\Services::validation()->getErrors());
            // PERBAIKAN: Redirect dikembalikan ke halaman Edit wilayah tersebut, bukan ke halaman input baru
            return redirect()->to(site_url('Sekolah/Input'))->withInput('validation', \Config\Services::validation()->getErrors());
        }
    }

    public function edit($id_sekolah)
    {
        $data = [

            'menu' => 'sekolah',
            'page' => 'sekolah/v_edit',
            'web' => $this->ModelSetting->DataWeb(),
            'kabupaten' => $this->ModelSekolah->allKabupaten(),
            'jenjang' => $this->ModelJenjang->AllData(),
            'sekolah' => $this->ModelSekolah->DetailData($id_sekolah),
        ];
        return view('v_template_back_end', $data);
    }

    public function UpdateData($id_sekolah)
    {
        if ($this->validate([
            'nama_sekolah' => [
                'label' => 'Nama Sekolah',
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} tidak boleh kosong',
                ]
            ],
            'status' => [
                'label' => 'Status',
                'rules' => 'required|in_list[Negeri,Swasta]',
                'errors' => [
                    'required' => '{field} tidak boleh kosong',
                    'in_list' => '{field} harus Negeri atau Swasta',
                ]
            ],
            'akreditasi' => [
                'label' => 'Akreditasi',
                'rules' => 'required|in_list[A,B,C,D]',
                'errors' => [
                    'required' => '{field} tidak boleh kosong',
                    'in_list' => '{field} harus A, B, C, atau D',
                ]
            ],
            'id_jenjang' => [
                'label' => 'Jenjang',
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} tidak boleh kosong',
                ]
            ],
            'coordinat' => [
                'label' => 'Coordinat',
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} tidak boleh kosong',
                ]
            ],
            'id_kabupaten' => [
                'label' => 'Kabupaten',
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} tidak boleh kosong',
                ]
            ],
            'id_kecamatan' => [
                'label' => 'Kecamatan',
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} tidak boleh kosong',
                ]
            ],
            'id_nagari' => [
                'label' => 'Nagari',
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} tidak boleh kosong',
                ]
            ],
            'alamat' => [
                'label' => 'Alamat',
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} tidak boleh kosong',
                ]
            ],

        ])) {
            $sekolah = $this->ModelSekolah->DetailData($id_sekolah);
            $foto = $this->request->getFile('foto');

            if ($foto->getError() == 4) {
                $nama_file_foto = $sekolah['foto'];
            } else {
                if (! $this->validate([
                    'foto' => [
                        'label' => 'Foto Sekolah',
                        'rules' => 'is_image[foto]|max_size[foto,2048]|ext_in[foto,jpg,jpeg,png,webp]',
                        'errors' => [
                            'is_image' => '{field} harus berupa gambar',
                            'max_size' => 'Ukuran {field} maksimal 2 MB',
                            'ext_in' => 'Format {field} harus jpg, jpeg, png, atau webp',
                        ],
                    ],
                ])) {
                    session()->setFlashdata('errors', \Config\Services::validation()->getErrors());
                    return redirect()->to(site_url('Sekolah/edit/' . $id_sekolah))->withInput();
                }

                $nama_file_foto = $this->uploadFoto($foto);
            }
            # jika validasi berhasil
            $data = [
                'id_sekolah' => $id_sekolah,
                'nama_sekolah' => $this->request->getPost('nama_sekolah'),
                'status' => $this->request->getPost('status'),
                'akreditasi' => $this->request->getPost('akreditasi'),
                'id_jenjang' => $this->request->getPost('id_jenjang'),
                'coordinat' => $this->request->getPost('coordinat'),
                'id_kabupaten' => $this->request->getPost('id_kabupaten'),
                'id_kecamatan' => $this->request->getPost('id_kecamatan'),
                'id_nagari' => $this->request->getPost('id_nagari'),
                'alamat' => $this->request->getPost('alamat'),
                'foto' => $nama_file_foto,

            ];
            $this->ModelSekolah->UpdateData($data);
            session()->setFlashdata('Update', 'Data sekolah berhasil diperbarui.');
            return redirect()->to(site_url('Sekolah'));
        } else {
            // jika validasi gagal
            session()->setFlashdata('errors', \Config\Services::validation()->getErrors());
            // PERBAIKAN: Redirect dikembalikan ke halaman Edit wilayah tersebut, bukan ke halaman input baru
            return redirect()->to(site_url('Sekolah/edit/' . $id_sekolah))->withInput('validation', \Config\Services::validation()->getErrors());
        }
    }

    public function kecamatan()
    {
        $id_kabupaten = $this->request->getPost('id_kabupaten');
        $kab = $this->ModelSekolah->allKecamatan($id_kabupaten);
        echo ' <option value="">--Pilih kecamatan--</option> ';
        foreach ($kab as $key => $value) {
            echo '<option value=' . $value['id_kecamatan'] . '>' . $value['nama_kecamatan'] . '</option>';
        }
    }

    public function nagari()
    {
        $id_kecamatan = $this->request->getPost('id_kecamatan');
        $kab = $this->ModelSekolah->allNagari($id_kecamatan);
        echo ' <option value="">--Pilih Nagari--</option> ';
        foreach ($kab as $key => $value) {
            echo '<option value=' . $value['id_nagari'] . '>' . $value['nama_nagari'] . '</option>';
        }
    }

    public function Delete($id_sekolah)
    {
        $sekolah = $this->ModelSekolah->DetailData($id_sekolah);

        if (!$sekolah) {
            session()->setFlashdata('delete', 'Data sekolah tidak ditemukan.');
            return redirect()->to(site_url('Sekolah'));
        }

        $data = [
            'judul' => 'Hapus Sekolah',
            'menu' => 'sekolah',
            'page' => 'sekolah/v_delete',
            'sekolah' => $sekolah,
        ];

        return view('v_template_back_end', $data);
    }

    public function DeleteData($id_sekolah)
    {
        $sekolah = $this->ModelSekolah->DetailData($id_sekolah);

        if (!$sekolah) {
            session()->setFlashdata('delete', 'Data sekolah tidak ditemukan.');
            return redirect()->to(site_url('Sekolah'));
        }

        $data = [
            'id_sekolah' => $id_sekolah,
        ];

        $this->ModelSekolah->DeleteData($data);

        if (!empty($sekolah['foto'])) {
            $foto = FCPATH . 'foto/' . $sekolah['foto'];

            if (is_file($foto)) {
                unlink($foto);
            }
        }

        session()->setFlashdata('delete', 'Data sekolah berhasil dihapus.');
        return redirect()->to(site_url('Sekolah'));
    }

    private function uploadFoto($foto): string
    {
        $nama_file_foto = $foto->getRandomName();
        $uploadPath = FCPATH . 'foto';

        if (! is_dir($uploadPath)) {
            mkdir($uploadPath, 0775, true);
        }

        $foto->move($uploadPath, $nama_file_foto);

        return $nama_file_foto;
    }
}
