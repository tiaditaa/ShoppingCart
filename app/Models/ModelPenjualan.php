<?php

namespace App\Models;

use CodeIgniter\Model;

class ModelPenjualan extends Model
{
    protected $table = 'penjualan';
    protected $primaryKey = 'idTransaksi';
    protected $allowedFields = ['namaPembeli', 'noHP', 'alamat', 'kodePos', 'tanggalTransaksi'];

    public function createPenjualan($data)
    {
        $this->insert($data);
        return $this->insertID(); // Use insertID to get the last inserted ID
    }
}