<?php
if (isset($_POST['simpan'])) {
    $name = htmlspecialchars($_POST['name']);
    $url = htmlspecialchars($_POST['url']);
    $icon = htmlspecialchars($_POST['icon']);
    $parent_id = htmlspecialchars($_POST['parent_id'] ?: 'NULL');
    $is_active = htmlspecialchars($_POST['is_active']);
    $sort_order = $_POST['sort_order'];


    mysqli_query($koneksi, "INSERT INTO menus (name, parent_id, url, icon, is_active, sort_order) 
    VALUES ('$name',$parent_id,'$url','$icon','$is_active','$sort_order')");
    header('location:?page=menu&status=success');
}

// $id = isset($_GET['idEdit']) ? $_GET['idEdit'] : ''; 
$id = $_GET['edit'] ?? '';
$query = mysqli_query($koneksi, "SELECT * FROM menus WHERE id='$id' ");
$rEdit = mysqli_fetch_assoc($query); // data dari table roles


if (isset($_POST['edit'])) {
    $name = htmlspecialchars($_POST['name']);
    $url = htmlspecialchars($_POST['url']);
    $icon = htmlspecialchars($_POST['icon']);
    $parent_id = htmlspecialchars($_POST['parent_id'] ?: 'NULL');
    $is_active = htmlspecialchars($_POST['is_active']);
    $sort_order = $_POST['sort_order'];

    mysqli_query($koneksi, "UPDATE menus SET name='$name', is_active='$is_active', parent_id=$parent_id, url='$url', icon='$icon' , sort_order='$sort_order'
    WHERE id='$id'");
    header('location:?page=menu');
}

// 
$queryParent = mysqli_query($koneksi, "SELECT * FROM menus WHERE parent_id IS NULL");
$rowParent = mysqli_fetch_all($queryParent, MYSQLI_ASSOC);

?>

<div class="card">
    <h5 class="card-header">
        <?= isset($_GET['edit']) ? "Edit" : "Create" ?> New Menu
    </h5>
    <div class="card-body">

        <form action="" method="post">
            <div class="row mb-3">
                <div class=" col-6">
                    <label for="" class="form-label">Name</label>
                    <input type="text" name="name" value="<?= isset($_GET['edit']) ? $rEdit['name'] : '' ?>"
                        class="form-control" required placeholder="Enter your name">
                </div>
                <div class="col-6 mb-3">
                    <label class="form-label" for="parent-id">Parent Id</label>
                    <select name="parent_id" id="parent-id" class="form-control">
                        <option value="">Select One</option>
                        <?php foreach ($rowParent as $parent) : ?>
                            <option value="<?= $parent['id'] ?>"><?= $parent['name'] ?></option>
                        <?php endforeach ?>
                    </select>
                </div>
                <div class="col-6">
                    <label for="" class="form-label">Icon</label>
                    <input type="text" class="form-control" name="icon" placeholder="Enter Icon you want" value="<?= $id ? $rEdit['icon'] : '' ?>">
                </div>
                <div class="col-6">
                    <label for="" class="form-label">Url</label>
                    <input type="text" class="form-control" name="url" placeholder="Enter url" value="<?= $id ? $rEdit['url'] : '' ?>">
                </div>
            </div>
            <div class="row">
                <div class="col-6">
                    <label for="" class="form-label">Sort Order</label>
                    <input type="text" class="form-control" name="sort_order" placeholder="Enter your sort order" value="<?= $id ? $rEdit['sort_order'] : '' ?>">
                </div>

                <div class="col-6">
                    <label for="" class="form-label">Status</label>
                    <input type="radio" name="is_active" value="1" <?= $id ? ($rEdit['is_active'] == 1) ? 'checked' : '' : 'checked' ?>> Active
                    <input type="radio" name="is_active" value="0" <?= $id ? ($rEdit['is_active'] == 0) ? 'checked' : '' : '' ?>> Inactive
                </div>
            </div>

            <div class="text-end mt-2 ">
                <button type="submit" class="btn btn-primary" name="<?= isset($_GET['edit']) ? 'edit' : 'simpan' ?>">
                    <?= isset($_GET['edit']) ? 'Save Change' : 'Save' ?>
                </button>
                <a href="?page=menu" class="btn btn-secondary">Cancel</a>
            </div>

        </form>
    </div>
</div>