<?php
$cur_page = "orders";
$title = "Order History";
require_once("shared/header.php");

//If not logged in redirect to not home page
if (!isset($_SESSION["user"])) {
  echo "<script>window.location='index.php'</script>";
}

if (isset($_REQUEST["cancel"])) {
  $order_id = input("cancel");
  $update = array("order_status" => "Cancelled");
  update(json_orders, $update, array("id" => $order_id));
  echo "<script>alert('Order Cancelled');window.location='orders.php'</script>";
}

$order_id = input("oid");
$order = get(json_orders, array("id" => $order_id));

?>

<section class="content container">

  <div class="my-account my-4">
    <div class="d-flex justify-content-center gap-3">
      <a href="my-account.php" class="btn btn-outline-success">My Profile</a>
      <a href="change-password.php" class="btn btn-outline-success">Change Password</a>
      <a href="orders.php" class="btn btn-outline-success">Order History</a>
      <a href="order-details.php" class="btn btn-success">Order Details</a>
    </div>
  </div>
  <hr>

  <div class="border p-2">
    <h5 class="mb-4">Order Details</h5>
    <div class="row">
      <div class="col-sm-4">
        <table>
          <tr>
            <th class="pb-2">Order Id</th>
            <td class="pb-2"> : # <?= $order["order_id"]; ?></td>
          </tr>
          <tr>
            <th class="pb-2">Order Date</th>
            <td class="pb-2"> : <?= $order["order_date"]; ?></td>
          </tr>
          <tr>
            <th class="pb-2">Payment Status</th>
            <td class="pb-2"> : <?= $order["payment_status"]; ?></td>
          </tr>
          <tr>
            <th class="pb-2">Order Status</th>
            <td class="pb-2"> : <?= $order["order_status"]; ?></td>
          </tr>
          <tr>
            <th class="pb-2">Order Amount</th>
            <td class="pb-2"> : <span class="">$ <?= $order["order_amount"]; ?> </span></td>
          </tr>
        </table>
      </div>
      <div class="col-sm-8">
        <div class="table-responsive">
          <table class="table table-bordered">
            <thead>
              <th>#</th>
              <th style="width:10%;">Image</th>
              <th>Product</th>
              <th>Price</th>
              <th>Quantity</th>
              <th>Shipping</th>
              <th>Amount</th>
              <th>Action</th>
            </thead>
            <tbody>
              <?php
              $sno = 0;
              $order_items = getAll(json_order_items, array("order_id" => $order["order_id"]));
              foreach ($order_items as $item) :
                $product = get(json_products, array("id" => $item["product_id"])); ?>
                <tr>
                  <td><?= ++$sno; ?></td>
                  <td>
                    <img src="<?= base_url ?>/images/products/<?= $product["image_filename"]?>" class="cover-cart">
                  </td>
                  <td><?= $product["product_name"]?></td>
                  <td>$&nbsp;<?= $item["price"]?></td>
                  <td><?= $item["quantity"]?></td>
                  <td>$&nbsp;<?= $item["shipping_charge"]?></td>
                  <td>$&nbsp;<?= $item["sub_total"]?></td>
                  <td>
                    <?php if($order["order_status"] == "Delivered"):?>
                      <a href="review.php?pid=<?= $product["id"]?>&oid=<?= $order["id"]?>" class="btn btn-sm btn-warning">Review</a>
                      <?php endif?>
                  </td>
                </tr>
              <?php endforeach ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>

</section>



<?php
require_once("shared/footer.php");
?>