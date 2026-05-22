<?php
$query = mysqli_query($koneksi, "SELECT parent.name as parent_name, menus.* FROM menus LEFT JOIN menus as parent ON parent.id = menus.parent_id ORDER BY menus.id DESC"); //5,4,3,2,1
$rows = mysqli_fetch_all($query, MYSQLI_ASSOC);
// print_r($rows);
// die;


if (isset($_GET['delete'])) {
    $id = $_GET['delete'] ?? 0;
    $delete = mysqli_query($koneksi, "DELETE FROM menus WHERE id='$id'");
    header("location:?page=menu");
    exit();
}

?>

<div class="card">
    <h5 class="card-header ">
        Menu
    </h5>
    <div class="card-body">
        <div class="mb-2" align="right">
            <a href="?page=create-menu" class="btn btn-primary">Create New Menu</a>
        </div>
        <div class="table-responsive">
            <?php
            if (isset($_GET['status']) && $_GET['status'] == 'success') {
                $status = "Role create successfully!";
                $location = "?page=menu";
                echo statusSuccess($status, $location);
            }
            ?>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Parent</th>
                        <th>Name</th>
                        <th>Url</th>
                        <th>Icon</th>
                        <th>Order</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    foreach ($rows as $index => $r) {
                    ?>
                        <tr>
                            <td><?= $index + 1 ?></td>
                            <td><?= $r['parent_name'] ?></td>
                            <td><?= $r['name'] ?></td>
                            <td><?= $r['url'] ?></td>
                            <td><?= $r['icon'] ?></td>
                            <td><?= $r['sort_order'] ?></td>
                            <td><?php echo getStatus($r['is_active']) ?></td>
                            <td>
                                <a href="?page=create-menu&edit=<?= $r['id'] ?>" class="btn btn-success">Edit</a>
                                <form action="?page=menu&delete=<?= $r['id'] ?> ?>" method="post" class="d-inline">
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