<?php
include_once("data_php/base.php");
include_once("includes/config.php");

$category_id = $_REQUEST["cid"];
$category = get(json_category, array("status" => true, "id" => $category_id));

$cur_page = $category["category"];
$title = $category["category"];

include_once("shared/header.php");

if ($category == null) {
  header("HTTP/1.1 404 Not Found");
  echo '<h1 class="text-danger my-5 text-center">Category Not Found !</h1>';
  exit();
}

if (isset($_REQUEST["addcart"])) {
  $category_id = input("cid");
  $product_id = input("pid");
  $product = get(json_products, array("id" => $product_id));
  $product_price = $product["price"];
  $quantity = 1;

  $_SESSION["cart"][$product_id] = array("quantity" => $quantity);
  echo "<script>alert('product added to cart');window.location='category.php?cid=$category_id'</script>";
}

if (isset($_REQUEST["remove_cart"])) {
  $product_id = input("pid");
  unset($_SESSION["cart"][$product_id]);
  echo "<script>alert('Product Removed from Cart');window.location='product-details.php?pid=" . $product_id . "'</script>";
}


$products = getAll(json_products, array("status" => true, "category_id" => $category["id"]));

?>

<section class="category-details container py-2">

  <nav class="mb-4" style="--bs-breadcrumb-divider: '/';" aria-label="breadcrumb">
    <ol class="breadcrumb d-flex justify-content-end">
      <li class="breadcrumb-item"><a href="index.php">Home</a></li>
      <li class="breadcrumb-item active" aria-current="page"><?= $category["category"] ?></li>
    </ol>
  </nav>

  <div class="row mb-5">
    <!-- Sidebar -->
    <div class="col-sm-3">
      <div class="sidebar-category mb-5">
        <h5 class="text-secondary">CATEGORIES</h5>
        <hr>
        <div class="sub-category-list d-flex flex-column">

          <?php
          $categories = getAll(json_category, array("status" => true));
          asort($categories);
          foreach ($categories as $cat) : ?>
            <a class="<?= $category_id == $cat["id"] ? 'active' : '' ?>" href="category.php?cid=<?= $cat["id"] ?>"> <i class="fa-solid fa-angles-right me-2"></i> <?= $cat["category"] ?></a>
          <?php endforeach ?>

        </div>
      </div>

      <?php 
      $sub_cat = getAll(json_sub_category, array("category_id" => $category["id"], "status" => true));
      if($sub_cat):
      ?>

      <h5 class="text-secondary">SUB CATEGORIES</h5>
      <hr>
      <div class="sub-category-list d-flex flex-column">

        <?php        
        asort($sub_cat);
        foreach ($sub_cat as $sub) : ?>
          <a href="sub_category.php?scid=<?= $sub["id"] ?>"> <i class="fa-solid fa-angles-right me-2 text-primary"></i> <?= $sub["sub_category"] ?></a>
        <?php endforeach; ?>

      </div>
      <?php endif?>
      <hr>
    </div>

    <!-- end of Sidebar -->

    <div class="col-sm-9">
      <div class="category-details">

        <h3 class="page-title"><?= $category["category"] ?></h3>
        <div class="products mb-5">
          <div class="row g-4">
            <?php
            if ($products == null) : ?>
              <h4 class="text-danger text-center">No product's found</h4>
              <?php else :
              foreach ($products as $prod) :
                $review = getProductRatings($prod["id"]); ?>
                <div class="col-sm-4">
                  <div class="card border-0">
                    <div class="card-body">
                      <img src="images/products/<?= $prod["image_filename"] ?>" class="cover card-img-top mb-3" alt="..." style="height:260px;">
                      <h6 class="card-title text-secondary"><?= $prod["product_name"] ?></h6>
                      <div class="row align-items-center mb-3">
                        <div class="col">
                          <div class="text-success fw-bold">$ <?= $prod['price'] ?></div>
                        </div>
                        <div class="col">
                          <a href="ratings-reviews.php?pid=<?= $prod['id'] ?>" class="badge rounded-pill text-bg-success p-2 text-decoration-none">
                            <i class="fa fa-star text-warning"></i>
                            <span><?= $review["ratings"] ?>/5 (<?= $review["counts"] ?>) reviews</span>
                          </a>
                        </div>
                      </div>

                      <a href="product-details.php?pid=<?= $prod['id'] ?>" class="btn btn-sm btn-primary w-100 mb-2">View Details</a>

                      <?php
                      if ($prod["in_stock"]) :
                        if (isset($_SESSION['cart']) && $_SESSION['cart'][$prod["id"]]) : ?>
                          <a href="cart.php" class="btn btn-sm btn-danger w-100">Go to Cart</a>
                        <?php else : ?>
                          <a href="category.php?cid=<?= $category["id"] ?>&pid=<?= $prod["id"] ?>&addcart=1" class="btn btn-sm btn-info w-100">Add to Cart</a>
                        <?php endif; ?>
                      <?php else : ?>
                        <button class="btn btn-sm btn-danger w-100" disabled>Out Of Stock</button>
                      <?php endif; ?>

                    </div>
                  </div>
                </div>

              <?php endforeach; ?>
            <?php endif; ?>
          </div>

        </div>

      </div>
    </div>
  </div>


</section>

<?php
require_once("shared/footer.php");
?>