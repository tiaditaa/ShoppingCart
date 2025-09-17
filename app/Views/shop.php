<?php $cart_total_items = session()->get('cart_total_items') ?? 0; ?>
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
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container px-4 px-lg-5">
            <a class="navbar-brand" href="#!">Hardita's Store</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0 ms-lg-4">
                    <li class="nav-item"><a class="nav-link active" aria-current="page" href="<?php echo site_url('shop'); ?>">Home</a></li>
                    <li class="nav-item"><a class="nav-link" href="<?php echo site_url('shop'); ?>">About</a></li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" id="navbarDropdown" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">Shop</a>
                        <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <li><a class="dropdown-item" href="<?php echo site_url('shop'); ?>">All Products</a></li>
                            <li><hr class="dropdown-divider" /></li>
                            <li><a class="dropdown-item" href="<?php echo site_url('shop'); ?>">Popular Items</a></li>
                            <li><a class="dropdown-item" href="<?php echo site_url('shop'); ?>">New Arrivals</a></li>
                        </ul>
                    </li>
                </ul>
                <form class="d-flex">
                <a href="<?php echo site_url('shop/cart'); ?>" class="btn btn-outline-dark">
                    <i class="bi-cart-fill me-1"></i>
                    Cart
                    <span id="cart_total_items" class="badge bg-dark text-white ms-1 rounded-pill"><?php echo $cart_total_items; ?></span>
                </a>
                    <a href="<?php echo site_url('shop/add'); ?>" class="btn btn-outline-dark ms-2">
                        <i class="bi-plus-circle me-1"></i>
                        Tambah Barang
                    </a>
                </form>
            </div>
        </div>
    </nav>
    <header class="bg-dark py-5">
        <div class="container px-4 px-lg-5 my-5">
            <div class="text-center text-white">
                <h1 class="display-4 fw-bolder">HARDITA'S STORE</h1>
                <p class="lead fw-normal text-white-50 mb-0">Toko Pakaian Kekinian</p>
            </div>
        </div>
    </header>
    <section class="py-5">
        <div class="container px-4 px-lg-5 mt-5">
            <!-- Tampilkan pesan sukses atau gagal -->
            <?php if (session()->getFlashdata('success')) : ?>
                <div class="alert alert-success" role="alert">
                    <?= session()->getFlashdata('success') ?>
                </div>
            <?php elseif (session()->getFlashdata('error')) : ?>
                <div class="alert alert-danger" role="alert">
                    <?= session()->getFlashdata('error') ?>
                </div>
            <?php endif; ?>

            <div class="row gx-4 gx-lg-5 row-cols-2 row-cols-md-3 row-cols-xl-4 justify-content-center">
                <?php foreach($barang as $item): ?>
                    <div class="col mb-4">
                        <div class="card h-100">
                            <img src="<?php echo base_url('assets/images/' . $item['foto']); ?>" alt="<?php echo $item['namaBarang']; ?>" class="card-img-top img-fluid" style="max-width: 100%; height: auto; object-fit: cover;" />
                            <div class="card-body">
                                <div class="text-center">
                                    <h5 class="fw-bolder"><?php echo $item['namaBarang']; ?></h5>
                                    <p class="mb-1">Rp. <?php echo number_format($item['harga'], 0, ',', '.'); ?></p>
                                    <p class="mb-0">Stok: <?php echo $item['stok']; ?></p>
                                </div>
                            </div>
                            <div class="text-center">
                                <a class="btn btn-outline-dark mt-auto" href="<?php echo site_url('shop/addToCart/' . $item['idBarang']); ?>">Add to cart</a>
                            </div><br>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
    </section>
    <footer class="py-5 bg-dark">
        <div class="container"><p class="m-0 text-center text-white">Copyright &copy; Mutia Website 2024</p></div>
    </footer>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="<?php echo base_url('js/scripts.js'); ?>"></script>
    <script>
function updateQuantity(itemId, change) {
    var quantityInput = document.getElementById('quantity_' + itemId);
    var priceElement = document.getElementById('price_' + itemId);
    var price = parseFloat(priceElement.getAttribute('data-price'));
    var newQuantity = parseInt(quantityInput.value) + change;

    if (newQuantity < 1) {
        newQuantity = 1;
    }
    quantityInput.value = newQuantity;
    updateSubtotal(itemId, newQuantity, price);

    $.ajax({
        url: '<?php echo site_url('shop/updateCartQuantity'); ?>',
        type: 'POST',
        data: {
            id: itemId,
            qty: newQuantity
        },
        success: function(response) {
            if (response.status === 'success') {
                calculateTotalPrice();
                updateCartTotalItems(response.cart_total_items);
            } else {
                alert('Gagal memperbarui keranjang');
            }
        }
    });
}

function updateCartTotalItems(totalItems) {
    var cartTotalItemsElement = document.getElementById('cart_total_items');
    if (cartTotalItemsElement) {
        cartTotalItemsElement.innerText = totalItems;
    }
}

function updateSubtotal(itemId, quantity, price) {
    var subtotal = price * quantity;
    document.getElementById('subtotal_' + itemId).innerText = 'Rp. ' + subtotal.toLocaleString('id-ID', { useGrouping: true, minimumFractionDigits: 0 });
}

function calculateTotalPrice() {
    var totalPrice = 0;
    $('.item-subtotal').each(function() {
        totalPrice += parseFloat($(this).text().replace('Rp. ', '').replace(/\./g, ''));
    });
    document.getElementById('total_price').innerText = 'Rp. ' + totalPrice.toLocaleString('id-ID', { useGrouping: true, minimumFractionDigits: 0 });
}
</script>
</body>
</html>
