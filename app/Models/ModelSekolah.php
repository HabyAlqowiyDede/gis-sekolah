<?php

namespace App\Models;

use CodeIgniter\Model;


class ModelSekolah extends Model
{
    public function AllData()
    {
        return $this->db->table('tbl_sekolah')
            ->select('tbl_sekolah.*, tbl_jenjang.jenjang, tbl_jenjang.marker, tbl_kabupaten.nama_kabupaten, tbl_kecamatan.nama_kecamatan, tbl_nagari.nama_nagari')
            ->join('tbl_jenjang', 'tbl_sekolah.id_jenjang = tbl_jenjang.id_jenjang', 'left')
            ->join('tbl_kabupaten', 'tbl_sekolah.id_kabupaten = tbl_kabupaten.id_kabupaten', 'left')
            ->join('tbl_kecamatan', 'tbl_sekolah.id_kecamatan = tbl_kecamatan.id_kecamatan', 'left')
            ->join('tbl_nagari', 'tbl_sekolah.id_nagari = tbl_nagari.id_nagari', 'left')
            ->get()->getResultArray();
    }

    public function InsertData($data)
    {
        $this->db->table('tbl_sekolah')->insert($data);
    }

    public function insertID()
    {
        return $this->db->insertID();
    }

    public function DetailData($id_sekolah)
    {
        return $this->db->table('tbl_sekolah')
            ->join('tbl_jenjang', 'tbl_sekolah.id_jenjang = tbl_jenjang.id_jenjang', 'left')
            ->join('tbl_kabupaten', 'tbl_sekolah.id_kabupaten = tbl_kabupaten.id_kabupaten', 'left')
            ->join('tbl_kecamatan', 'tbl_sekolah.id_kecamatan = tbl_kecamatan.id_kecamatan', 'left')
            ->join('tbl_nagari', 'tbl_sekolah.id_nagari = tbl_nagari.id_nagari', 'left')
            ->where('tbl_sekolah.id_sekolah', $id_sekolah)
            ->get()->getRowArray();
    }

    public function UpdateData($id_sekolah, array $data)
    {
        return $this->db->table('tbl_sekolah')
            ->where('id_sekolah', $id_sekolah)
            ->update($data);
    }

    public function DeleteData($id_sekolah)
    {
        return $this->db->table('tbl_sekolah')
            ->where('id_sekolah', $id_sekolah)
            ->delete();
    }

    public function allKabupaten()
    {
        return $this->db->table('tbl_kabupaten')
            ->orderBy('id_provinsi', 'ASC')
            ->get()->getResultArray();
    }

    public function allKecamatan($id_kabupaten = null)
    {
        $builder = $this->db->table('tbl_kecamatan');
        $builder->select('tbl_kecamatan.*, tbl_kabupaten.nama_kabupaten')
            ->join('tbl_kabupaten', 'tbl_kabupaten.id_kabupaten = tbl_kecamatan.id_kabupaten', 'left');

        if ($id_kabupaten !== null && $id_kabupaten !== '') {
            $builder->where('tbl_kecamatan.id_kabupaten', $id_kabupaten);
        } else {
            $builder->groupStart()
                ->where('LOWER(tbl_kabupaten.nama_kabupaten) LIKE', '%tanah datar%')
                ->orWhere('LOWER(tbl_kabupaten.nama_kabupaten) LIKE', '%tanahdatar%')
                ->groupEnd();
        }

        $result = $builder->orderBy('tbl_kecamatan.nama_kecamatan', 'ASC')->get()->getResultArray();

        if (empty($result)) {
            $fallback = $this->db->table('tbl_kecamatan');
            return $fallback->orderBy('nama_kecamatan', 'ASC')->get()->getResultArray();
        }

        return $result;
    }

    public function getKecamatanDetail($id_kecamatan)
    {
        return $this->db->table('tbl_kecamatan')
            ->where('id_kecamatan', $id_kecamatan)
            ->get()->getRowArray();
    }

    public function allNagari($id_kecamatan)
    {
        return $this->db->table('tbl_nagari')
            ->where('id_kecamatan', $id_kecamatan)
            ->get()->getResultArray();
    }
    public function JumlahSekolah()
    {
        return $this->db->table('tbl_sekolah')->countAllResults();
    }
    public function JumlahSD()
    {
        return $this->db->table('tbl_sekolah')
            ->where('id_jenjang', 1)
            ->countAllResults();
    }

    public function JumlahSMP()
    {
        return $this->db->table('tbl_sekolah')
            ->where('id_jenjang', 2)
            ->countAllResults();
    }
       public function JumlahTK()
    {
        return $this->db->table('tbl_sekolah')
            ->where('id_jenjang', 2)
            ->countAllResults();
    }
}
