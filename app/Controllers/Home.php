<?php

namespace App\Controllers;

use App\Models\ModelSetting;
use App\Models\ModelSekolah;
use App\Models\ModelWilayah;

class Home extends BaseController
{
    protected $ModelSetting;
    protected $ModelSekolah;
    protected $ModelWilayah;

    public function __construct()
    {
        session();
        $this->ModelSetting = new ModelSetting();
        $this->ModelSekolah = new ModelSekolah();
        $this->ModelWilayah = new ModelWilayah();
    }
    
    public function index()
    {
        $data = $this->landingData('Beranda', 'beranda');
        return view('v_template_front_end', $data);
    }

    public function beranda()
    {
        $data = $this->landingData('Beranda', 'beranda');
        return view('v_template_front_end', $data);
    }

    public function peta()
    {
        $data = $this->landingData('Peta Sekolah', 'peta');
        return view('v_template_front_end', $data);
    }

    public function datasekolah()
    {
        $data = $this->landingData('Sekolah', 'datasekolah');
        return view('v_template_front_end', $data);
    }

    public function pemetaansekolah()
    {
        return $this->datasekolah();
    }

    public function tentang()
    {
        $data = $this->landingData('Tentang', 'tentang');
        return view('v_template_front_end', $data);
    }

    private function landingData(string $judul, string $page): array
    {
        $sekolah = $this->ModelSekolah->AllData();
        $kecamatan = array_filter(array_unique(array_map(static function ($item) {
            return $item['nama_kecamatan'] ?? $item['kecamatan'] ?? '';
        }, $sekolah)));

        return [
            'judul' => $judul,
            'page' => 'landing_page/' . $page,
            'web' => $this->ModelSetting->DataWeb(),
            'sekolah' => $sekolah,
            'wilayah' => $this->ModelWilayah->AllData(),
            'totalSekolah' => count($sekolah),
            'totalKecamatan' => count($kecamatan),
        ];
    }
}
