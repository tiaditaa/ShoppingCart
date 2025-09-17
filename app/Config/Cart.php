<?php

namespace Config;

class Cart extends \CodeIgniter\Config\BaseConfig
{
    public $cartName = 'cart'; // Nama keranjang
    public $perPage = 10; // Jumlah item per halaman jika menggunakan fitur paginasi
    public $maximumItems = 0; // Batas maksimum item dalam keranjang (0 untuk tak terbatas)
    // Tambahkan konfigurasi lain sesuai kebutuhan aplikasi Anda
}
