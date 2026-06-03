<?php
$selectCategory = mysqli_query($koneksi, "SELECT * FROM categories ORDER BY id DESC");
$categories = mysqli_fetch_all($selectCategory, MYSQLI_ASSOC);

$selectProduct = mysqli_query($koneksi, "SELECT products.*, categories.category_name FROM products LEFT JOIN categories ON products.category_id = categories.id WHERE products.is_active = 1 ORDER BY id DESC");
$products = mysqli_fetch_all($selectProduct, MYSQLI_ASSOC);
<<<<<<< HEAD


if (isset($_POST['process_payment'])) {
    $customer_name = $_POST['customer_name'];
    $payment_method = $_POST['payment_method'];
    $cart_row = $_POST['cart-data'];
    $cart_items = json_decode($cart_row, true);

    if (!empty($cart_items)) {
        $subtotal = 0;
        foreach ($cart_items as $item) {
            $subtotal += $item['price'] * $item['qty'];
        }
        $tax = $subtotal * 0.1;
        $discount = 0;
        $total_bill = $subtotal + $tax - $discount;
        $order_no = 'ORD-' . date('Ymd') . '-' .  rand(1000, 9999);
        if ($payment_method === 'CASH') {
            $payment_status = 'SUCCESS';
            $insertOder = mysqli_query($koneksi, "INSERT INTO orders(order_no, customer_name, payment_method, subtotal, tax, discount, total_bill, payment_status) VALUES ('$order_no','$customer_name','$payment_method','$subtotal','$tax','$discount','$total_bill','$payment_status')");

            if ($insertOder) {
                // karna tabel order dan order detail ter relasi, maka 
                $order_id = mysqli_insert_id($koneksi);
                foreach ($cart_items as $item) {
                    $product_id = $item['id'];
                    $product_name = $item['name'];
                    $price = $item['price'];
                    $quantity = $item['qty'];
                    $total_price = $price * $quantity;

                    $insertOrdDetail = mysqli_query($koneksi, "INSERT INTO order_details(order_id, product_id, product_name, price, quantity, total_price) VALUES ('$order_id','$product_id','$product_name','$price','$quantity','$total_price')");

                    if ($insertOrdDetail) {
                        mysqli_query($koneksi, "UPDATE products SET qty=qty-$quantity WHERE id='$product_id'");
                    }
                }
                header("location:?page=transaction");
                exit();
            }
        } else if ($payment_method === 'MIDTRANS') {
            require_once 'vendor/midtrans/midtrans-php/Midtrans.php';
            \Midtrans\Config::$serverKey = 'ciyeee kosong';
            \Midtrans\Config::$isProduction = false;
            \Midtrans\Config::$isSanitized = true;
            \Midtrans\Config::$is3ds = true;

            $params = [
                'transaction_details' => [
                    'order_id' => $order_no,
                    'gross_amount' => (int)$total_bill
                ],
                'customer_details' => [
                    'first_name' => $customer_name
                ]
            ];
            $snapToken = \Midtrans\Snap::getSnapToken($params);
            echo "
            <script>
            window.snapToken = '$snapToken';
            window.midtransData = {
                order_no: '$order_no',
                customer_name: '$customer_name',
                payment_method: 'MIDTRANS',
                subtotal: '$subtotal',
                tax: '$tax',
                discount: '$discount',
                total_bill: '$total_bill',
                'cart-data': '" . base64_encode($cart_row) . "',
            };
            </script>";
        }
    }
}

=======
>>>>>>> 1a9c46f30b70ba5cef55fa79636637afd328d149
?>
<div class="row">

    <div class="col-lg-8 p-4">
<<<<<<< HEAD
=======

>>>>>>> 1a9c46f30b70ba5cef55fa79636637afd328d149
        <ul class="nav nav-tabs" role="tablist">
            <?php
            foreach ($categories as $key => $cat) {
            ?>
                <li class="nav-item">
<<<<<<< HEAD
                    <button class="nav-link <?= $key === 0 ? 'active' : '' ?>" data-bs-toggle="tab"
=======
                    <button class="nav-link <?= $key === 0 ? 'active' : '' ?>"
                        data-bs-toggle="tab"
>>>>>>> 1a9c46f30b70ba5cef55fa79636637afd328d149
                        data-bs-target="#tab-pane-<?= $cat['id'] ?>">
                        <?= $cat['category_name'] ?>
                    </button>
                </li>
            <?php
            }
            ?>
        </ul>

        <div class="tab-content mt-3">
<<<<<<< HEAD
            <?php
            foreach ($categories as $key => $cat) { ?>
                <div class="tab-pane fade <?= $key === 0 ? 'show active' : '' ?> " id="tab-pane-<?= $cat['id'] ?>">
=======

            <?php
            foreach ($categories as $key => $cat) {
            ?>
                <div class="tab-pane fade <?= $key === 0 ? 'show active' : '' ?>" id="tab-pane-<?= $cat['id'] ?>">
>>>>>>> 1a9c46f30b70ba5cef55fa79636637afd328d149

                    <div class="d-flex justify-content-between align-items-center mb-3">

                        <div class="fw-semibold">
                            <?php
                            $count = 0;
                            foreach ($products as $p) {
                                if ($p['category_id'] == $cat['id']) {
                                    $count++;
                                }
                                if ($key == 0) {
                                    $count++;
                                }
                            }
                            ?>
                            <span class="fs-5"><?= $count ?></span> Products
                        </div>

                        <div class="flex-grow-1 mx-3">
                            <input type="text" class="form-control" placeholder="Search">
                        </div>

                    </div>

                    <div class="row g-3">

                        <?php
                        foreach ($products as $product) {
<<<<<<< HEAD
                            if ($product["category_id"] == $cat["id"] || $key == 0) {
=======
                            if ($product['category_id'] == $cat['id'] || $key == 0) {
>>>>>>> 1a9c46f30b70ba5cef55fa79636637afd328d149
                        ?>
                                <div class="col-md-4">

                                    <div class="card product-card h-100 shadow-sm">

                                        <div class="p-3 text-center">

                                            <h6 class="mb-1"><?= $product['product_name'] ?></h6>

                                            <small class="text-muted">
                                                <?= $product['category_name'] ?>
                                            </small>

                                            <div class="mt-2">
<<<<<<< HEAD
                                                <img src="assets/uploads/<?= $product['product_image'] ?>" class="img-fluid"
                                                    style="max-height:150px; object-fit:cover;">
=======
                                                <img src="assets/uploads/<?= $product['product_image'] ?>"
                                                    class="img-fluid" style="max-height:150px; object-fit:cover;">
>>>>>>> 1a9c46f30b70ba5cef55fa79636637afd328d149
                                            </div>

                                        </div>

                                        <div class="px-3 pb-3 text-center">

                                            <h6 class="fw-bold">
                                                Rp <?= number_format($product['price']) ?>
                                            </h6>

                                            <p class="text-muted">
<<<<<<< HEAD
                                                Ready <?= $product['qty'] ?> <?= $product['unit'] ?>
                                            </p>
                                        </div>
                                        <div class="px-3 pb-3 d-flex justify-content-center gap-2">
                                            <button type="button" class="btn btn-primary btn-sm btn-add-cart"
                                                data-id="<?= $product['id'] ?>" data-name="<?= $product['product_name'] ?>"
=======
                                                Ready Stock <?= $product['qty'] ?> <?= $product['unit'] ?>
                                            </p>
                                        </div>
                                        <div class="px-3 pb-3 d-flex justify-content-center gap-2">

                                            <button type="button" class="btn btn-primary btn-sm btn-add-cart"
                                                data-id="<?= $product['id'] ?>"
                                                data-name="<?= $product['product_name'] ?>"
>>>>>>> 1a9c46f30b70ba5cef55fa79636637afd328d149
                                                data-price="<?= $product['price'] ?>"
                                                data-image="assets/uploads/<?= $product['product_image'] ?>">
                                                Add To Cart
                                            </button>
                                        </div>

                                    </div>

                                </div>
<<<<<<< HEAD
                            <?php
                            } ?>

                        <?php } ?>
                    </div>

                </div>
            <?php } ?>


=======
                        <?php

                            }
                        }
                        ?>

                    </div>

                </div>
            <?php
            }
            ?>
>>>>>>> 1a9c46f30b70ba5cef55fa79636637afd328d149
        </div>

    </div>


<<<<<<< HEAD
    <div class=" col-lg-4 p-4">
=======
    <div class="col-lg-4 p-4">
>>>>>>> 1a9c46f30b70ba5cef55fa79636637afd328d149

        <ul class="nav nav-tabs">
            <li class="nav-item">
                <button class="nav-link active">Order Details</button>
            </li>
        </ul>

        <div class="card p-3 mt-3 shadow-sm">

<<<<<<< HEAD

            <div id="order-items" style="max-height: 350px; overflow-y: auto;">



=======
            <div id="order-items" style="max-height: 350px; overflow-y: auto;">

>>>>>>> 1a9c46f30b70ba5cef55fa79636637afd328d149
            </div>

            <div class="border-top pt-3 mt-3">

                <div class="d-flex justify-content-between">
                    <small>Subtotal</small>
                    <small id="subtotal">Rp 0</small>
                </div>

                <div class="d-flex justify-content-between">
                    <small>Tax</small>
                    <small id="tax">Rp 0</small>
                </div>

                <div class="d-flex justify-content-between">
                    <small>Discount</small>
                    <small id="discount">Rp 0</small>
                </div>

                <div class="d-flex justify-content-between fw-bold fs-5 mt-2">
                    <small>Total</small>
                    <small id="total-bill">Rp 0</small>
                </div>

            </div>

            <div class="mt-3 d-flex gap-2">
<<<<<<< HEAD
                <button class="btn btn-success w-100" id="btn-payment" type="button" data-bs-toggle="modal"
                    data-bs-target="#paymentModal">
=======
                <button class="btn btn-success w-100" id="btn-payment" type="button" data-bs-toggle="modal" data-bs-target="#paymentModal">
>>>>>>> 1a9c46f30b70ba5cef55fa79636637afd328d149
                    Payment
                </button>
            </div>

        </div>

    </div>

</div>

<<<<<<< HEAD
<div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="staticBackdropLabel" aria-hidden="true">
=======
<div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
>>>>>>> 1a9c46f30b70ba5cef55fa79636637afd328d149
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg rounded-4">

            <div class="modal-header bg-primary text-white rounded-top-4">
                <h1 class="modal-title fs-5" id="staticBackdropLabel">Detail Book</h1>
<<<<<<< HEAD
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                    aria-label="Close"></button>
=======
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
>>>>>>> 1a9c46f30b70ba5cef55fa79636637afd328d149
            </div>

            <div class="modal-body p-4">
                <div class="row">

                    <div class="col-md-5 text-center mb-3 mb-md-0">
<<<<<<< HEAD
                        <img id="modalImage" src="assets/img/default.jpg" alt="Book Image"
                            class="img-fluid rounded-4 shadow-sm" style="max-height: 300px; object-fit: cover;">
=======
                        <img id="modalImage" src="assets/img/default.jpg" alt="Book Image" class="img-fluid rounded-4 shadow-sm" style="max-height: 300px; object-fit: cover;">
>>>>>>> 1a9c46f30b70ba5cef55fa79636637afd328d149
                    </div>

                    <div class="col-md-7">
                        <h3 id="modalTitle" class="fw-bold text-dark mb-3">Judul Buku</h3>

                        <div class="mb-2">
                            <strong>Category:</strong> <span id="modalCategory"></span>
                        </div>
                        <div class="mb-2">
                            <strong>Author:</strong> <span id="modalAuthor"></span>
                        </div>
                        <div class="mb-2">
                            <strong>Publisher:</strong> <span id="modalPublisher"></span>
                        </div>
                        <div class="mb-2">
                            <strong>Year:</strong> <span id="modalYear"></span>
                        </div>
                        <div class="mb-2">
                            <strong>Price:</strong> <span id="modalPrice" class="text-success fw-bold"></span>
                        </div>
                        <div class="mb-2">
                            <strong>Stock:</strong> <span id="modalStock"></span> pcs
                        </div>

                        <hr>

                        <div>
                            <strong>Description:</strong>
                            <p id="modalDescription" class="text-muted mt-2 mb-0"></p>
                        </div>
                    </div>

                </div>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-secondary rounded-3" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary rounded-3" id="modalAddToCartBtn">
                    Add To Cart
                </button>
            </div>

        </div>
    </div>
</div>

<<<<<<< HEAD
<div class="modal fade" id="paymentModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="paymentModalLabel" aria-hidden="true">
=======
<div class="modal fade" id="paymentModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="paymentModalLabel" aria-hidden="true">
>>>>>>> 1a9c46f30b70ba5cef55fa79636637afd328d149
    <div class="modal-dialog modal-xl">
        <div class="modal-content rounded-4 shadow-lg border-0">

            <div class="modal-header bg-success text-white rounded-top-4">
                <h1 class="modal-title fs-5" id="paymentModalLabel">Payment Method</h1>
<<<<<<< HEAD
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                    aria-label="Close"></button>
            </div>

            <form action="" method="POST">
                <div class="modal-body p-4">
                    <input type="text" name="cart-data" id="cart-data">
                    <h5 class="mb-3">Pilih Metode Pembayaran</h5>
                    <div class="mb-3">
                        <label for="" class="form-label">Customer Name</label>
                        <input type="text" class="form-control" name="customer_name" placeholder="isi nama anda ..."
                            required>
                    </div>
=======
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <form action="" method="POST">
                <input type="text" name="cart-data" id="cart-data" class="form-control">
                <div class="modal-body p-4">

                    <h5 class="mb-3">Pilih Metode Pembayaran</h5>
>>>>>>> 1a9c46f30b70ba5cef55fa79636637afd328d149

                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="w-100">
<<<<<<< HEAD
                                <input type="radio" name="payment_method" value="CASH" class="payment-option" checked>
                                <div class="card p-4 shadow-sm border payment-card h-100">
                                    <h4 class="text-success">CASH</h4>
                                    <p class="text-muted mb-0">Pembayaran Via Kasir.</p>
=======
                                <input type="radio" name="payment_method" value="COD" class="d-none payment-option" checked>
                                <div class="card p-4 shadow-sm border payment-card h-100">
                                    <h4 class="text-success">COD</h4>
                                    <p class="text-muted mb-0">Bayar di tempat saat buku diterima.</p>
>>>>>>> 1a9c46f30b70ba5cef55fa79636637afd328d149
                                </div>
                            </label>
                        </div>

                        <div class="col-md-6">
                            <label class="w-100">
<<<<<<< HEAD
                                <input type="radio" name="payment_method" value="MIDTRANS" class="payment-option">
                                <div class="card p-4 shadow-sm border payment-card h-100">
                                    <h4 class="text-primary">Midtrans</h4>
                                    <p class="text-muted mb-0">Pembayaran online via payment
                                        gateway.</p>
=======
                                <input type="radio" name="payment_method" value="MIDTRANS" class="d-none payment-option">
                                <div class="card p-4 shadow-sm border payment-card h-100">
                                    <h4 class="text-primary">Midtrans</h4>
                                    <p class="text-muted mb-0">Pembayaran online via payment gateway.</p>
>>>>>>> 1a9c46f30b70ba5cef55fa79636637afd328d149
                                </div>
                            </label>
                        </div>
                    </div>

                    <hr class="my-4">

                    <div class="row">
                        <div class="col-md-6">
                            <div class="border rounded-3 p-3 bg-light">
                                <h6 class="fw-bold mb-3">Ringkasan Pembayaran</h6>

                                <div class="d-flex justify-content-between mb-2">
                                    <span>Subtotal</span>
                                    <span>Rp 0</span>
                                </div>

                                <div class="d-flex justify-content-between mb-2">
                                    <span>Tax</span>
                                    <span>Rp 0</span>
                                </div>

                                <div class="d-flex justify-content-between mb-2">
                                    <span>Discount</span>
                                    <span>- Rp 0</span>
                                </div>

                                <hr>

                                <div class="d-flex justify-content-between fw-bold fs-5">
                                    <span>Total</span>
                                    <span>Rp 0</span>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="alert alert-info rounded-3 mb-0">
                                <strong>Catatan:</strong><br>
                                - Jika memilih <b>COD</b>, pesanan akan langsung diproses.<br>
<<<<<<< HEAD
                                - Jika memilih <b>Midtrans</b>, nanti bisa diarahkan ke payment
                                gateway.
=======
                                - Jika memilih <b>Midtrans</b>, nanti bisa diarahkan ke payment gateway.
>>>>>>> 1a9c46f30b70ba5cef55fa79636637afd328d149
                            </div>
                        </div>
                    </div>

                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary rounded-3" data-bs-dismiss="modal">Close</button>
                    <button type="submit" name="process_payment" class="btn btn-success rounded-3 px-4">
                        Bayar Sekarang
                    </button>
                </div>
            </form>

        </div>
    </div>
</div>

<script>
<<<<<<< HEAD
    // looping product-card
    // tanpa evemt delegation

    // document.querySelectorAll('.product-card').forEach((button) => {
    //     button.addEventListener('click', function() {

    //     })
    // })

    // event delegation

    let cart = [];
=======
    // looping product card
    // tanpa event delegation
    // documnt.querySelectorAll('.product-card').forEach((button) => {
    //     button.addEventListener('click', function() {
    //         this.getAttribute('data-id');
    //     })

    // });

    // event
    let cart = [];

>>>>>>> 1a9c46f30b70ba5cef55fa79636637afd328d149
    document.addEventListener('click', function(e) {
        if (e.target && e.target.classList.contains('btn-add-cart')) {
            const id = e.target.getAttribute('data-id');
            const name = e.target.getAttribute('data-name');
            const price = e.target.getAttribute('data-price');
            const image = e.target.getAttribute('data-image');

            const extProducts = cart.find(item => item.id === id);
            if (extProducts) {
                extProducts.qty += 1;
            } else {
                cart.push({
                    id,
                    name,
                    price,
                    image,
                    qty: 1
                })
            }
            renderCart();
<<<<<<< HEAD

        }

        // jika cart nya sama valuenya dengan yang dikirim dari button atau
        // sudah btn-add-cart
        // foreach(cart as item)
        // existing produk pakai find





    })

    function renderCart() {
        const containerCart = document.getElementById('order-items')
        containerCart.innerHTML = ""

        if (cart.length === 0) {
            containerCart.innerHTML = "<p class=' text-muted text-center py-3'>Cart empty</p>"
=======
        }
        // jika cart nya sama valuenya dengan yang card dikiri dari button atau
        // sudah ada
    })

    function renderCart() {
        const containerCart = document.getElementById('order-items');
        containerCart.innerHTML = "";

        if (cart.length === 0) {
            containerCart.innerHTML = "<p class = 'text-muted text-center py-3'>Cart Emppty</p>"
>>>>>>> 1a9c46f30b70ba5cef55fa79636637afd328d149
            updateCart();
            return;
        }

<<<<<<< HEAD


        // cart.forEach((value,index) => {
=======
>>>>>>> 1a9c46f30b70ba5cef55fa79636637afd328d149
        cart.forEach(value => {
            const itemHtml = `
                <div class="card p-2 mb-2 border-0 shadow-sm">

                    <div class="d-flex justify-content-between align-items-center">

                        <div class="d-flex align-items-center gap-3">
<<<<<<< HEAD
                            <img class="rounded-circle" src="${value.image}" width="45" height="45"
                                style="object-fit: cover;">
=======
                            <img class="rounded-circle" src="${value.image}" width="45" height="45" style="object-fit: cover;">
>>>>>>> 1a9c46f30b70ba5cef55fa79636637afd328d149

                            <div>
                                <div class="fw-semibold">${value.name}</div>
                                <small class="text-muted">
                                    Rp ${value.price}
                                </small>
                            </div>
                        </div>

                        <a href="#" class="btn btn-sm btn-outline-danger btn-delete" data-id=${value.id}>
                            X
                        </a>

                    </div>

                    <div class="d-flex justify-content-between align-items-center my-3">

                        <div class="d-flex align-items-center gap-1">
                            <a href="#" class="btn btn-outline-primary btn-sm btn-minus" data-id=${value.id}>-</a>

                            <span class="fw-semibold px-2">${value.qty}</span>

                            <a href="#" class="btn btn-outline-primary btn-sm btn-plus" data-id=${value.id}>+</a>
                        </div>

                        <div class="fw-bold">
                            Rp ${(value.price * value.qty).toLocaleString('id-ID')}
                        </div>

                    </div>

                </div>
            `
<<<<<<< HEAD


            // containerCart.insertAdjacentElement(posisi, elemenya)
=======
            // containerCart.innerHTML = itemHtml
>>>>>>> 1a9c46f30b70ba5cef55fa79636637afd328d149
            containerCart.insertAdjacentHTML("beforeend", itemHtml)
        })

        updateCart();
    }

    document.getElementById('order-items').addEventListener('click', function(e) {
<<<<<<< HEAD
        const id = e.target.getAttribute('data-id')
        if (!id) return;

        const itemIndex = cart.findIndex(item => item.id === id)
        if (e.target.classList.contains('btn-plus')) {
            cart[itemIndex].qty += 1;
        } else if (e.target.classList.contains('btn-minus')) {
            //  jika di cart qty lebih dari 1
            if (cart[itemIndex].qty > 1) {
                cart[itemIndex].qty -= 1;
            } else {
                // qty cuma 1 terus klik minus button maka data menu di section cart hilang juga
                // splice(index,1)
=======
        const id = e.target.getAttribute('data-id');
        if (!id) return;

        const itemIndex = cart.findIndex(item => item.id === id);
        if (e.target.classList.contains('btn-plus')) {
            cart[itemIndex].qty += 1;
        } else if (e.target.classList.contains('btn-minus')) {
            // jika card qty cuman 1, makan akan hilang
            if (cart[itemIndex].qty > 1) {
                cart[itemIndex].qty -= 1;

            } else {
                // qty cuman 1, kemudian product di cart akan dihilangkan
                // splice (index, 1)
>>>>>>> 1a9c46f30b70ba5cef55fa79636637afd328d149
                cart.splice(itemIndex, 1)
            }
        } else if (e.target.classList.contains('btn-delete')) {
            cart.splice(itemIndex, 1)
        }

<<<<<<< HEAD
        renderCart()
    })

    function updateCart() {
        let subtotal = 0
        let tax = 0
        let discount = 0
=======
        renderCart();
    })

    function updateCart() {
        let subtotal = 0;
        let tax = 0;
        let discount = 0;
>>>>>>> 1a9c46f30b70ba5cef55fa79636637afd328d149

        cart.forEach(item => {
            subtotal += item.price * item.qty;
        })

        tax = subtotal * 0.1;
        let total = subtotal + tax - discount;

        const formatRupiah = (number) => {
            return "Rp. " + number.toLocaleString('id-ID')
        }

<<<<<<< HEAD
        document.getElementById('subtotal').innerHTML = formatRupiah(subtotal)
        document.getElementById('tax').innerHTML = formatRupiah(tax)
        document.getElementById('discount').innerHTML = formatRupiah(discount)
        document.getElementById('total-bill').innerHTML = formatRupiah(total)

        // span untuk modal
        const cartModal = document.querySelector('#paymentModal .border.rounded-3')
        if (cartModal) {
            const spans = cartModal.querySelectorAll('span')
            if (spans.length >= 8) {
                spans[1].innerText = formatRupiah(subtotal)
                spans[3].innerText = formatRupiah(tax)
                spans[5].innerText = "-" + formatRupiah(discount)
                spans[7].innerText = formatRupiah(total)
=======
        document.getElementById('subtotal').innerText = formatRupiah(subtotal);
        document.getElementById('tax').innerText = formatRupiah(tax);
        document.getElementById('discount').innerText = formatRupiah(discount);
        document.getElementById('total-bill').innerText = formatRupiah(total);

        const cartModal = document.querySelector('#paymentModal .border.rounded-3')
        // jika cart modal terbuka
        if (cartModal) {
            const spans = cartModal.querySelectorAll('span');
            if (spans.length >= 8) {
                spans[1].innerText = formatRupiah(subtotal);
                spans[3].innerText = formatRupiah(tax);
                spans[5].innerText = formatRupiah(discount);
                spans[7].innerText = formatRupiah(total);
>>>>>>> 1a9c46f30b70ba5cef55fa79636637afd328d149
            }
        }

        document.getElementById('cart-data').value = JSON.stringify(cart);
        // json : javascript object notation
<<<<<<< HEAD
    }

    document.getElementById('btn-payment').addEventListener('click', () => {
        if (cart.length === 0) {
            alert('cart is empty')

            // stopPropagation(); : ini membuat modal tidak muncul
            e.stopPropagation();
        }
    })


    // snap (midtrans)

    document.addEventListener('DOMContentLoaded', function() {
        // Trigger snap popup. @TODO: Replace TRANSACTION_TOKEN_HERE with your transaction token.
        // Tutorial to create snap token - https://docs.midtrans.com/reference/backend-integration
        // Also, use the embedId that you defined in the div above, here.
        snap.pay(window.snapToken, {
            onSuccess: function(result) {
                /* You may add your own implementation here */
                alert("payment success!");
                fetch('simpan_transaksi_midtrans.php', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json'
                        },
                        body: JSON.stringify(window.midtransData)
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            window.open('print_struk.php?order_id=' + data.order_id, '_blank');
                        } else {
                            alert("Payment Failed !");
                        }
                        window.location.href = '?page=transaction'
                    })
                console.log(result);
            },
            onPending: function(result) {
                /* You may add your own implementation here */
                alert("wating your payment!");
                console.log(result);
            },
            onError: function(result) {
                /* You may add your own implementation here */
                alert("payment failed!");
                console.log(result);
            },
            onClose: function() {
                /* You may add your own implementation here */
                alert('you closed the popup without finishing the payment');
            }
        });
    });
=======

    }

    document.getElementById('btn-payment').addEventListener('click', (e) => {
        if (cart.length === 0) {
            alert('Cart is empty');

            // stopPropagation(): agar modal tidak muncul
            e.stopPropagation();

        }
    })
>>>>>>> 1a9c46f30b70ba5cef55fa79636637afd328d149
</script>