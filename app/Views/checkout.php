<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Shopping cart</title>
    <link rel="icon" type="image/x-icon" href="assets/favicon.ico" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css" rel="stylesheet" />
    <link href="<?php echo base_url('css/styles.css'); ?>" rel="stylesheet" />
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-dark">
        <div class="container px-4 px-lg-5">
            <a class="navbar-brand text-white" href="#!">Hardita's Store</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0 ms-lg-4">
                    <li class="nav-item"><a class="nav-link active text-white" aria-current="page" href="<?php echo site_url('shop'); ?>">Home</a></li>
                    <li class="nav-item"><a class="nav-link text-white" href="<?php echo site_url('shop'); ?>">About</a></li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle text-white" id="navbarDropdown" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">Shop</a>
                        <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <li><a class="dropdown-item" href="<?php echo site_url('shop'); ?>">All Products</a></li>
                            <li><hr class="dropdown-divider" /></li>
                            <li><a class="dropdown-item" href="<?php echo site_url('shop'); ?>">Popular Items</a></li>
                            <li><a class="dropdown-item" href="<?php echo site_url('shop'); ?>">New Arrivals</a></li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <section class="py-5">
        <div class="container px-4 px-lg-5">
            <h2>Checkout</h2>
            <form method="post" action="<?php echo site_url('shop/processCheckout'); ?>">
                <div class="mb-3">
                    <label for="namaPembeli" class="form-label">Nama Pembeli</label>
                    <input type="text" class="form-control" id="namaPembeli" name="namaPembeli" required>
                </div>
                <div class="mb-3">
                    <label for="noHP" class="form-label">No HP</label>
                    <input type="text" class="form-control" id="noHP" name="noHP" required>
                </div>
                <div class="mb-3">
                    <label for="alamat" class="form-label">Alamat</label>
                    <textarea class="form-control" id="alamat" name="alamat" required></textarea>
                </div>
                <div class="mb-3">
                    <label for="kodePos" class="form-label">Kode Pos</label>
                    <input type="text" class="form-control" id="kodePos" name="kodePos" required>
                </div>
                <button type="submit" class="btn btn-primary">Checkout</button>
            </form>
        </div>
    </section>
    <footer class="py-5 bg-dark">
        <div class="container"><p class="m-0 text-center text-white">Copyright &copy; Mutia Website 2024</p></div>
    </footer>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="<?php echo base_url('js/scripts.js'); ?>"></script>
</body>
</html>