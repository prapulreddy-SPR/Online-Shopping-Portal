<?php
$cur_page = "cart";
$title = "cart";
include_once("shared/header.php");

// Remove product from cart
if (isset($_REQUEST["remove"])) {
  echo $product_id = input("pid");
  unset($_SESSION["cart"][$product_id]);
  echo "<script>alert('Product Removed From Cart');window.location='cart.php'</script>";
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {

  $product_id = $_REQUEST["cart_prod_id"];
  $qty = $_REQUEST["cart_prod_qty"];
  foreach ($product_id as $i => $prod_id) {
    $_SESSION["cart"][$prod_id] = array("quantity" => $qty[$i]);
  }

  $order_id = date('ymdHis');
  $sub_total = 0;
  $grand_total = 0;
  foreach ($_SESSION["cart"] as $prod_id => $value) {
    $product = get(json_products, array("id" => $prod_id));
    $sub_total = ($product["price"] * $value["quantity"]) + $product["shipping_charge"];

    $order_items_values = array(
      "order_id"=>(int)$order_id,
      "product_id"=>$product["id"],
      "quantity"=>(int)$value["quantity"],
      "price"=>(float)$product["price"],
      "shipping_charge"=>(float)$product["shipping_charge"],
      "sub_total"=>$sub_total
    );

    insert(json_order_items, $order_items_values);

    $grand_total += $sub_total;
  }

  $order_values = array(
    "user_id"=>(int)$_SESSION["user_id"],
    "order_id"=>(int)$order_id,
    "order_date"=>date("Y-m-d H:i:s"),
    "order_amount"=>(float)$grand_total,
    "payment_mode"=>"Card",
    "payment_status"=>"Paid",
    "shipping_address"=>input("shipping_address"),
    "order_status"=>"Pending"
  );

  insert(json_orders, $order_values);
  unset($_SESSION["cart"]);
  echo "<script>alert('Order Placed Successfully');window.location='orders.php'</script>";
}

if(isset($_SESSION["user"]))
{
  $user = get(json_users, array("id" => $_SESSION["user_id"]));
}

?>

<section class="category-details container py-2">

  <nav class="mb-4" style="--bs-breadcrumb-divider: '/';" aria-label="breadcrumb">
    <ol class="breadcrumb d-flex justify-content-end">
      <li class="breadcrumb-item"><a href="index.php">Home</a></li>
      <li class="breadcrumb-item active" aria-current="page">Shopping Cart</li>
    </ol>
  </nav>

  <?php
  if (!isset($_SESSION["cart"]) || count($_SESSION["cart"]) == 0) :
    echo "<h3 class='text-center text-danger my-5'>Your cart is empty</h3>";
  else :
  ?>

    <div class="row mb-5 cart">
      <form action="" method="POST">

        <div class="row">
          <div class="col-sm-8">
            <div class="cart-details">
              <table class="table ">
                <thead>
                  <th>Image</th>
                  <th>Product</th>
                  <th>Price</th>
                  <th>Shipping</th>
                  <th>Sub Total</th>
                  <th></th>
                </thead>
                <tbody>
                  <?php
                  $sub_total = 0;
                  $grand_total = 0;
                  foreach ($_SESSION["cart"] as $prod_id => $value) :
                    $product = get(json_products, array("id" => $prod_id));
                    $sub_total = ($product["price"] * $value["quantity"]) + $product["shipping_charge"];
                    $grand_total += $sub_total
                  ?>
                    <tr>
                      <td style="width:12%;">
                        <img src="<?= base_url ?>/images/products/<?= $product['image_filename'] ?>" alt="" class="w-100 cover-cart">
                      </td>
                      <td>
                        <h6><?= $product["product_name"] ?></h6>

                        <div class="row align-items-center">
                          <div class="col-sm-3 text-end">
                            <label for="" class="col-form-label">QTY : </label>
                          </div>
                          <div class="col-sm-3">
                            <input type="hidden" name="cart_prod_id[]" value="<?= $product['id'] ?>">
                            <input type="number" name="cart_prod_qty[]" class="form-control" min="1" value="<?= $value["quantity"] ?>">
                          </div>
                        </div>

                      </td>
                      <td>
                        <h5>$&nbsp;<?= $product["price"] ?></h5>
                      </td>
                      <td>
                        <h5>$&nbsp;<?= $product["shipping_charge"] ?></h5>
                      </td>
                      <td>
                        <h5>$&nbsp;<?= $sub_total ?></h5>
                      </td>
                      <td>
                        <a onclick="return confirm('Do you want to remove this product?')" href="cart.php?pid=<?= $product["id"] ?>&remove=1" class="btn btn-sm btn-danger">x</a>
                      </td>
                    </tr>
                  <?php endforeach ?>
                  <tr class="fs-5">
                    <td colspan="4" class="text-end">Grand Total</td>
                    <td>$&nbsp;<?= $grand_total ?></td>
                  </tr>
                  <tr>
                    <td colspan="5" class="text-end">
                      <input onclick="updateCartValues()" type="button" class="btn btn-sm btn-warning" value="UPDATE CART" name="update_cart">
                    </td>
                  </tr>

                </tbody>
              </table>
            </div>
          </div>
          <div class="col-sm-4">
            <div class="payment-details border p-3 mb-2">
              <h5 class="text-secondary">Card Payment</h5>
              <hr>
              <div class="mb-2">
                <label for="" class="form-label">Name on card</label>
                <input type="text" class="form-control" required>
              </div>
              <div class="mb-2">
                <label for="" class="form-label">Card Number</label>
                <input type="text" class="form-control" required>
              </div>
              <div class="row mb-2">
                <div class="col">
                  <label for="" class="form-label">Exp Year</label>
                  <input type="text" class="form-control" placeholder="mm/yyyy" required>
                </div>
                <div class="col">
                  <label for="" class="form-label">CVV</label>
                  <input type="text" class="form-control" required>
                </div>
              </div>
            </div>
          </div>
        </div>

        <div class="row">
          <div class="col-sm-8">
            <div class="shipping-address">
              <div>
                <label for="shipping_address" class="form-label">Shipping Address</label>
                <textarea name="shipping_address" id="shipping_address" rows="3" class="form-control" required><?= $user["address"]?></textarea>
              </div>
            </div> 
          </div>
          <div class="col-sm-4">
          <?php if(isset($_SESSION["user"])):?>
          <button type="submit" class="btn btn-success w-100">Pay Now</button>
          <?php else:?>
            <a href="login.php" class="btn btn-info w-100">Please login to proceed</a>
            <?php endif;?>
          </div>
        </div>      

      </form>
    </div>

  <?php endif; ?>


</section>

<?php
require_once("shared/footer.php");
?>