<?php
$query = mysqli_query($koneksi, "SELECT * FROM roles ORDER BY id DESC "); //5,4,3,2,1
$rows = mysqli_fetch_all($query, MYSQLI_ASSOC);


if (isset($_GET['delete'])) {
    $id = $_GET['delete'] ?? 0;
    $delete = mysqli_query($koneksi, "DELETE FROM roles WHERE id='$id'");
    header("location:?page=role");
    exit();
}

?>

<div class="card">
    <h5 class="card-header ">
        Manage Role
    </h5>
    <div class="card-body">
        <div class="mb-2" align="right">
            <a href="?page=create-role" class="btn btn-primary">+ Create New Role</a>
        </div>
        <div class="table-responsive">
            <?php
            if (isset($_GET['status']) && $_GET['status'] == 'success') {
                $status = "Role create successfully!";
                $location = "?page=role";
                echo statusSuccess($status, $location);
            }
            ?>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Name</th>
                        <th>Description</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    foreach ($rows as $index => $r) {
                    ?>
                        <tr>
                            <td><?= $index + 1 ?></td>
                            <td><?= $r['name'] ?></td>
                            <td><?= $r['description'] ?></td>
                            <td><?php echo getStatus($r['is_active']) ?></td>
                            <td>
                                <a href="?page=create-role&edit=<?= $r['id'] ?>" class="btn btn-success">Edit</a>
                                <form action="?page=role&delete=<?= $r['id'] ?> ?>" method="post" class="d-inline">
                                    <button class="btn btn-danger" onclick="return confirm('Are you sure?')">Delete</button>
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