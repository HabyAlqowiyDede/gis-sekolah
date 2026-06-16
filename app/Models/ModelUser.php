<?php

namespace App\Models;

use CodeIgniter\Model;

class ModelUser extends Model
{
    protected $table = 'tbl_user';
    protected $primaryKey = 'id_user';
    protected $allowedFields = ['nama_user', 'email', 'password'];

    public function getByEmailOrUsername(string $login): ?array
    {
        return $this->groupStart()
                ->where('email', $login)
                ->orWhere('nama_user', $login)
            ->groupEnd()
            ->first();
    }
}
