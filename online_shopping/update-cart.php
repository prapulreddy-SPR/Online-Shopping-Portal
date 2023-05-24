<?php
session_start();

$product_id = $_REQUEST["cart_prod_id"];
$qty = $_REQUEST["cart_prod_qty"];
foreach ($product_id as $i => $prod_id) {
  $_SESSION["cart"][$prod_id] = array("quantity" => $qty[$i]);
}
echo "Cart Updated";
