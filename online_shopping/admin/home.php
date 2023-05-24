<?php
$active = "home";
$title = "Admin Home";
require_once("shared/header.php");
require_once("../data_php/base.php");

//If not admin redirect to not authorized page
if (!isset($_SESSION["admin"])) {
  echo "<script>window.location='index.php'</script>";
}

$orders = getAll(json_orders);
$pending = getAll(json_orders, array("order_status"=>"Pending"));
$completed = getAll(json_orders, array("order_status"=>"Delivered"));
$cancelled = getAll(json_orders, array("order_status"=>"Cancelled"));

?>

<div class="content container-fluid">
  <div class="row">
    <div class="col-sm-3">
      <?php require_once("shared/sidebar.php"); ?>
    </div>
    <div class="col-sm-9">

      <div class="card mb-3">
        <div class="card-header">Dashboard</div>
        <div class="card-body p-4">

        <div class="row gap-3 justify-content-center">
          <div class="col-sm-3 text-center bg-success text-light p-2">
            <h4>Orders</h4>
            <h4><?= ($orders) ? count($orders) : 0;?></h4>
          </div>
          <div class="col-sm-3 text-center bg-success text-light p-2">
            <h4>Pending&nbsp;Orders</h4>
            <h4><?= ($pending) ? count($pending) : 0;?></h4>
          </div>
          <div class="col-sm-3 text-center bg-success text-light p-2">
            <h4>Completed&nbsp;Orders</h4>
            <h4><?= ($completed) ? count($completed) : 0;?></h4>
          </div>
          <div class="col-sm-3 text-center bg-danger text-light p-2">
            <h4>Cancelled&nbsp;Orders</h4>
            <h4><?= ($cancelled) ? count($cancelled) : 0;?></h4>
          </div>
        </div>


        </div>
      </div>

    </div>
  </div>

</div>

<?php require_once("shared/footer.php"); ?>