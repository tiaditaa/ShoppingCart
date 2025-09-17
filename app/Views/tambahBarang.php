<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Tambah Barang</title>
    <link rel="icon" type="image/x-icon" href="assets/favicon.ico" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css" rel="stylesheet" />
    <link href="<?php echo base_url('css/styles.css'); ?>" rel="stylesheet" />
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container px-4 px-lg-5">
            <a class="navbar-brand" href="<?php echo site_url('shop'); ?>">Shop</a>
        </div>
    </nav>
    <header class="bg-dark py-5">
        <div class="container px-4 px-lg-5 my-5">
            <div class="text-center text-white">
                <h1 class="display-4 fw-bolder">Tambah Barang</h1>
            </div>
        </div>
    </header>
    <section class="py-5">
        <div class="container px-4 px-lg-5 mt-5">
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <form action="<?php echo site_url('shop/store'); ?>" method="post" enctype="multipart/form-data">
                        <div class="mb-3">
                            <label for="namaBarang" class="form-label">Nama Barang</label>
                            <input type="text" class="form-control" id="namaBarang" name="namaBarang" required>
                        </div>
                        <div class="mb-3">
                            <label for="harga" class="form-label">Harga</label>
                            <input type="number" class="form-control" id="harga" name="harga" required>
                        </div>
                        <div class="mb-3">
                            <label for="stok" class="form-label">Stok</label>
                            <input type="number" class="form-control" id="stok" name="stok" required>
                        </div>
                        <div class="mb-3">
                            <label for="foto" class="form-label">Foto Barang</label>
                            <input type="file" class="form-control" id="foto" name="foto" required>
                        </div>
                        <button type="submit" class="btn btn-primary">Tambah Barang</button>
                    </form>
                </div>
            </div>
        </div>
    </section>
    <footer class="py-5 bg-dark">
        <div class="container"><p class="m-0 text-center text-white">Copyright &copy; Your Website 2023</p></div>
    </footer>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="<?php echo base_url('js/scripts.js'); ?>"></script>
</body>
</html>
