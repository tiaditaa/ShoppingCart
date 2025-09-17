<?php

namespace App\Controllers;

use App\Models\ModelBarang;
use App\Models\ModelPenjualan;
use App\Models\ModelJual;

class Shop extends BaseController
{
    protected $modelBarang;
    protected $modelPenjualan;
    protected $modelJual;
    protected $cart;

    public function __construct()
    {
        $this->modelBarang = new ModelBarang();
        $this->modelPenjualan = new ModelPenjualan();
        $this->modelJual = new ModelJual();
        $this->cart = \Config\Services::cart();
    }

    public function index()
    {
        $data['barang'] = $this->modelBarang->getAllBarang();
        
        // Inisialisasi objek Cart
        $cart = \Config\Services::cart();
        
        // Tambahkan informasi keranjang belanja ke dalam data
        $data['cart_total_items'] = $cart ? $cart->total_items() : 0;
        
        return view('shop', $data);
    }

    public function addToCart($idBarang)
{
    $barangModel = new ModelBarang();
    $barang = $barangModel->find($idBarang);

    if (!$barang) {
        return redirect()->to(site_url('shop'))->with('error', 'Barang tidak ditemukan');
    }

    $cart = session()->get('cart') ?? [];

    if (isset($cart[$idBarang])) {
        $cart[$idBarang]['qty'] += 1;
    } else {
        $cart[$idBarang] = [
            'id' => $idBarang,
            'name' => $barang['namaBarang'],
            'price' => $barang['harga'],
            'qty' => 1,
            'subtotal' => $barang['harga'],
            'foto' => $barang['foto']
        ];
    }

    $cart[$idBarang]['subtotal'] = $cart[$idBarang]['qty'] * $cart[$idBarang]['price'];

    // Simpan keranjang ke sesi
    session()->set('cart', $cart);

    // Hitung total item di keranjang
    $cart_total_items = 0;
    foreach ($cart as $item) {
        $cart_total_items += $item['qty'];
    }
    session()->set('cart_total_items', $cart_total_items);

    return redirect()->to(site_url('shop/cart'))->with('success', 'Barang berhasil ditambahkan ke keranjang');
}

    public function cart()
    {
        $cart_items = session()->get('cart') ?? [];
        $total_price = 0;

        foreach ($cart_items as $item) {
            $total_price += $item['subtotal'];
        }

        $data = [
            'cart_items' => $cart_items,
            'total_price' => $total_price,
            'cart_total_items' => count($cart_items)
        ];

        return view('cart', $data);
    }

    public function checkout()
    {
        // Ambil data keranjang dari session
        $cart_items = session()->get('cart') ?? [];

        // Hitung total harga semua barang di keranjang
        $total_price = 0; // Inisialisasi total harga
        if ($cart_items) {
            foreach ($cart_items as $item) {
                $subtotal = $item['qty'] * $item['price']; // Hitung subtotal untuk setiap item
                $total_price += $subtotal; // Akumulasikan subtotal ke total harga
            }
        }

        // Kirim data ke view checkout.php
        $data = [
            'cart_items' => $cart_items,
            'total_price' => $total_price,
            'cart_total_items' => count($cart_items) // Kirim jumlah item dalam keranjang
        ];

        return view('checkout', $data);
    }

    public function processCheckout()
    {
        $cart_items = session()->get('cart');

        if (!$cart_items) {
            return redirect()->to('/shop/checkout')->with('error', 'Keranjang belanja kosong');
        }

        $penjualanData = [
            'namaPembeli' => $this->request->getPost('namaPembeli'),
            'noHP' => $this->request->getPost('noHP'),
            'alamat' => $this->request->getPost('alamat'),
            'kodePos' => $this->request->getPost('kodePos'),
            'tanggalTransaksi' => date('Y-m-d H:i:s')
        ];

        $modelPenjualan = new ModelPenjualan();
        $idTransaksi = $modelPenjualan->createPenjualan($penjualanData);

        $modelJual = new ModelJual();
        $modelBarang = new ModelBarang();
        foreach ($cart_items as $item) {
            $jualData = [
                'idTransaksi' => $idTransaksi,
                'idBarang' => $item['id'],
                'kuantitas' => $item['qty'],
                'harga' => $item['price']
            ];
            $modelJual->createJual($jualData);

            // Kurangi stok barang di database hanya setelah checkout
            $barang = $modelBarang->find($item['id']);
            $newStok = $barang['stok'] - $item['qty'];
            $modelBarang->update($item['id'], ['stok' => $newStok]);
        }

        session()->remove('cart');
        session()->remove('cart_total_items');

        return redirect()->to('/shop')->with('success', 'Checkout berhasil');
    }

    // Metode untuk menampilkan form tambah barang
    public function add()
    {
        return view('tambahBarang');
    }

    // Metode untuk menyimpan barang baru
    public function store() {
        $data = [
            'namaBarang' => $this->request->getPost('namaBarang'),
            'harga' => $this->request->getPost('harga'),
            'stok' => $this->request->getPost('stok'),
            'foto' => $this->request->getPost('foto') // Menyimpan nama file foto
        ];

        // Proses upload foto
        $foto = $this->request->getFile('foto');
        if ($foto->isValid() && !$foto->hasMoved()) {
            $fotoName = $foto->getRandomName();
            $foto->move(WRITEPATH . '../public/assets/images/', $fotoName);
            $data['foto'] = $fotoName;
        }

        $this->modelBarang->addBarang($data);
        return redirect()->to('/shop')->with('success', 'Barang berhasil ditambahkan');
    }

    public function updateCartQuantity()
{
    $itemId = $this->request->getPost('id');
    $newQty = $this->request->getPost('qty');

    $cart = session()->get('cart');
    if ($cart && isset($cart[$itemId])) {
        $cart[$itemId]['qty'] = $newQty;
        $cart[$itemId]['subtotal'] = $cart[$itemId]['price'] * $newQty;
        session()->set('cart', $cart);

        // Hitung total item di keranjang
        $cart_total_items = 0;
        foreach ($cart as $item) {
            $cart_total_items += $item['qty'];
        }
        session()->set('cart_total_items', $cart_total_items);

        $totalPrice = 0;
        foreach ($cart as $item) {
            $totalPrice += $item['subtotal'];
        }

        return $this->response->setJSON(['status' => 'success', 'total_price' => $totalPrice]);
    }

    return $this->response->setJSON(['status' => 'error']);
}
}
?>