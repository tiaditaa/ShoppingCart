<?php

namespace App\Models;

use CodeIgniter\Model;

class ModelBarang extends Model {
    protected $table = 'barang';
    protected $primaryKey = 'idBarang';
    protected $allowedFields = ['namaBarang', 'harga', 'stok', 'foto'];

    public function getAllBarang() {
        return $this->findAll();
    }

    public function getBarangById($idBarang) {
        return $this->find($idBarang);
    }

    public function updateStok($idBarang, $stok) {
        return $this->update($idBarang, ['stok' => $stok]);
    }

    public function addBarang($data) {
        return $this->insert($data);
    }
}
?>
