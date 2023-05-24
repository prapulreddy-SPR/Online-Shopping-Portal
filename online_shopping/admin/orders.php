<?php
$active = "orders";
$title = "Orders";
require_once("shared/header.php");
require_once("../data_php/base.php");

//If not admin redirect to not authorized page
if (!isset($_SESSION["admin"])) {
  echo "<script>window.location='index.php'</script>";
}

if(isset($_REQUEST["update_order_status"]))
{
  $order_id = input("oid");
  $status = input("update_order_status");
  $data = array("order_status"=>$status);
  update(json_orders, $data, array("id"=>$order_id));
  echo "<script>alert('Order Status Updated Successfully');window.location='orders.php'</script>";
}

if(isset($_REQUEST["update_payment_status"]))
{
  $order_id = input("oid");
  $status = input("update_payment_status");
  $data = array("payment_status"=>$status);
  update(json_orders, $data, array("id"=>$order_id));
  echo "<script>alert('Payment Status Updated Successfully');window.location='orders.php'</script>";
}

$filter = [];

if (isset($_REQUEST["status"])) {
  $status = input("status");
  $filter = array("order_status" => $status);
}

$orders = getAll(json_orders, $filter);


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
          <div class="d-flex justify-content-center gap-3 mb-5">
            <a href="orders.php?status=Pending" class="btn btn-sm btn-<?= $_REQUEST["status"] == 'Pending' ? 'dark' : 'outline-dark'?>">Pending</a>

            <a href="orders.php?status=Confirmed" class="btn btn-sm btn-<?= $_REQUEST["status"] == 'Confirmed' ? 'dark' : 'outline-dark'?>">Confirmed</a>

            <a href="orders.php?status=Shipped" class="btn btn-sm btn-<?= $_REQUEST["status"] == 'Shipped' ? 'dark' : 'outline-dark'?>">Shipped</a>

            <a href="orders.php?status=Delivered" class="btn btn-sm btn-<?= $_REQUEST["status"] == 'Delivered' ? 'dark' : 'outline-dark'?>">Delivered</a>

            <a href="orders.php?status=Cancelled" class="btn btn-sm btn-<?= $_REQUEST["status"] == 'Cancelled' ? 'dark' : 'outline-dark'?>">Cancelled</a>

            <a href="orders.php" class="btn btn-sm btn-<?= (!isset($_REQUEST["status"])) ? 'dark' : 'outline-dark'?>">All</a>
          </div>
          <div class="table-responsive">
            <table class="table table-bordered" id="table">
              <thead>
                <th>SNo</th>
                <th>Order&nbsp;Id</th>
                <th>Order&nbsp;Amount</th>
                <th>Payment&nbsp;Status</th>
                <th>Order&nbsp;Status</th>
                <th>Update&nbsp;Status</th>
              </thead>
              <tbody>
                <?php
                $sno = 0;
                krsort($orders);
                foreach ($orders as $value) :
                ?>
                  <tr class="<?= $value["order_status"] == 'Cancelled'?'text-danger':''?>">
                    <td><?= ++$sno ?></td>
                    <td>
                      <a class="text-decoration-none" href="order-details.php?oid=<?= $value["id"] ?>"><?= $value["order_id"] ?></a>
                    </td>
                    <td>$&nbsp;<?= $value["order_amount"] ?></td>
                    <td><?= $value["payment_status"] ?></td>
                    <td><?= $value["order_status"] ?></td>
                    <td>
                      <?php
                      if ($value["order_status"] != "Cancelled") :
                        if ($value["order_status"] == "Pending") : ?>
                          <a href="orders.php?oid=<?= $value["id"]?>&update_order_status=Confirmed" class="btn btn-sm btn-success">Confirm</a>
                        <?php elseif ($value["order_status"] == "Confirmed") : ?>
                          <a href="orders.php?oid=<?= $value["id"]?>&update_order_status=Shipped" class="btn btn-sm btn-success">Shipped</a>
                        <?php elseif ($value["order_status"] == "Shipped") : ?>
                          <a href="orders.php?oid=<?= $value["id"]?>&update_order_status=Delivered" class="btn btn-sm btn-success">Delivered</a>
                        <?php endif ?>
                      <?php endif;
                      if ($value["order_status"] == "Cancelled" && $value["payment_status"] == "Paid") :
                      ?>
                        <a href="orders.php?oid=<?= $value["id"]?>&update_payment_status=Refund-Initiated" class="btn btn-sm btn-success">Initiate Refund</a>

                      <?php elseif ($value["payment_status"] == "Refund-Initiated") : ?>
                        <a href="orders.php?oid=<?= $value["id"]?>&update_payment_status=Refunded" class="btn btn-sm btn-success">Refund</a>
                      <?php endif ?>
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