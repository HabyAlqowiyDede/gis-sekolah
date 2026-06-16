<?php

namespace App\Models;

use CodeIgniter\Model;


class ModelSekolah extends Model
{
    public function AllData()
    {
        return $this->db->table('tbl_Sekolah')
                ->select('tbl_sekolah.*, tbl_jenjang.jenjang, tbl_jenjang.marker, tbl_kabupaten.nama_kabupaten, tbl_kecamatan.nama_kecamatan, tbl_nagari.nama_nagari')
                ->join('tbl_jenjang', 'tbl_sekolah.id_jenjang = tbl_jenjang.id_jenjang', 'left' )
                ->join('tbl_kabupaten', 'tbl_kabupaten.id_kabupaten = tbl_sekolah.id_kabupaten', 'left' )
                ->join('tbl_kecamatan', 'tbl_kecamatan.id_kecamatan = tbl_sekolah.id_kecamatan', 'left' )
                ->join('tbl_nagari', 'tbl_nagari.id_nagari = tbl_sekolah.id_nagari', 'left' )
                ->get()->getResultArray();
    }

    public function InsertData($data)
    {
        $this->db->table('tbl_Sekolah')->insert($data);
    }

    public function DetailData($id_sekolah)
    {
        return $this->db->table('tbl_Sekolah')
            ->join('tbl_jenjang', 'tbl_sekolah.id_jenjang = tbl_jenjang.id_jenjang', 'left' )
            ->join('tbl_kabupaten', 'tbl_kabupaten.id_kabupaten = tbl_sekolah.id_kabupaten', 'left' )
            ->join('tbl_kecamatan', 'tbl_kecamatan.id_kecamatan = tbl_sekolah.id_kecamatan', 'left' )
            ->join('tbl_nagari', 'tbl_nagari.id_nagari = tbl_sekolah.id_nagari', 'left' )
            ->where('id_Sekolah', $id_sekolah)
            ->get()->getRowArray();
    }

    public function UpdateData($data)
    {
        return $this->db->table('tbl_sekolah')
            ->where('id_sekolah', $data['id_sekolah'])
            ->update($data);
    }

    public function DeleteData($data)
    {
        return $this->db->table('tbl_Sekolah')
            ->where('id_sekolah', $data['id_sekolah'])
            ->delete($data);
    }

    public function allKabupaten()
    {
        return $this->db->table('tbl_kabupaten')
            ->orderBy('id_provinsi', 'ASC')
            ->get()->getResultArray();
    }

    public function allkecamatan($id_kabupaten)
    {
        return $this->db->table('tbl_kecamatan')
            ->where('id_kabupaten', $id_kabupaten)
            ->get()->getResultArray();
    }

    public function allNagari($id_kecamatan)
    {
        return $this->db->table('tbl_nagari')
            ->where('id_kecamatan', $id_kecamatan)
            ->get()->getResultArray();
    }    
}
