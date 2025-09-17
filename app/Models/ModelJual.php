<?php

namespace App\Models;

use CodeIgniter\Model;

class ModelJual extends Model
{
    protected $table = 'jual';
    protected $primaryKey = 'idJual';
    protected $allowedFields = ['idTransaksi', 'idBarang', 'kuantitas', 'harga'];

    public function createJual($data)
    {
        $this->insert($data);
    }
}