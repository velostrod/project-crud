<?php
$select = mysqli_query($koneksi, "SELECT products.*, categories.category_name FROM products LEFT JOIN categories ON products.category_id = categories.id ORDER BY id DESC");
$rowsProducts = mysqli_fetch_all($select, MYSQLI_ASSOC);

?>

<div class="card">
    <div class="card-header">
        <h5 class="cart-title">
            Manage Products
        </h5>
    </div>
    <div class="card-body">
        <div class="mb-2 d-flex justify-content-end">
            <a href="?page=create-product" class="btn btn-primary">Create products</a>
        </div>
        <div class="table-responsive">
            <?php
            // if (isset($_GET['status']) && $_GET['status'] == 'success') {
            //     $status = "Data Berhasil ditambah!";
            //     $location = "?page=category";
            //     echo statusSuccess($status, $location);
            // }

            ?>
            <table class="table table-bordered">
                <thead>


                    <tr>
                        <th>No</th>
                        <th>Product Image</th>
                        <th>Product Name</th>
                        <th>Category Name</th>
                        <th>Quantity</th>
                        <th>Price</th>
                        <th>Unit</th>
                        <th>Description</th>
                        <th>Status</th>
                        <th>actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    foreach ($rowsProducts as $index => $r) {
                    ?>
                        <tr>
                            <td><?= $index + 1 ?></td>
                            <td><img src="assets/uploads/<?php echo $r['product_image'] ?>" alt="" width="80"></td>
                            <td><?= $r['product_name'] ?></td>
                            <td><?= $r['category_name'] ?></td>
                            <td><?= $r['qty'] ?></td>
                            <!-- fungsi bawaan php handle mata uang atau format number -->
                            <td><?= number_format($r['price'], 2, ',', '.') ?></td>
                            <td><?= ($r['unit']) ?></td>
                            <td><?= ($r['description']) ?></td>
                            <td><?= getStatus($r['is_active']) ?></td>
                            <td>
                                <a href="?page=create-product&edit=<?= $r['id'] ?>" class="btn btn-success">Edit</a>
                                <form action="?page=product&delete=<?= $r['id'] ?>" method="post" class="d-inline">
                                    <button class="btn btn-danger" onclick="return confirm('')">Delete</button>
                                </form>
                            </td>
                        </tr>
                    <?php
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>