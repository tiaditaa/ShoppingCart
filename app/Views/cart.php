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
    <!-- Section-->
    <section class="py-5">
        <div class="container">
            <!-- Tampilkan daftar item yang ditambahkan ke keranjang -->
            <h2>Shopping Cart</h2>
            <table class="table">
                <thead>
                    <tr>
                        <th>Nama Barang</th>
                        <th>Jumlah</th>
                        <th>Harga Satuan</th>
                        <th>Subtotal</th>
                    </tr>
                </thead>
                <tbody>
                <?php if ($cart_items): ?>
                    <?php foreach ($cart_items as $item): ?>
                        <tr>
                            <td><?php echo $item['name']; ?></td>
                            <td>
                                <!-- Tombol - untuk mengurangi jumlah barang -->
                                <button class="btn btn-sm btn-outline-secondary" onclick="updateQuantity('<?php echo $item['id']; ?>', -1)">-</button>
                                <input type="text" id="quantity_<?php echo $item['id']; ?>" value="<?php echo $item['qty']; ?>" readonly style="width: 30px; text-align: center;" />
                                <!-- Tombol + untuk menambah jumlah barang -->
                                <button class="btn btn-sm btn-outline-secondary" onclick="updateQuantity('<?php echo $item['id']; ?>', 1)">+</button>
                            </td>
                            <td id="price_<?php echo $item['id']; ?>" class="item-price" data-price="<?php echo $item['price']; ?>">Rp. <?php echo number_format($item['price'], 0, '', '.'); ?></td>
                            <td id="subtotal_<?php echo $item['id']; ?>" class="item-subtotal">Rp. <?php echo number_format($item['subtotal'], 0, '', '.'); ?></td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="4">Keranjang belanja kosong</td>
                    </tr>
                <?php endif; ?>
                </tbody>
            </table>

            <p>Total: <span id="total_price">Rp. <?php echo number_format($total_price, 0, '', '.'); ?></span></p>

            <!-- Tambahkan button checkout -->
            <a href="<?php echo site_url('shop'); ?>" class="btn btn-success" id="checkoutButton">Kembali</a>
            <a href="<?php echo site_url('shop/checkout'); ?>" class="btn btn-primary" id="checkoutButton">Lanjut</a>
        </div>
    </section>
    <!-- Footer-->
    <footer class="py-5 bg-dark">
        <div class="container"><p class="m-0 text-center text-white">Copyright &copy; Mutia Website 2024</p></div>
    </footer>
    <!-- Bootstrap core JS-->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Core theme JS-->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
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