<?php
$active = "categories";
$title = "Admin Categories";
require_once("shared/header.php");
require_once("../data_php/base.php");

//If not admin redirect to not authorized page
if (!isset($_SESSION["admin"])) {
  echo "<script>window.location='index.php'</script>";
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {

  if (isset($_REQUEST["insert"])) {
    $values = array(
      "category" => input("category"),
      "status" => true
    );
    insert(json_category, $values);
    echo "<script>alert('Saved Successfully');window.location='category.php'</script>";
  }

  if (isset($_REQUEST["update"])) {
    $id = input("category_id");
    $data = array(
      "category" => input("category")
    );
    update(json_category, $data, array("id" => $id));
    echo "<script>alert('Updated Successfully');window.location='category.php'</script>";
  }
}

if (isset($_REQUEST["edit"])) {
  $id = input("edit");
  $res = get(json_category, array("id" => $id, "status" => true));
}

if (isset($_REQUEST["delete"])) {
  $id = input("delete");
  $data = array("status" => false);
  update(json_category, $data, array("id" => $id));
  echo "<script>alert('Deleted Successfully');window.location='category.php'</script>";
}

?>

<div class="content container-fluid">
  <div class="row">
    <div class="col-sm-3">
      <?php require_once("shared/sidebar.php"); ?>
    </div>
    <div class="col-sm-9">
      
      <div class="card mb-3">
        <div class="card-header">Category</div>
        <div class="card-body p-4">
          <form action="<?= htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="POST">
            <div class="row align-items-center">
              <div class="col-sm-4 text-end">
                <label for="category" class="col-form-label">Category</label>
              </div>
              <div class="col-sm-4">
                <input type="text" class="form-control" name="category" id="category" value="<?= $res["category"] ?>" required>
              </div>
              <div class="col-sm-4">
                <input type="hidden" name="category_id" value="<?= $res["id"] ?>">
                <input type="submit" value="<?= (isset($_REQUEST['edit']) ? 'Update' : 'Insert'); ?>" name="<?= (isset($_REQUEST['edit']) ? 'update' : 'insert'); ?>" class="btn btn-secondary">
                <?php if (isset($_REQUEST["edit"])) : ?>
                  <a href="category.php" class="btn btn-warning">Cancel</a>
                <?php endif ?>
              </div>
            </div>
          </form>
        </div>
      </div>

      <!-- Display Categories -->

      <div class="card">
        <div class="card-header">Manage Categories</div>
        <div class="card-body">
          <div class="table-responsive">
            <table class="table table-bordered" id="table">
              <thead class="bg-secondary text-light">
                <th style="width:10%;">SNo</th>
                <th>Category</th>
                <th style="width: 15%;">Action</th>
              </thead>
              <tbody>
                <?php
                $sno = 0;
                $results = getAll(json_category, array("status" => true));
                krsort($results);
                foreach ($results as $row) : ?>
                  <tr>
                    <td><?= ++$sno ?></td>
                    <td><?= $row["category"]; ?></td>
                    <td>
                      <a href="category.php?edit=<?= $row['id']; ?>" class="btn btn-sm btn-primary"> <i class="fa fa-edit"></i> </a>
                      <a href="category.php?delete=<?= $row['id']; ?>" onclick="return confirm('Are you sure? do you want to delete this.')" class="btn btn-sm btn-danger"> <i class="fa fa-trash-can"></i> </a>
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