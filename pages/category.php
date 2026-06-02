<?php
$query = mysqli_query($koneksi, "SELECT categories.*  FROM categories ORDER BY id DESC ");
$rows = mysqli_fetch_all($query, MYSQLI_ASSOC);

if (isset($_GET['delete'])) {
    $id = $_GET['delete'] ?? 0;
    $delete = mysqli_query($koneksi, "DELETE FROM categories WHERE id='$id'");
    header("location:?page=category");
    exit();
}
?>
<div class="card">
    <div class="card-header">
        <h5 class="cart-title">
            Manage Category
        </h5>
    </div>
    <div class="card-body">
        <div class="mb-2 d-flex justify-content-end">
            <a href="?page=create-category" class="btn btn-primary">Create Category</a>
        </div>
        <div class="table-responsive">
            <?php
            if (isset($_GET['status']) && $_GET['status'] == 'success') {
                $status = "Data Berhasil ditambah!";
                $location = "?page=category";
                echo statusSuccess($status, $location);
            }

            ?>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Category</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    foreach ($rows as $index => $r) {
                    ?>
                        <tr>
                            <td><?= $index + 1 ?></td>
                            <td><?= $r['category_name'] ?></td>
                            <td>
                                <a href="?page=create-category&edit=<?= $r['id'] ?>" class="btn btn-success">Edit</a>
                                <form action="?page=category&delete=<?= $r['id'] ?>" method="post" class="d-inline">
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