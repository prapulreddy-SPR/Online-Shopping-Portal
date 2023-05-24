<?php
$active = "orders";
$title = "Orders";
require_once("shared/header.php");
require_once("../data_php/base.php");

//If not admin redirect to not authorized page
if (!isset($_SESSION["admin"])) {
  echo "<script>window.location='index.php'</script>";
}

$order_id = input("oid");
$order = get(json_orders, array("id" => $order_id));
$user = get(json_users, array("id" => $order["user_id"]));
?>

<div class="content container-fluid">
  <div class="row">
    <div class="col-sm-3">
      <?php require_once("shared/sidebar.php"); ?>
    </div>
    <div class="col-sm-9">

      <div class="card mb-3">
        <div class="card-header">Orders</div>
        <div class="card-body p-3">

          <div class="row g-3">
            <div class="col-sm-5">
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
                  <td class="pb-2"> : <span class="bg-warning p-1"><?= $order["payment_status"]; ?></span> </td>
                </tr>
                <tr>
                  <th class="pb-2">Order Status</th>
                  <td class="pb-2"> : <span class="bg-warning p-1"><?= $order["order_status"]; ?></td>
                </tr>
                <tr>
                  <th class="pb-2">Order Amount</th>
                  <td class="pb-2"> : <span class="">$ <?= $order["order_amount"]; ?> </span></td>
                </tr>
              </table>
            </div>
            <div class="col-sm-7">
              <table>
                <tr>
                  <th class="pb-2">Customer Name</th>
                  <td class="pb-2"> : <?= $user["first_name"] . " " . $user["last_name"]; ?></td>
                </tr>
                <tr>
                  <th class="pb-2">Contact No</th>
                  <td class="pb-2"> : <?= $user["contact_no"]; ?></td>
                </tr>
                <tr>
                  <th class="pb-2">Delivery Address</th>
                  <td class="pb-2"> : <?= $order["shipping_address"]; ?></td>
                </tr>
              </table>
            </div>
            <div class="col-sm-12">
              <div class="table-responsive">
                <table class="table table-bordered">
                  <thead>
                    <th>#</th>
                    <th style="width:20%;">Image</th>
                    <th>Product</th>
                    <th>Price</th>
                    <th>Quantity</th>
                    <th>Shipping</th>
                    <th>Amount</th>
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
                          <img src="<?= base_url_admin ?>/images/products/<?= $product["image_filename"] ?>" class="cover-cart">
                        </td>
                        <td><?= $product["product_name"] ?></td>
                        <td>$&nbsp;<?= $item["price"] ?></td>
                        <td><?= $item["quantity"] ?></td>
                        <td>$&nbsp;<?= $item["shipping_charge"] ?></td>
                        <td>$&nbsp;<?= $item["sub_total"] ?></td>
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
  </div>

</div>

<?php require_once("shared/footer.php"); ?>