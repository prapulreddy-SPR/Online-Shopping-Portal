<?php
$cur_page = "home";
$title = "Home";
require_once("shared/header.php");

if (isset($_REQUEST["addcart"])) {
  $product_id = input("pid");
  $sub_category = str_replace(' ', '-', input("sc"));

  $product = get(json_products, array("id" => $product_id));
  $product_price = $product["price"];
  $quantity = 1;

  $_SESSION["cart"][$product_id] = array("quantity" => $quantity);
  echo "<script>alert('Product Added to Cart');window.location='index.php#$sub_category'</script>";
}

?>

<section class="carousel">

  <div id="carouselExampleInterval" class="carousel slide" data-bs-ride="carousel">
    <div class="carousel-inner">
      <div class="carousel-item active" data-bs-interval="10000">
        <img src="images/banner/banner-1.jpg" class="d-block w-100" alt="...">
      </div>
      <div class="carousel-item" data-bs-interval="2000">
        <img src="images/banner/banner-2.jpg" class="d-block w-100" alt="...">
      </div>
      <div class="carousel-item">
        <img src="images/banner/banner-3.jpg" class="d-block w-100" alt="...">
      </div>
    </div>
    <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleInterval" data-bs-slide="prev">
      <span class="carousel-control-prev-icon" aria-hidden="true"></span>
      <span class="visually-hidden">Previous</span>
    </button>
    <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleInterval" data-bs-slide="next">
      <span class="carousel-control-next-icon" aria-hidden="true"></span>
      <span class="visually-hidden">Next</span>
    </button>
  </div>

</section>

<section class="content container">

  <div class="info-container">
    <div class="row">
      <div class="col-sm-4 mb-3">
        <div class="info">
          <div class="d-flex gap-3 justify-content-start align-items-center mb-2">
            <i class="fa fa-dollar fa-fw fs-3"></i>
            <div class="fs-4 fw-bold">MONEY BACK</div>
          </div>
          <h6>30 DAY MONEY BACK GUARANTEE</h6>
        </div>
      </div>
      <div class="col-sm-4 mb-3">
        <div class="info">
          <div class="d-flex gap-3 justify-content-start align-items-center mb-2">
            <i class="fa fa-truck fa-fw fs-3"></i>
            <div class="fs-4 fw-bold">FREE SHIPPING</div>
          </div>
          <h6>FREE SHIP-ON ORDER ABOVE $2000</h6>
        </div>
      </div>
      <div class="col-sm-4 mb-3">
        <div class="info">
          <div class="d-flex gap-3 justify-content-start align-items-center mb-2">
            <i class="fa fa-gift fa-fw fs-3"></i>
            <dic class="fs-4 fw-bold">SPECIAL OFFER</dic>
          </div>
          <h6>ALL PRODUCTS-SALE UP TO 20% OFF</h6>
        </div>
      </div>
    </div>
  </div>

</section>

<!-- List All Categories -->

<section class="categories container">
  <h4 class="mb-5">CATEGORIES</h4>
  <div class="d-flex gap-3 flex-wrap justify-content-start">
    <?php
    $categories = getAll(json_category, array("status" => true));
    asort($categories);
    foreach ($categories as $cat) :
    ?>

      <div class="col-sm-2 mb-4">
        <a href="<?= base_url ?>/category.php?cid=<?= $cat['id'] ?>" class="btn btn-outline-primary w-100 p-4"><?= $cat["category"] ?></a>
      </div>

    <?php
    endforeach
    ?>

  </div>
</section>

<!-- End of List All Categories -->

<!-- Sub Categories and products -->

<section class="sub-categories-products container">
  <?php
  $sub_categories = getAll(json_sub_category, array("status" => true));
  asort($sub_categories);
  foreach ($sub_categories as $sub_cat) :
    $products = getAll(json_products, array("status" => true, "sub_category_id" => $sub_cat['id']));
    if ($products) :
      // Limit to only display 4 products
      $products = array_slice($products, 0, 4, true);
  ?>
      <div class="category-title d-flex align-items-center justify-content-between mb-4 border-bottom" id="<?= str_replace(' ', '-', $sub_cat["sub_category"]); ?>">
        <div class="h3"><?= $sub_cat["sub_category"] ?></div>
        <a href="<?= base_url ?>/category.php?cid=<?= $cat['id'] ?>" class="btn btn-outline-secondary btn-sm">View All</a>
      </div>
      <div class="products mb-5">
        <div class="row g-4">
          <!-- Products -->
          <?php foreach ($products as $prod) :
            $review = getProductRatings($prod["id"]);
          ?>
            <div class="col-sm-3">
              <div class="card border-0">
                <div class="card-body">
                  <img src="images/products/<?= $prod["image_filename"] ?>" class="cover card-img-top mb-3">

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
                      <a href="cart.php" class="btn btn-sm btn-warning w-100">Go to Cart</a>
                    <?php else : ?>
                      <a href="index.php?pid=<?= $prod['id'] ?>&sc=<?= $sub_cat["sub_category"] ?>&addcart=1" class="btn btn-sm btn-info w-100">Add to Cart</a>
                    <?php endif; ?>
                  <?php else : ?>
                    <button class="btn btn-sm btn-danger w-100" disabled>Out Of Stock</button>
                  <?php endif; ?>
                </div>
              </div>
            </div>

          <?php endforeach; ?>
          <!-- end of Products -->
        </div>

      </div>

  <?php
    endif;
  endforeach ?>
</section>

<!-- End of Sub Categories and products -->

<?php
require_once("shared/footer.php");
?>