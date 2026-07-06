<?php

namespace App\Models;

use CodeIgniter\Model;

class ModelUser extends Model
{
    protected $table = 'tbl_user';
    protected $primaryKey = 'id_user';

    protected $allowedFields = [
        'id_sekolah',
        'nama_user',
        'email',
        'password',
        'role',
        'status',
        'created_at'
    ];

    public function InsertData($data)
    {
        return $this->db->table('tbl_user')->insert($data);
    }

    public function getByEmailOrUsername(string $login): ?array
    {
        $login = trim($login);

        if ($login === '') {
            return null;
        }

        $builder = $this->db->table($this->table);
        $builder->where('LOWER(email)', strtolower($login))
            ->orWhere('LOWER(nama_user)', strtolower($login))
            ->limit(1);

        $row = $builder->get()->getRowArray();

        return $row ?: null;
    }

    public function getUsersWithSchool(): array
    {
        return $this->db->table('tbl_user')
            ->select('tbl_user.id_user, tbl_user.id_sekolah, tbl_user.nama_user, tbl_user.email, tbl_user.role, tbl_user.status, tbl_sekolah.npsn')
            ->join('tbl_sekolah', 'tbl_user.id_sekolah = tbl_sekolah.id_sekolah', 'left')
            ->where('tbl_user.role !=', 'super_admin')
            ->orderBy('tbl_user.nama_user', 'ASC')
            ->get()
            ->getResultArray();
    }
}