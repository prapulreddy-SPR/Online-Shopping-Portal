<?php
$active = "save_product";
$title = "Products";
require_once("shared/header.php");
require_once("../data_php/base.php");

//If not admin redirect to not authorized page
if (!isset($_SESSION["admin"])) {
  echo "<script>window.location='index.php'</script>";
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {

  $image_filename = input("image_filename");

  if (is_uploaded_file($_FILES["image"]["tmp_name"])) {
    if (!$image_filename) {
      $image_filename = uploadFiles("../images/products/", $_FILES["image"], true);
    }
    else{
      $filepath = "../images/products/" . $image_filename;
      if (file_exists($filepath)) {
        unlink($filepath);
      }
      $image_filename = uploadFiles("../images/products/", $_FILES["image"], true);
    }
  }  

  $values = array(
    "category_id" => (int)input("category_id"),
    "sub_category_id" => (int)input("sub_category_id"),
    "product_name" => input("product_name"),
    "product_company" => input("product_company"),
    "price" => (float)input("price"),
    "description" => htmlentities(input("description")),
    "shipping_charge" => (float)input("shipping_charge"),
    "in_stock" => (input("in_stock") == "Yes" ? true : false),
    "image_filename" => $image_filename
  );

  if (isset($_REQUEST["insert"])) {
    $values["status"] = true;
    insert(json_products, $values);
    echo "<script>alert('Saved Successfully');window.location='products.php'</script>";
  }

  if (isset($_REQUEST["update"])) {
    $id = input("product_id");
    update(json_products, $values, array("id" => $id));
    echo "<script>alert('Updated Successfully');window.location='products.php'</script>";
  }
}

if (isset($_REQUEST["edit"])) {
  $id = input("edit");
  $res = get(json_products, array("id" => $id, "status" => true));
}

if (isset($_REQUEST["delete"])) {
  $id = input("delete");
  $data = array("status" => false);
  update(json_sub_category, $data, array("id" => $id));
  echo "<script>alert('Deleted Successfully');window.location='products.php'</script>";
}
?>

<div class="content container-fluid">
  <div class="row">
    <div class="col-sm-3 mb-3">
      <?php require_once("shared/sidebar.php"); ?>
    </div>
    <div class="col-sm-9">

      <div class="card mb-3">
        <div class="card-header">Products</div>
        <div class="card-body p-3">
          <form action="<?= htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="POST" enctype="multipart/form-data">

            <div class="row mb-3">
              <label for="category_id" class="col-form-label col-sm-3 text-sm-end">Category</label>
              <div class="col-sm-8">
                <select name="category_id" id="category_id" onchange="getSubCategory(this.value)" class="form-select" required>
                  <option value="">-- Select Category --</option>
                  <?php
                  $result = getAll(json_category, array("status" => true));
                  foreach ($result as $row) { ?>
                    <option value="<?= $row['id'] ?>" <?= $res['category_id'] == $row['id'] ? 'selected' : '' ?>><?= $row['category'] ?></option>
                  <?php } ?>
                </select>
              </div>
            </div>

            <div class="row mb-3">
              <label for="sub_category_id" class="col-form-label col-sm-3 text-sm-end">Sub Category</label>
              <div class="col-sm-8">
                <select name="sub_category_id" id="sub_category_id" class="form-select" required>
                  <option value="">-- Select Sub Category --</option>                  
                    <?php
                    if ($res) :
                      $result = getAll(json_sub_category, array("status" => true));
                      foreach ($result as $row) : ?>
                        <option value="<?= $row['id'] ?>" <?= $res['sub_category_id'] == $row['id'] ? 'selected' : '' ?>><?= $row['sub_category'] ?></option>
                    <?php
                      endforeach;
                    endif ?>
                </select>
              </div>
            </div>

            <div class="row mb-3">
              <label for="product_name" class="col-form-label col-sm-3 text-sm-end">Product Name</label>
              <div class="col-sm-8">
                <input type="text" class="form-control" name="product_name" id="product_name" value="<?= $res['product_name']?>" required>
              </div>
            </div>

            <div class="row mb-3">
              <label for="product_company" class="col-form-label col-sm-3 text-sm-end">Product Company</label>
              <div class="col-sm-8">
                <input type="text" class="form-control" name="product_company" id="product_company" value="<?= $res['product_company']?>" required>
              </div>
            </div>

            <div class="row mb-3">
              <label for="price" class="col-form-label col-sm-3 text-sm-end">Product Price</label>
              <div class="col-sm-8">
                <input type="text" min="1" class="form-control" name="price" id="price" value="<?= $res['price']?>" required>
              </div>
            </div>

            <div class="row mb-3">
              <label for="description" class="col-form-label col-sm-3 text-sm-end">Description</label>
              <div class="col-sm-8">
                <textarea name="description" id="summernote"><?= html_entity_decode($res['description'])?></textarea>
              </div>
            </div>

            <div class="row mb-3">
              <label for="shipping_charge" class="col-form-label col-sm-3 text-sm-end">Shipping Charge</label>
              <div class="col-sm-8">
                <input type="text" class="form-control" name="shipping_charge" id="shipping_charge" value="<?= $res['shipping_charge']?>" required>
              </div>
            </div>

            <div class="row mb-3">
              <label for="in_stock" class="col-form-label col-sm-3 text-sm-end">In Stock</label>
              <div class="col-sm-8">
                <select name="in_stock" id="in_stock" class="form-select">
                  <option <?= $res["in_stock"] ? "selected" : "" ?>>Yes</option>
                  <option <?= !$res["in_stock"] ? "selected" : "" ?>>No</option>
                </select>
              </div>
            </div>

            <div class="row mb-3">
              <label for="image" class="col-form-label col-sm-3 text-sm-end">Product Image</label>
              <div class="col-sm-8">
                <input type="file" name="image" id="image" class="form-control">
                <input type="hidden" name="image_filename" value="<?= $res['image_filename']?>">
              </div>
            </div>

            <input type="hidden" name="product_id" value="<?= $res["id"] ?>">
            <input type="submit" value="<?= (isset($_REQUEST['edit']) ? 'Update' : 'Insert'); ?>" name="<?= (isset($_REQUEST['edit']) ? 'update' : 'insert'); ?>" class="btn btn-dark offset-sm-3">
            <?php if (isset($_REQUEST["edit"])) : ?>
              <a href="products.php" class="btn btn-warning">Cancel</a>
            <?php endif ?>

          </form>
        </div>
      </div>

    </div>
  </div>

</div>

<?php require_once("shared/footer.php"); ?>