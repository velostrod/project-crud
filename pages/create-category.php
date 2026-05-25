<?php
if (isset($_POST['simpan'])) {


    $category_name = htmlspecialchars($_POST['category_name']);
    $cek = mysqli_query($koneksi, "SELECT category_name FROM categories WHERE category_name='$category_name'");
    if (mysqli_num_rows($cek) > 0) {
        header('location:?page=create-category&status=category-exist');
        exit();
    }
    $query = mysqli_query($koneksi, "INSERT INTO  categories (category_name) VALUES ('$category_name')");
    if ($query) {
        header('location:?page=category&status=success');
        exit();
    }
}

$editId = isset($_GET['edit']) ? (int) $_GET['edit'] : 0;
$edit = null;

if ($editId > 0) {
    $query = mysqli_query($koneksi, "SELECT * FROM categories WHERE id='$editId'");
    $edit = mysqli_fetch_assoc($query);
}

if (isset($_POST['edit'])) {


    $category_name = htmlspecialchars($_POST['category_name']);
    $cek = mysqli_query($koneksi, "SELECT category_name FROM categories WHERE category_name='$category_name'");
    if (mysqli_num_rows($cek) > 0) {
        header('location:?page=create-category&edit=' . $_GET['edit'] . '&status=warning');
        exit();
    }
    mysqli_query($koneksi, "UPDATE categories SET category_name='$category_name' WHERE id='$editId'");

    header('location:?page=category&status=success');
    exit();
}

// $queryParent = mysqli_query($koneksi, "SELECT * FROM categories WHERE parent_id IS NULL OR parent_id = 0");
// $rowParent = mysqli_fetch_all($queryParent, MYSQLI_ASSOC)
?>

<div class="card">

    <h5 class="card-header">
        <?= $editId > 0 ? "Edit Category" : "Create Category" ?>
    </h5>

    <div class="card-body">

        <form action="" method="post">
            <div class="row g-3">
                <?php
                if (isset($_GET['status']) && $_GET['status'] == 'warning') {
                    $status = "Data already exist!";
                    $location = "?page=warning";
                    echo inputFailed($status, $location);
                }
                ?>
                <div class="col-md-12">

                    <div class="mb-3">
                        <label class="form-label" for="category_name">Category_Name</label>
                        <input id="category_name" type="text" name="category_name" class="form-control"
                            value="<?= $editId > 0 ? htmlspecialchars($edit['category_name']) : '' ?>" required>
                        <?php
                        $status = '';
                        if (isset($_GET['status']) && $_GET['status'] == 'category-exist') {
                            $status = "category Name Already Exist!";
                        }
                        // echo inputFailed($status, '');
                        ?>
                    </div>
                </div>
            </div>

            <div class="text-end mt-2">
                <button type="submit" class="btn btn-primary" name="<?= $editId > 0 ? 'edit' : 'simpan' ?>">
                    <?= $editId > 0 ? 'Save Change' : 'Save' ?>
                </button>
                <a href="?page=category" class="btn btn-secondary">Batal</a>
            </div>

        </form>

    </div>

</div>