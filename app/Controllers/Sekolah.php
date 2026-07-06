<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\ModelSetting;
use App\Models\ModelSekolah;
use App\Models\ModelJenjang;
use App\Models\ModelUser;
use App\Models\ModelGaleri;


class Sekolah extends BaseController
{
    protected $ModelSetting;
    protected $ModelSekolah;
    protected $ModelJenjang;
    protected $ModelUser;
    protected $ModelGaleri;

    public function __construct()
    {
        // Pastikan session aktif agar flashdata error terbaca
        session();
        $this->ModelSetting = new ModelSetting();
        $this->ModelSekolah = new ModelSekolah();
        $this->ModelJenjang = new ModelJenjang();
        $this->ModelUser = new ModelUser();
        $this->ModelGaleri = new ModelGaleri();
    }

    /**
     * Helper: Tentukan path view berdasarkan role user
     */
    private function getSekolahViewPath($filename)
    {
        if (isSuperAdmin()) {
            return "admin/superadmin/sekolah/{$filename}";
        } else {
            return "admin/operator/sekolah/{$filename}";
        }
    }

    public function UploadGaleri()
    {
        if ($this->request->getMethod() !== 'post') {
            return $this->response->setJSON(['status' => false, 'message' => 'Invalid request method']);
        }

        $id_sekolah = $this->request->getPost('id_sekolah') ?? (isAdminSekolah() ? getCurrentUserSchoolId() : null);
        if (! $id_sekolah) {
            return $this->response->setJSON(['status' => false, 'message' => 'ID sekolah tidak tersedia']);
        }

        // Authorization: hanya superadmin atau admin sekolah yang bersangkutan yang boleh mengunggah
        if (! (isSuperAdmin() || (isAdminSekolah() && getCurrentUserSchoolId() == $id_sekolah))) {
            return $this->response->setJSON(['status' => false, 'message' => 'Anda tidak memiliki izin untuk mengunggah foto untuk sekolah ini.']);
        }

        $files = $this->request->getFiles();
        if (empty($files)) {
            return $this->response->setJSON(['status' => false, 'message' => 'Tidak ada file yang diunggah']);
        }

        $saved = [];
        $allowed = ['jpg','jpeg','png','webp'];

        // Support both single and multiple file inputs
        $fileList = [];
        if (isset($files['foto']) && is_array($files['foto'])) {
            $fileList = $files['foto'];
        } elseif (isset($files['foto'])) {
            $fileList = [$files['foto']];
        } else {
            // fallback: try all files
            foreach ($files as $f) {
                if (is_array($f)) {
                    $fileList = array_merge($fileList, $f);
                } else {
                    $fileList[] = $f;
                }
            }
        }

        if (count($fileList) > 5) {
            return $this->response->setJSON(['status' => false, 'message' => 'Anda hanya dapat mengunggah maksimal 5 foto sekaligus.']);
        }

        $existingCount = $this->ModelGaleri->where('id_sekolah', $id_sekolah)->countAllResults();
        if ($existingCount >= 5) {
            return $this->response->setJSON(['status' => false, 'message' => 'Kuota galeri sudah penuh. Hapus foto terlebih dahulu untuk mengunggah lagi.']);
        }

        if ($existingCount + count($fileList) > 5) {
            $available = 5 - $existingCount;
            return $this->response->setJSON(['status' => false, 'message' => 'Anda hanya dapat mengunggah maksimal ' . $available . ' foto lagi.']);
        }

        foreach ($fileList as $file) {
            if (! $file->isValid()) continue;
            if ($file->getSize() > 2 * 1024 * 1024) continue;
            $ext = strtolower($file->getClientExtension());
            if (! in_array($ext, $allowed)) continue;

            $filename = $this->uploadFoto($file);

            $data = [
                'id_sekolah' => $id_sekolah,
                'foto' => $filename,
                'keterangan' => null,
                'created_at' => date('Y-m-d H:i:s'),
            ];

            $this->ModelGaleri->insert($data);
            $saved[] = $filename;
        }

        if (count($saved) > 0) {
            return $this->response->setJSON(['status' => true, 'message' => 'File berhasil diunggah', 'files' => $saved]);
        }

        return $this->response->setJSON(['status' => false, 'message' => 'Tidak ada file valid yang diunggah']);
    }

    public function galeri($id_sekolah = null)
    {
        if ($id_sekolah === null && isAdminSekolah()) {
            $id_sekolah = getCurrentUserSchoolId();
        }

        $galeri = [];
        $filterTitle = 'Galeri Sekolah';

        if ($id_sekolah) {
            $galeri = $this->ModelGaleri->where('id_sekolah', $id_sekolah)->orderBy('created_at', 'DESC')->findAll();
        } else {
            $galeri = $this->ModelGaleri->orderBy('created_at', 'DESC')->findAll();
            $filterTitle = 'Semua Galeri Sekolah';
        }

        $data = [
            'menu' => 'sekolah',
            'page' => $this->getSekolahViewPath('v_galeri'),
            'galeri' => $galeri,
            'filterTitle' => $filterTitle,
            'id_sekolah' => $id_sekolah,
        ];

        return view('admin/v_template_back_end', $data);
    }

    public function DeleteGaleri($id_galeri)
    {
        $galeri = $this->ModelGaleri->find($id_galeri);
        if (!$galeri) {
            session()->setFlashdata('delete', 'Foto galeri tidak ditemukan.');
            return redirect()->to(site_url('Sekolah/galeri'));
        }

        // Authorization: hanya superadmin atau admin sekolah pemilik foto yang boleh menghapus
        if (! (isSuperAdmin() || (isAdminSekolah() && getCurrentUserSchoolId() == $galeri['id_sekolah']))) {
            session()->setFlashdata('errors', ['access' => 'Anda tidak memiliki izin untuk menghapus foto ini.']);
            return redirect()->to(site_url('Sekolah/galeri'));
        }

        if (! empty($galeri['foto'])) {
            $path = FCPATH . 'foto/' . $galeri['foto'];
            if (is_file($path)) {
                unlink($path);
            }
        }

        $this->ModelGaleri->delete($id_galeri);
        session()->setFlashdata('Insert', 'Foto galeri berhasil dihapus.');
        return redirect()->to(site_url('Sekolah/galeri'));
    }

    public function index()
    {
        // Jika user adalah admin sekolah, hanya tampilkan data sekolahnya sendiri
        if (isAdminSekolah()) {
            $sekolahData = $this->ModelSekolah->DetailData(getCurrentUserSchoolId());
            $sekolahList = $sekolahData ? [$sekolahData] : [];
        } else {
            $sekolahList = $this->ModelSekolah->AllData();
        }

        $data = [
            'menu' => 'sekolah',
            'page' => $this->getSekolahViewPath('v_index'),
            'sekolah' => $sekolahList,
        ];
        return view('admin/v_template_back_end', $data);
    }

    public function input()
    {
        // Admin sekolah tidak dapat membuat sekolah baru
        if (isAdminSekolah()) {
            session()->setFlashdata('errors', ['access' => 'Admin sekolah tidak dapat membuat sekolah baru.']);
            return redirect()->to(site_url('Sekolah'));
        }

        $data = [
            'menu' => 'sekolah',
            'page' => $this->getSekolahViewPath('v_input'),
            'web' => $this->ModelSetting->DataWeb(),
            'kecamatan' => $this->ModelSekolah->allKecamatan(),
            'jenjang' => $this->ModelJenjang->AllData(),
        ];
        return view('admin/v_template_back_end', $data);
    }

    public function InsertData()
{
    if ($this->validate([
        'nama_sekolah' => [
            'label' => 'Nama Sekolah',
            'rules' => 'required'
        ],
        'npsn' => [
            'label' => 'NPSN',
            'rules' => 'required|is_unique[tbl_sekolah.npsn]'
        ],
        'id_jenjang' => [
            'label' => 'Jenjang',
            'rules' => 'required'
        ],
        'id_kecamatan' => [
            'label' => 'Kecamatan',
            'rules' => 'required'
        ],
    ])) {

        // Cek apakah email (NPSN) sudah dipakai
        $user = $this->ModelUser
            ->where('email', $this->request->getPost('npsn'))
            ->first();

        if ($user) {
            session()->setFlashdata('errors', [
                'npsn' => 'NPSN sudah digunakan sebagai akun operator.'
            ]);

            return redirect()->back()->withInput();
        }

        $selectedKecamatan = $this->ModelSekolah->getKecamatanDetail($this->request->getPost('id_kecamatan'));
        $idKabupaten = $selectedKecamatan['id_kabupaten'] ?? null;

        // Simpan sekolah
        $dataSekolah = [
            'nama_sekolah' => $this->request->getPost('nama_sekolah'),
            'npsn'         => $this->request->getPost('npsn'),
            'id_jenjang'   => $this->request->getPost('id_jenjang'),
            'id_kabupaten' => $idKabupaten,
            'id_kecamatan' => $this->request->getPost('id_kecamatan'),
            'id_nagari'    => null,
            'alamat'       => null,
            'foto'         => null,
            'status'       => null,
            'akreditasi'   => null,
            'coordinat'    => null,
        ];

        $this->ModelSekolah->InsertData($dataSekolah);

        // Ambil ID sekolah
        $idSekolah = $this->ModelSekolah->insertID();

        // Data akun admin sekolah
        // Nama akun dibuat tetap stabil, tidak ikut berubah saat nama sekolah diubah.
        $dataUser = [
            'id_sekolah' => $idSekolah,
            'nama_user'  => 'Admin Sekolah ' . $idSekolah,
            'email'      => $this->request->getPost('npsn'),
            'password'   => password_hash('123456', PASSWORD_DEFAULT),
            'role'       => 'admin',
            'status'     => 'aktif',
            'created_at' => date('Y-m-d H:i:s'),
        ];

        // Simpan akun admin
        $this->ModelUser->InsertData($dataUser);

        session()->setFlashdata('Insert', 'Data sekolah dan akun admin berhasil dibuat.');

        return redirect()->to(site_url('Sekolah'));

    } else {

        session()->setFlashdata('errors', \Config\Services::validation()->getErrors());

        return redirect()->to(site_url('Sekolah/Input'))->withInput();
    }
}
    public function edit($id_sekolah)
    {
        // Jika user adalah admin sekolah, hanya boleh edit sekolahnya sendiri
        if (isAdminSekolah() && getCurrentUserSchoolId() != $id_sekolah) {
            session()->setFlashdata('errors', ['access' => 'Anda hanya dapat mengubah data sekolah Anda sendiri.']);
            return redirect()->to(site_url('Sekolah'));
        }

        $sekolah = $this->ModelSekolah->DetailData($id_sekolah);
        
        // Ambil kecamatan berdasarkan kabupaten yang tersimpan
        $kecamatan = [];
        $nagari = [];
        if ($sekolah && $sekolah['id_kabupaten']) {
            $kecamatan = $this->ModelSekolah->allKecamatan($sekolah['id_kabupaten']);
        }
        // Ambil nagari berdasarkan kecamatan yang tersimpan
        if ($sekolah && $sekolah['id_kecamatan']) {
            $nagari = $this->ModelSekolah->allNagari($sekolah['id_kecamatan']);
        }

        $draftData = session()->get('school_form_draft') ?? session()->getFlashdata('school_form_draft') ?? [];
        if (!empty($draftData) && ($draftData['id_sekolah'] ?? null) == $id_sekolah) {
            $sekolah = array_merge($sekolah ?? [], $draftData);
        }

        $data = [
            'menu' => 'sekolah',
            'page' => $this->getSekolahViewPath('v_edit'),
            'web' => $this->ModelSetting->DataWeb(),
            'kabupaten' => $this->ModelSekolah->allKabupaten(),
            'kecamatan' => $kecamatan,
            'nagari' => $nagari,
            'jenjang' => $this->ModelJenjang->AllData(),
            'sekolah' => $sekolah,
            'formData' => $draftData,
        ];
        return view('admin/v_template_back_end', $data);
    }

    public function UpdateData($id_sekolah)
    {
        // Jika user adalah admin sekolah, hanya boleh update sekolahnya sendiri
        if (isAdminSekolah() && getCurrentUserSchoolId() != $id_sekolah) {
            session()->setFlashdata('errors', ['access' => 'Anda hanya dapat mengubah data sekolah Anda sendiri.']);
            return redirect()->to(site_url('Sekolah'));
        }

        $validationRules = [
            'nama_sekolah' => [
                'label' => 'Nama Sekolah',
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} tidak boleh kosong',
                ]
            ],
            'npsn' => [
                'label' => 'NPSN',
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} tidak boleh kosong',
                ]
            ],
            'id_jenjang' => [
                'label' => 'Jenjang',
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
        ];

        if (!isSuperAdmin()) {
            $validationRules['status'] = [
                'label' => 'Status',
                'rules' => 'required|in_list[Negeri,Swasta]',
                'errors' => [
                    'required' => '{field} tidak boleh kosong',
                    'in_list' => '{field} harus Negeri atau Swasta',
                ]
            ];
            $validationRules['akreditasi'] = [
                'label' => 'Akreditasi',
                'rules' => 'required|in_list[A,B,C,D]',
                'errors' => [
                    'required' => '{field} tidak boleh kosong',
                    'in_list' => '{field} harus A, B, C, atau D',
                ]
            ];
            $validationRules['coordinat'] = [
                'label' => 'Coordinat',
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} tidak boleh kosong',
                ]
            ];
            $validationRules['id_kabupaten'] = [
                'label' => 'Kabupaten',
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} tidak boleh kosong',
                ]
            ];
            $validationRules['id_nagari'] = [
                'label' => 'Nagari',
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} tidak boleh kosong',
                ]
            ];
            $validationRules['alamat'] = [
                'label' => 'Alamat',
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} tidak boleh kosong',
                ]
            ];
            // $validationRules['detail_kegiatan'] = [
            //     'label' => 'Detail Kegiatan',
            //     'rules' => 'permit_empty|string',
            //     'errors' => [
            //         'string' => '{field} harus berupa teks',
            //     ]
            // ];
            $validationRules['kontak_admin'] = [
                'label' => 'Kontak Admin',
                'rules' => 'permit_empty|string|max_length[50]',
                'errors' => [
                    'max_length' => '{field} maksimal 50 karakter',
                    'string' => '{field} harus berupa teks',
                ]
            ];
            $validationRules['banyak_guru'] = [
                'label' => 'Banyak Guru',
                'rules' => 'permit_empty|is_natural',
                'errors' => [
                    'is_natural' => '{field} harus berupa angka',
                ]
            ];
            $validationRules['visi'] = [
                'label' => 'Visi',
                'rules' => 'permit_empty|string',
                'errors' => [
                    'string' => '{field} harus berupa teks',
                ]
            ];
            $validationRules['misi'] = [
                'label' => 'Misi',
                'rules' => 'permit_empty|string',
                'errors' => [
                    'string' => '{field} harus berupa teks',
                ]
            ];
            $validationRules['foto'] = [
                'label' => 'Foto Sekolah',
                'rules' => 'permit_empty|is_image[foto]|max_size[foto,2048]|ext_in[foto,jpg,jpeg,png,webp]',
                'errors' => [
                    'is_image' => '{field} harus berupa gambar',
                    'max_size' => 'Ukuran {field} maksimal 2 MB',
                    'ext_in' => 'Format {field} harus jpg, jpeg, png, atau webp',
                ],
            ];
        }

        if ($this->validate($validationRules)) {
            $sekolah = $this->ModelSekolah->DetailData($id_sekolah);
            $foto = $this->request->getFile('foto');

            $nama_file_foto = $sekolah['foto'];

            // Jika ada file foto baru yang diunggah
            if ($foto && $foto->getError() == 0) {
                // Hapus foto lama jika ada
                if (!empty($sekolah['foto'])) {
                    $fotoLama = FCPATH . 'foto/' . $sekolah['foto'];
                    if (is_file($fotoLama)) {
                        unlink($fotoLama);
                    }
                }

                // Upload foto baru
                $nama_file_foto = $this->uploadFoto($foto);
            }

            # jika validasi berhasil
            $data = [
                'id_sekolah' => $id_sekolah,
                'nama_sekolah' => $this->request->getPost('nama_sekolah'),
                'npsn' => $this->request->getPost('npsn'),
                'id_jenjang' => $this->request->getPost('id_jenjang'),
                'id_kecamatan' => $this->request->getPost('id_kecamatan'),
                'foto' => $nama_file_foto,
            ];

            if (isSuperAdmin()) {
                $selectedKecamatan = $this->ModelSekolah->getKecamatanDetail($this->request->getPost('id_kecamatan'));
                $data['id_kabupaten'] = $selectedKecamatan['id_kabupaten'] ?? $sekolah['id_kabupaten'] ?? null;
                $data['status'] = $sekolah['status'] ?? null;
                $data['akreditasi'] = $sekolah['akreditasi'] ?? null;
                $data['coordinat'] = $sekolah['coordinat'] ?? null;
                $data['id_nagari'] = $sekolah['id_nagari'] ?? null;
                $data['alamat'] = $sekolah['alamat'] ?? null;
                $data['kontak_admin'] = $sekolah['kontak_admin'] ?? null;
                $data['banyak_guru'] = $sekolah['banyak_guru'] ?? null;
                $data['visi'] = $sekolah['visi'] ?? null;
                $data['misi'] = $sekolah['misi'] ?? null;
            } else {
                $data['status'] = $this->request->getPost('status');
                $data['akreditasi'] = $this->request->getPost('akreditasi');
                $data['coordinat'] = $this->request->getPost('coordinat');
                $data['id_kabupaten'] = $this->request->getPost('id_kabupaten');
                $data['id_nagari'] = $this->request->getPost('id_nagari');
                $data['alamat'] = $this->request->getPost('alamat');
                $data['kontak_admin'] = $this->request->getPost('kontak_admin');
                $data['banyak_guru'] = $this->request->getPost('banyak_guru') ? (int) $this->request->getPost('banyak_guru') : null;
                $data['visi'] = $this->request->getPost('visi');
                $data['misi'] = $this->request->getPost('misi');
            }
            $idSekolah = $data['id_sekolah'];
            unset($data['id_sekolah']);

            // Hanya update data sekolah. Akun operator/admin tetap dipertahankan
            // dan tidak ikut berubah saat nama sekolah diubah.
            $this->ModelSekolah->UpdateData($idSekolah, $data);
            session()->remove('school_form_draft');
            session()->setFlashdata('Update', 'Data sekolah berhasil diperbarui.');
            return redirect()->to(site_url('Sekolah'));
        } else {
            // jika validasi gagal
            $draftData = $this->request->getPost();
            $draftData['id_sekolah'] = $id_sekolah;
            session()->set('school_form_draft', $draftData);
            session()->setFlashdata('errors', \Config\Services::validation()->getErrors());
            return redirect()->to(site_url('Sekolah/edit/' . $id_sekolah))->withInput('validation', \Config\Services::validation()->getErrors());
        }
    }

    public function saveDraft($id_sekolah)
    {
        if ($this->request->getMethod() !== 'post') {
            return $this->response->setJSON(['status' => false, 'message' => 'Invalid request method']);
        }

        if (isAdminSekolah() && getCurrentUserSchoolId() != $id_sekolah) {
            return $this->response->setJSON(['status' => false, 'message' => 'Akses ditolak']);
        }

        $draftData = $this->request->getPost();
        $draftData['id_sekolah'] = $id_sekolah;
        session()->set('school_form_draft', $draftData);

        return $this->response->setJSON(['status' => true]);
    }

    public function kecamatan()
    {
        $id_kabupaten = $this->request->getPost('id_kabupaten');
        $selectedIdKecamatan = $this->request->getPost('selected_id_kecamatan');
        if (!$id_kabupaten) {
            echo '<option value="">--Pilih kecamatan--</option>';
            return;
        }
        
        $kecamatan = $this->ModelSekolah->allKecamatan($id_kabupaten);
        echo '<option value="">--Pilih kecamatan--</option>';
        foreach ($kecamatan as $value) {
            $selected = ($selectedIdKecamatan !== null && (string) $selectedIdKecamatan === (string) $value['id_kecamatan']) ? 'selected' : '';
            echo '<option value="' . esc($value['id_kecamatan']) . '" ' . $selected . '>' . esc($value['nama_kecamatan']) . '</option>';
        }
    }

    public function nagari()
    {
        $id_kecamatan = $this->request->getPost('id_kecamatan');
        $selectedIdNagari = $this->request->getPost('selected_id_nagari');
        if (!$id_kecamatan) {
            echo '<option value="">--Pilih Nagari--</option>';
            return;
        }
        
        $nagari = $this->ModelSekolah->allNagari($id_kecamatan);
        echo '<option value="">--Pilih Nagari--</option>';
        foreach ($nagari as $value) {
            $selected = ($selectedIdNagari !== null && (string) $selectedIdNagari === (string) $value['id_nagari']) ? 'selected' : '';
            echo '<option value="' . esc($value['id_nagari']) . '" ' . $selected . '>' . esc($value['nama_nagari']) . '</option>';
        }
    }

    public function Delete($id_sekolah)
    {
        // Jika user adalah admin sekolah, hanya boleh delete sekolahnya sendiri
        if (isAdminSekolah() && getCurrentUserSchoolId() != $id_sekolah) {
            session()->setFlashdata('errors', ['access' => 'Anda hanya dapat menghapus data sekolah Anda sendiri.']);
            return redirect()->to(site_url('Sekolah'));
        }

        $sekolah = $this->ModelSekolah->DetailData($id_sekolah);

        if (!$sekolah) {
            session()->setFlashdata('delete', 'Data sekolah tidak ditemukan.');
            return redirect()->to(site_url('Sekolah'));
        }

        $data = [
            'judul' => 'Hapus Sekolah',
            'menu' => 'sekolah',
            'page' => $this->getSekolahViewPath('v_delete'),
            'sekolah' => $sekolah,
        ];

        return view('admin/v_template_back_end', $data);
    }

    public function DeleteData($id_sekolah)
    {
        // Jika user adalah admin sekolah, hanya boleh delete sekolahnya sendiri
        if (isAdminSekolah() && getCurrentUserSchoolId() != $id_sekolah) {
            session()->setFlashdata('errors', ['access' => 'Anda hanya dapat menghapus data sekolah Anda sendiri.']);
            return redirect()->to(site_url('Sekolah'));
        }

        $sekolah = $this->ModelSekolah->DetailData($id_sekolah);

        if (!$sekolah) {
            session()->setFlashdata('delete', 'Data sekolah tidak ditemukan.');
            return redirect()->to(site_url('Sekolah'));
        }

        $this->ModelSekolah->DeleteData($id_sekolah);

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
