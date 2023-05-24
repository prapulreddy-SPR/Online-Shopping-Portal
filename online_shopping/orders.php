<?php
$cur_page = "orders";
$title = "Order History";
require_once("shared/header.php");

//If not logged in redirect to not home page
if (!isset($_SESSION["user"])) {
  echo "<script>window.location='index.php'</script>";
}

if(isset($_REQUEST["cancel"])){
  $order_id = input("cancel");
  $update = array("order_status"=>"Cancelled");
  update(json_orders, $update, array("id"=>$order_id));
  echo "<script>alert('Order Cancelled');window.location='orders.php'</script>";
}

$user_id = $_SESSION["user_id"];
$orders = getAll(json_orders, array("user_id" => $user_id));
krsort($orders);
?>

<section class="content container">

  <div class="my-account my-4">
    <div class="d-flex justify-content-center gap-3">
      <a href="my-account.php" class="btn btn-outline-success">My Profile</a>
      <a href="change-password.php" class="btn btn-outline-success">Change Password</a>
      <a href="orders.php" class="btn btn-success">Order History</a>
    </div>
  </div>
  <hr>

  <div class="border p-4">
    <div class="table-responsive">
      <table class="table table-bordered">
        <thead>
          <th>SNo</th>
          <th>Order&nbsp;Id</th>
          <th>Order&nbsp;Date</th>
          <th>Order&nbsp;Amount</th>
          <th>Payment&nbsp;Status</th>
          <th>Order&nbsp;Status</th>
          <th>Action</th>
        </thead>
        <tbody>
          <?php
          $sno = 0;
          foreach ($orders as $order) : ?>
            <tr>
              <td><?= ++$sno ?></td>
              <td>
                <a href="order-details.php?oid=<?= $order["id"] ?>"><?= $order["order_id"] ?></a>
              </td>
              <td><?= date("d-m-Y", strtotime($order["order_date"])); ?></td>
              <td>$&nbsp;<?= $order["order_amount"] ?></td>
              <td><?= $order["payment_status"] ?></td>
              <td><?= $order["order_status"] ?></td>
              <td>
                <?php if ($order["order_status"] != "Delivered" && $order["order_status"] != "Cancelled") : ?>
                  <a onclick="return confirm('Are you sure? Do you want to cancel this order')" href="orders.php?cancel=<?= $order["id"] ?>" class="btn btn-sm btn-danger">Cancel</a>
                <?php endif; ?>
              </td>
            </tr>
          <?php endforeach ?>
        </tbody>
      </table>
    </div>
  </div>

</section>



<?php
require_once("shared/footer.php");
?>