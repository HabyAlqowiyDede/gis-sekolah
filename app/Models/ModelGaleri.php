<?php

namespace App\Models;

use CodeIgniter\Model;

class ModelGaleri extends Model
{
    protected $table = 'tbl_galeri';
    protected $primaryKey = 'id_galeri';
    protected $allowedFields = ['id_sekolah', 'foto', 'keterangan', 'created_at'];
    protected $useTimestamps = false;
}
