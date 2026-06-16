<?php

namespace App\Models;

use CodeIgniter\Model;

class ProfilModel extends Model
{
    protected $table = 'profil';
    protected $primaryKey = 'id_profil';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $useSoftDeletes = false;
    protected $protectFields = true;
    protected $allowedFields = ['id_profil', 'nama_dinas', 'kepala_dinas', 'nip_kepala', 'alamat', 'telepon', 'email', 'website', 'logo', 'created_at', 'updated_at'];
}
