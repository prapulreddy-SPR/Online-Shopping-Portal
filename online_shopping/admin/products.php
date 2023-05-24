<?php
$active = "products";
$title = "Products";
require_once("shared/header.php");
require_once("../data_php/base.php");

//If not admin redirect to not authorized page
if (!isset($_SESSION["admin"])) {
  echo "<script>window.location='index.php'</script>";
}

if (isset($_REQUEST["delete"])) {
  $id = input("delete");
  $data = array("status" => false);
  update(json_sub_category, $data, array("id" => $id));
  echo "<script>alert('Deleted Successfully');window.location='save-product.php'</script>";
}
?>

<div class="content container-fluid">
  <div class="row">
    <div class="col-sm-3">
      <?php require_once("shared/sidebar.php"); ?>
    </div>
    <div class="col-sm-9">

      <div class="card mb-3">
        <div class="card-header">Products</div>
        <div class="card-body p-3">
        <div class="table-responsive">
            <table class="table table-bordered" id="table">
              <thead class="bg-secondary text-light">
                <th style="width:10%;">SNo</th>
                <th>Product Name</th>
                <th>Category</th>
                <th>Sub Category</th>
                <th>Company</th>
                <th>In stock</th>
                <th style="width: 15%;">Action</th>
              </thead>
              <tbody>
                <?php
                $sno = 0;
                $results = getAll(json_products, array("status" => true));
                krsort($results);
                foreach ($results as $row) : 
                $cat = get(json_category, array("id" => $row["category_id"]));
                $sub_cat = get(json_sub_category, array("id" => $row["sub_category_id"]));
                ?>
                  <tr class="<?= !$row["in_stock"] ? "bg-warning-subtle text-danger" : ""; ?>">
                    <td><?= ++$sno ?></td>
                    <td><?= $row["product_name"]; ?></td>
                    <td><?= $cat["category"]; ?></td>
                    <td><?= $sub_cat["sub_category"]; ?></td>
                    <td><?= $row["product_company"]; ?></td>
                    <td><?= $row["in_stock"] ? "Yes" : "No"; ?></td>
                    <td>
                      <a title="view product" href="view-product.php?id=<?= $row['id']; ?>" class="btn btn-sm btn-info"> <i class="fa fa-eye"></i> </a>
                      <a title="edit product" href="save-product.php?edit=<?= $row['id']; ?>" class="btn btn-sm btn-primary"> <i class="fa fa-edit"></i> </a>
                      <a title="delete product" href="save-product.php?delete=<?= $row['id']; ?>" onclick="return confirm('Are you sure? do you want to delete this.')" class="btn btn-sm btn-danger"> <i class="fa fa-trash-can"></i> </a>
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