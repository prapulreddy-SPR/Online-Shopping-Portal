<?php
error_reporting(E_ERROR | E_PARSE);
if (!isset($_SESSION)) {
  session_start();
}

$host = $_SERVER['HTTP_HOST'];
$uri_admin = rtrim(dirname($_SERVER['PHP_SELF'],2),'/\\');
$uri = rtrim(dirname($_SERVER['PHP_SELF'],1),'/\\');

//project path
//define("base_url", "http://localhost:88/students/online_shopping");
define("base_url_admin", "http://$host$uri_admin");
define("base_url", "http://$host$uri");

//JSON Files
define("json_admin", "admin");
define("json_category", "categories");
define("json_sub_category", "sub_categories");
define("json_products", "products");
define("json_users", "users");
define("json_orders", "orders");
define("json_order_items", "order_items");
define("json_reviews", "reviews");