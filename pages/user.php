<?php
$selectUser = mysqli_query($koneksi, "SELECT * FROM users");
$rows = mysqli_fetch_all($selectUser, MYSQLI_ASSOC);


if (isset($_GET['idDelete'])) {
    $id = $_GET['idDelete'] ?? 0;
    $delete = mysqli_query($koneksi, "DELETE FROM users WHERE id='$id'");
    header("location:?page=user");
    exit();
}

?>

<div class="card">
    <div class="card-header text-center">
        <h2 class="card-title">
            Users
        </h2>
    </div>
    <div class="card-body">
        <div class="mb-2">
            <a href="?page=user-create-edit" class="btn btn-primary">Create</a>
        </div>
        <div class="table-responsive">
            <?php
            if (isset($_GET['status']) && $_GET['status'] == 'success') {
                $status = "Data Berhasil ditambah";
                $location = "?page=user";
                echo statusSucces($status, $location);
            }

            ?>


            <table class="table table-bordered text-center">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama</th>
                        <th>Email</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    foreach ($rows as $index => $r) {

                    ?>
                        <tr>
                            <td><?php echo $index + 1 ?></td>
                            <td><?php echo $r['name'] ?></td>
                            <td><?php echo $r['email'] ?></td>
                            <td>
                                <a href="?page=user-create-edit&idEdit=<?php echo $r['id'] ?>" class="btn btn-success">Edit</a>
                                <form action="?page=user&idDelete=<?php echo $r['id'] ?>" method="post" class="d-inline">
                                    <button class="btn btn-danger">Delete</button>
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