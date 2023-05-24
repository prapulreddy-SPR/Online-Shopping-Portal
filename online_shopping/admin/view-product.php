<?php
$active = "products";
$title = "View Products";
require_once("shared/header.php");
require_once("../data_php/base.php");

//If not admin redirect to not authorized page
if (!isset($_SESSION["admin"])) {
  echo "<script>window.location='index.php'</script>";
}


if (isset($_REQUEST["id"])) {
  $id = input("id");
  $res = get(json_products, array("id" => $id, "status" => true));
}


?>

<div class="content container-fluid">
  <div class="row">
    <div class="col-sm-3">
      <?php require_once("shared/sidebar.php"); ?>
    </div>
    <div class="col-sm-9">

      <div class="card">
        <div class="card-header">Product Details</div>
        <div class="card-body p-4">

        <div class="row">
        <div class="col-sm-3">
            <img src="<?= base_url_admin?>/images/products/<?= $res['image_filename']?>" alt="" class="w-100">
          </div>
          <div class="col-sm-9">
            <table class="table table-bordered mb-5">
              <tr>
                <th style="width:30%;">Product Id</th>
                
                <td><?= $res["id"];?></td>
              </tr>
              <tr>
                <th>Product Name</th>
                
                <td><?= $res["product_name"];?></td>
              </tr>
              <tr>
                <th>Product Company</th>
                
                <td><?= $res["product_company"];?></td>
              </tr>
              <tr>
                <th>Product Price</th>
                
                <td>$ <?= number_format((float)$res["price"], 2, '.', '') ;?></td>
              </tr>
              <tr>
                <th>Shipping Charge</th>
                
                <td>$ <?= number_format((float)$res["shipping_charge"], 2, '.', '');?></td>
              </tr>
              <tr>
                <th>In Stock</th>
                
                <td><?= $res["in_stock"] ? "Yes" : "No";?></td>
              </tr>
            </table>

            <h3 class="mb-4">Product Descriptions</h3>
            <div class="product-description"><?= html_entity_decode(html_entity_decode($res["description"]))?></div>
          </div>
          
        </div>

        </div>
      </div>
      
    </div>
  </div>

</div>

<?php require_once("shared/footer.php"); ?>