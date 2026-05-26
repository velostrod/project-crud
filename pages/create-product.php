<?php

if (isset($_POST['simpan'])) {
    $product_image = '';
    if (isset($_FILES['product_image']['name']) && $_FILES['product_image']['name'] != '') {
        $fileName = time() . '_' . basename($_FILES['product_image']['name']);
        move_uploaded_file($_FILES['product_image']['tmp_name'], __DIR__ . '/../assets/uploads/' . $fileName);
        $product_image = $fileName;
    }
    $product_name = htmlspecialchars($_POST['product_name']);
    $category_id = !empty($_POST['category_id']) ? (int) $_POST['category_id'] : 'NULL';
    $qty = htmlspecialchars($_POST['qty']);
    $price = htmlspecialchars($_POST['price']);
    $unit = htmlspecialchars($_POST['unit']);
    $description = mysqli_real_escape_string($koneksi, $_POST['description']);
    $is_active = htmlspecialchars($_POST['is_active']);

    mysqli_query($koneksi, "INSERT INTO products (product_image,product_name,category_id,qty,price,unit,description,is_active)
    VALUES ('$product_image','$product_name',$category_id,'$qty','$price','$unit','$description','$is_active')");

    header('location:?page=product&status=success');
    exit;
}

$editId = isset($_GET['edit']) ? (int) $_GET['edit'] : 0;
$edit = null;

if ($editId > 0) {
    $query = mysqli_query($koneksi, "SELECT * FROM products WHERE id='$editId'");
    $edit = mysqli_fetch_assoc($query);
}

if (isset($_POST['edit'])) {
    $product_image = $edit['product_image'];
    if (isset($_FILES['product_image']['name']) && $_FILES['product_image']['name'] != '') {
        $fileName = time() . '_' . basename($_FILES['product_image']['name']);
        move_uploaded_file($_FILES['product_image']['tmp_name'], __DIR__ . '/../assets/uploads/' . $fileName);
        $product_image = $fileName;
    }
    $product_name = htmlspecialchars($_POST['product_name']);
    $category_id = !empty($_POST['category_id']) ? (int) $_POST['category_id'] : 'NULL';
    $qty = htmlspecialchars($_POST['qty']);
    $price = htmlspecialchars($_POST['price']);
    $unit = htmlspecialchars($_POST['unit']);
    $description = mysqli_real_escape_string($koneksi, $_POST['description']);
    $is_active = htmlspecialchars($_POST['is_active']);

    mysqli_query($koneksi, "UPDATE products SET product_image='$product_image', product_name='$product_name', category_id=$category_id, qty='$qty', price='$price', unit='$unit', is_active='$is_active', description='$description' WHERE id='$editId'");
    header('location:?page=product&status=success');
    exit;
}

$queryParent = mysqli_query($koneksi, "SELECT * FROM categories ORDER BY category_name ASC");
$rowParent = mysqli_fetch_all($queryParent, MYSQLI_ASSOC);
?>

<div class="card">

    <h5 class="card-header">
        <?= $editId > 0 ? "Edit Product" : "Create Product" ?>
    </h5>

    <div class="card-body">

        <form action="" method="post" enctype="multipart/form-data">
            <div class="row g-3">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label" for="product-image">Product Image</label>
                        <input id="product-image" type="file" name="product_image" class="form-control"
                            <?= $editId === 0 ? 'required' : '' ?>>
                        <?php if ($editId > 0 && !empty($edit['product_image'])) : ?>
                            <div class="mt-2">
                                <small>Current file: <?= htmlspecialchars($edit['product_image']) ?></small>
                            </div>
                        <?php endif ?>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label" for="product-name">Product Name</label>
                        <input id="product-name" type="text" name="product_name" class="form-control"
                            value="<?= $editId > 0 ? htmlspecialchars($edit['product_name']) : '' ?>" required>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label" for="category">Category</label>
                        <select name="category_id" id="category" class="form-control" required>
                            <option value="">Select Category</option>
                            <?php foreach ($rowParent as $parent) : ?>
                                <option value="<?= $parent['id'] ?>"
                                    <?= $editId > 0 && $edit['category_id'] == $parent['id'] ? 'selected' : '' ?>>
                                    <?= htmlspecialchars($parent['category_name']) ?></option>
                            <?php endforeach ?>
                        </select>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label" for="qty">Quantity</label>
                        <input id="qty" type="number" name="qty" class="form-control"
                            value="<?= $editId > 0 ? htmlspecialchars($edit['qty']) : '' ?>" required>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label" for="price">Price</label>
                        <input id="price" type="text" name="price" class="form-control"
                            value="<?= $editId > 0 ? htmlspecialchars($edit['price']) : '' ?>" required>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label" for="unit">Unit</label>
                        <input id="unit" type="text" name="unit" class="form-control"
                            value="<?= $editId > 0 ? htmlspecialchars($edit['unit']) : '' ?>" required>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="mb-3">
                        <label class="form-label" for="description">Description</label>
                        <textarea id="description" name="description"
                            class="form-control"><?= $editId > 0 ? htmlspecialchars($edit['description']) : '' ?></textarea>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label d-block">Status</label>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" id="active" value="1" name="is_active"
                                <?= $editId === 0 || ($edit && $edit['is_active'] == 1) ? 'checked' : '' ?>>
                            <label class="form-check-label" for="active">Active</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" id="inactive" value="0" name="is_active"
                                <?= $edit && $edit['is_active'] == 0 ? 'checked' : '' ?>>
                            <label class="form-check-label" for="inactive">Inactive</label>
                        </div>
                    </div>
                </div>
            </div>

            <div class="text-end mt-2">
                <button type="submit" class="btn btn-primary" name="<?= $editId > 0 ? 'edit' : 'simpan' ?>">
                    <?= $editId > 0 ? 'Save Change' : 'Save' ?>
                </button>
                <a href="?page=product" class="btn btn-secondary">Batal</a>
            </div>

        </form>

    </div>
</div>