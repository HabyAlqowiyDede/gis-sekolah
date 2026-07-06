<?php

namespace App\Controllers;

use App\Models\ModelSetting;
use App\Models\ModelSekolah;
use App\Models\ModelWilayah;
use App\Models\ModelGaleri;

class Home extends BaseController
{
    protected $ModelSetting;
    protected $ModelSekolah;
    protected $ModelWilayah;
    protected $ModelGaleri;
    public function __construct()
    {
        session();
        $this->ModelSetting = new ModelSetting();
        $this->ModelSekolah = new ModelSekolah();
        $this->ModelWilayah = new ModelWilayah();
        $this->ModelGaleri = new ModelGaleri();
    }

    public function index()
    {
        $data = $this->landingData('Beranda', 'beranda');
        return view('user/v_template_front_end', $data);
    }

    public function beranda()
    {
        $data = $this->landingData('Beranda', 'beranda');
        return view('user/v_template_front_end', $data);
    }

    public function peta()
    {
        $data = $this->landingData('Peta Sekolah', 'peta');
        return view('user/v_template_front_end', $data);
    }

    public function datasekolah()
    {
        $data = $this->landingData('Sekolah', 'datasekolah');
        return view('user/v_template_front_end', $data);
    }

    public function sekolah($id_sekolah)
    {
        $data = $this->landingData('Detail Sekolah', 'sekolah_detail');

        $data['sekolah'] = $this->ModelSekolah->DetailData($id_sekolah);

        $data['galeri'] = $this->ModelGaleri
            ->where('id_sekolah', $id_sekolah)
            ->orderBy('created_at', 'DESC')
            ->findAll();

        return view('user/v_template_front_end', $data);
    }
    public function pemetaansekolah()
    {
        return $this->datasekolah();
    }

    /**
     * AJAX endpoint untuk mendapatkan detail sekolah lengkap
     */
    public function detailSekolahAjax()
    {
        if (!$this->request->isAJAX()) {
            return $this->response->setStatusCode(403)->setJSON(['error' => 'Forbidden']);
        }

        $id_sekolah = $this->request->getPost('id_sekolah');

        if (!$id_sekolah) {
            return $this->response->setStatusCode(400)->setJSON(['error' => 'ID sekolah tidak ditemukan']);
        }
        $sekolah = $this->ModelSekolah->DetailData($id_sekolah);

        if (!$sekolah) {
            return $this->response->setStatusCode(404)->setJSON(['error' => 'Sekolah tidak ditemukan']);
        }
        // Ambil galeri sekolah
        $galeri = $this->ModelGaleri
            ->where('id_sekolah', $id_sekolah)
            ->findAll();

        // Siapkan data untuk response
        $response = [
            'id_sekolah' => $sekolah['id_sekolah'] ?? '',
            'nama_sekolah' => $sekolah['nama_sekolah'] ?? '-',
            'npsn' => $sekolah['npsn'] ?? '-',
            'jenjang' => $sekolah['jenjang'] ?? '-',
            'status' => $sekolah['status'] ?? '-',
            'akreditasi' => strtoupper($sekolah['akreditasi'] ?? '-'),
            'nama_kabupaten' => $sekolah['nama_kabupaten'] ?? '-',
            'nama_kecamatan' => $sekolah['nama_kecamatan'] ?? '-',
            'nama_nagari' => $sekolah['nama_nagari'] ?? '-',
            'alamat' => $sekolah['alamat'] ?? '-',
            'visi' => $sekolah['visi'] ?? '-',
            'misi' => $sekolah['misi'] ?? '-',
            'detail_kegiatan' => $sekolah['detail_kegiatan'] ?? '-',
            'kontak_admin' => $sekolah['kontak_admin'] ?? '-',
            'banyak_guru' => $sekolah['banyak_guru'] ?? '-',
            'foto' => $sekolah['foto'] ?? null,
            'galeri' => $galeri
        ];

        return $this->response->setJSON($response);
    }

    public function tentang()
    {
        $data = $this->landingData('Tentang', 'tentang');
        return view('user/v_template_front_end', $data);
    }

    private function landingData(string $judul, string $page): array
    {
        return [
            'judul' => $judul,
            'page' => 'landing_page/landing_page/' . $page,
            'web' => $this->ModelSetting->DataWeb(),
            'sekolah' => $this->ModelSekolah->AllData(),
            'wilayah' => $this->ModelWilayah->AllData(),
        ];
    }
}
