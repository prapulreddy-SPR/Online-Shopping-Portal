<?php
$active = "sub_categories";
$title = "Sub Categories";
require_once("shared/header.php");
require_once("../data_php/base.php");

//If not admin redirect to not authorized page
if (!isset($_SESSION["admin"])) {
  echo "<script>window.location='index.php'</script>";
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {

  if (isset($_REQUEST["insert"])) {
    $values = array(
      "category_id" => (int)input("category_id"),
      "sub_category" => input("sub_category"),
      "status" => true
    );
    insert(json_sub_category, $values);
    echo "<script>alert('Saved Successfully');window.location='sub-category.php'</script>";
  }

  if (isset($_REQUEST["update"])) {
    $id = input("sub_category_id");
    $data = array(
      "category_id" => (int)input("category_id"),
      "sub_category" => input("sub_category"),
    );
    update(json_sub_category, $data, array("id" => $id));
    echo "<script>alert('Updated Successfully');window.location='sub-category.php'</script>";
  }
}

if (isset($_REQUEST["edit"])) {
  $id = input("edit");
  $res = get(json_sub_category, array("id" => $id, "status" => true));
}

if (isset($_REQUEST["delete"])) {
  $id = input("delete");
  $data = array("status" => false);
  update(json_sub_category, $data, array("id" => $id));
  echo "<script>alert('Deleted Successfully');window.location='sub-category.php'</script>";
}
?>

<div class="content container-fluid">
  <div class="row">
    <div class="col-sm-3">
      <?php require_once("shared/sidebar.php"); ?>
    </div>
    <div class="col-sm-9">

      <div class="card mb-3">
        <div class="card-header">Sub Category</div>
        <div class="card-body p-4">
          <form action="<?= htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="POST">

            <div class="row mb-3">
              <label for="category_id" class="col-sm-2 col-form-label">Categories</label>
              <div class="col-sm-6">
                <select name="category_id" id="category_id" class="form-control" required>
                  <option value="">-- Select Category --</option>
                  <?php
                  $result = getAll(json_category, array("status" => true));
                  foreach ($result as $row) {?>
                    <option value="<?= $row['id'] ?>" <?= $res['category_id'] == $row['id'] ? 'selected' : '' ?>><?= $row['category'] ?></option>
                  <?php } ?>
                </select>
              </div>
            </div>

            <div class="row mb-3">
              <label for="sub_category" class="col-sm-2 col-form-label">Sub Category</label>
              <div class="col-sm-6">
                <input type="text" class="form-control" name="sub_category" id="sub_category" value="<?= $res['sub_category'] ?>" required>
              </div>
            </div>

            <input type="hidden" name="sub_category_id" value="<?= $res["id"] ?>">
            <input type="submit" value="<?= (isset($_REQUEST['edit']) ? 'Update' : 'Insert'); ?>" name="<?= (isset($_REQUEST['edit']) ? 'update' : 'insert'); ?>" class="btn btn-secondary offset-sm-2">
            <?php if (isset($_REQUEST["edit"])) : ?>
              <a href="category.php" class="btn btn-warning">Cancel</a>
            <?php endif ?>

          </form>
        </div>
      </div>

      <!-- Display Categories -->

      <div class="card">
        <div class="card-header">Manage Sub Categories</div>
        <div class="card-body">
          <div class="table-responsive">
            <table class="table table-bordered" id="table">
              <thead class="bg-secondary text-light">
                <th style="width:10%;">SNo</th>
                <th>Category</th>
                <th>Sub Category</th>
                <th style="width: 15%;">Action</th>
              </thead>
              <tbody>
                <?php
                $sno = 0;
                $results = getAll(json_sub_category, array("status" => true));
                krsort($results);
                foreach ($results as $row) : 
                $cat = get(json_category, array("id" => $row["category_id"]));
                ?>
                  <tr>
                    <td><?= ++$sno ?></td>
                    <td><?= $cat["category"]; ?></td>
                    <td><?= $row["sub_category"]; ?></td>
                    <td>
                      <a href="sub-category.php?edit=<?= $row['id']; ?>" class="btn btn-sm btn-primary"> <i class="fa fa-edit"></i> </a>
                      <a href="sub-category.php?delete=<?= $row['id']; ?>" onclick="return confirm('Are you sure? do you want to delete this.')" class="btn btn-sm btn-danger"> <i class="fa fa-trash-can"></i> </a>
                    </td>
                  </tr>
                <?php endforeach ?>
              </tbody>
            </table>
          </div>
        </div>
      </div>

    </div>
  </div>

</div>

<?php require_once("shared/footer.php"); ?>