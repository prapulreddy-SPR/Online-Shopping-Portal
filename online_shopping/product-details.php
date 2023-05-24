<?php
$cur_page = "product_details";
$title = "Product Details";
require_once("shared/header.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $product_id = input("product_id");
  $product_price = input("product_price");
  $quantity = input("quantity");

  $_SESSION["cart"][$product_id] = array("quantity" => $quantity, "price" => $product_price);
  echo "<script>alert('Product Added to Cart');window.location='product-details.php?pid=" . $product_id . "'</script>";
}

if (isset($_REQUEST["remove"])) {
  $product_id = input("pid");
  unset($_SESSION["cart"][$product_id]);
  echo "<script>alert('Product Removed from Cart');window.location='product-details.php?pid=" . $product_id . "'</script>";
}

$product_id = input("pid");
$product = get(json_products, array("id" => $product_id));
if ($product == null) {
  header("HTTP/1.1 404 Not Found");
  echo '<h1 class="text-danger my-5 text-center">Product Not Found !</h1>';
  exit();
}
$category = get(json_category, array("id" => $product["category_id"]));
$sub_category = get(json_sub_category, array("id" => $product["sub_category_id"]));
$review = getProductRatings($product["id"]);

?>

<section class="product-details container py-2">

  <nav class="mb-4" style="--bs-breadcrumb-divider: '/';" aria-label="breadcrumb">
    <ol class="breadcrumb d-flex justify-content-end">
      <li class="breadcrumb-item"><a href="index.php">Home</a></li>
      <li class="breadcrumb-item"><a href="category.php?cid=<?= $category["id"] ?>"><?= $category["category"] ?></a></li>
      <li class="breadcrumb-item"><a href="sub_category.php?scid=<?= $sub_category["id"] ?>"><?= $sub_category["sub_category"] ?></a></li>
      <li class="breadcrumb-item active" aria-current="page">Product Details</li>
    </ol>
  </nav>

  <div class="row">
    <div class="col-sm-3">
      <h5 class="text-secondary">CATEGORIES</h5>
      <hr>
      <div class="category-list d-flex flex-column">

        <?php
        $categories = getAll(json_category, array("status" => true));
        asort($categories);
        foreach ($categories as $cat) : ?>
          <a href="category.php?cid=<?= $cat["id"] ?>"> <i class="fa-solid fa-angles-right me-2 text-primary"></i> <?= $cat["category"] ?></a>
        <?php endforeach ?>

      </div>
      <hr>
    </div>
    <div class="col-sm-9">

      <div class="row mb-5">

        <div class="col-sm-4">
          <img src="images/products/<?= $product["image_filename"] ?>" class="cover">
        </div>

        <div class="col-sm-8">
          <h4 class="text-secondary"><?= $product["product_name"] ?></h4>

          <div class="review mb-4">
            <a href="" class="btn btn-sm btn-success rounded-pill text-warning"> <i class="fa fa-star"></i> <?= $review["ratings"] ?>/5 ratings</a>
            <a href="#ratings" class="btn btn-sm btn-warning">
              <span class="badge text-bg-danger"><?= $review["counts"] ?></span> reviews
            </a>
          </div>

          <div class="row">
            <div class="col-sm-4 mb-2">
              <span>Brand</span>
            </div>
            <div class="col-sm-8">
              <span class="text-secondary"> : <?= $product["product_company"]; ?></span>
            </div>
            <div class="col-sm-4 mb-2">
              <span>Availability</span>
            </div>
            <div class="col-sm-8">
              <span class="text-secondary"> : <?= $product["in_stock"] ? "In Stock" : "Out of Stock" ?></span>
            </div>
            <div class="col-sm-4 mb-2">
              <span>Shipping Charge</span>
            </div>
            <div class="col-sm-8">
              <span class="text-secondary"> : <?= $product["shipping_charge"]  == 0 ? "Free" : "$" . $product["shipping_charge"] ?></span>
            </div>
          </div>

          <hr>

          <div class="price mb-4">
            <h1 class="text-primary">$ <?= $product["price"] ?></h1>
          </div>

          <?php if ($product["in_stock"]) : ?>
            <div class="add-to-cart">
              <form action="<?= htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="POST">
                <div class="row g-3 align-items-center">
                  <div class="col-sm-3">
                    <label for="quantity" class="col-form-label">QUANTITY :</label>
                  </div>
                  <div class="col-sm-2">
                    <input type="number" class="form-control" min="1" value="<?= $_SESSION["cart"][$product_id] ? $_SESSION["cart"][$product_id]["quantity"] : '1' ?>" name="quantity" id="quantity">
                  </div>
                  <div class="col-sm-3">
                    <input type="hidden" name="product_id" value="<?= $product["id"] ?>">
                    <input type="hidden" name="product_price" value="<?= $product["price"] ?>">
                    <button type="submit" class="w-100 btn btn-<?= $_SESSION["cart"][$product_id] ? 'info' : 'primary' ?>">
                      <i class="fa fa-shopping-cart me-1"></i> <?= $_SESSION["cart"][$product_id] ? 'Update' : 'Add' ?>
                    </button>
                  </div>
                  <?php if ($_SESSION["cart"][$product_id]) : ?>
                    <div class="col-sm-3">
                      <a href="product-details.php?pid=<?= $product_id ?>&remove=1" class="btn btn-danger w-100"> <i class="fa-solid fa-delete-left me-1"></i> Remove</a>
                    </div>
                  <?php endif ?>

                </div>
              </form>
            </div>
          <?php else : ?>
            <h3 class="text-danger">Out Of Stock</h3>
          <?php endif ?>

        </div>

      </div>

      <div class="accordion mb-5" id="accordionExample">
        <div class="accordion-item">
          <h2 class="accordion-header">
            <button class="accordion-button text-primary" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
              Product Description
            </button>
          </h2>
          <div id="collapseOne" class="accordion-collapse collapse show" data-bs-parent="#accordionExample">
            <div class="accordion-body product-description">
              <?= html_entity_decode(html_entity_decode($product["description"])) ?>
            </div>
          </div>
        </div>
        <div class="accordion-item" id="ratings">
          <h2 class="accordion-header">
            <button class="accordion-button collapsed  text-primary" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
              Ratings & Reviews
            </button>
          </h2>
          <div id="collapseTwo" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
            <div class="accordion-body">
              <div class="product-ratings-reviews border p-1">

                <?php
                $reviews = getAll(json_reviews, array("product_id" => $product["id"]));
                if ($reviews) :
                  $sno = 0;
                  foreach ($reviews as $review) :
                    $sno += 1;
                    $user = get(json_users, array("id" => $review["user_id"])) ?>
                    <div class="p-2 mb-2">
                      <figure>
                        <div class="star-rating mb-3">
                          <input type="radio" id="5-stars-rest-<?= $sno ?>" name="rating_<?= $sno ?>" value="5" <?= $review["rating"] == 5 ? 'checked' : '' ?> required />
                          <label for="5-stars-rest" class="star">&#9733;</label>
                          <input type="radio" id="4-stars-rest-<?= $sno ?>" name="rating_<?= $sno ?>" value="4" <?= $review["rating"] == 4 ? 'checked' : '' ?> />
                          <label for="4-stars-rest" class="star">&#9733;</label>
                          <input type="radio" id="3-stars-rest-<?= $sno ?>" name="rating_<?= $sno ?>" value="3" <?= $review["rating"] == 3 ? 'checked' : '' ?> />
                          <label for="3-stars-rest" class="star">&#9733;</label>
                          <input type="radio" id="2-stars-rest-<?= $sno ?>" name="rating_<?= $sno ?>" value="2 " <?= $review["rating"] == 2 ? 'checked' : '' ?> />
                          <label for="2-stars-rest" class="star">&#9733;</label>
                          <input type="radio" id="1-stars-rest-<?= $sno ?>" name="rating_<?= $sno ?>" value="1" <?= $review["rating"] == 1 ? 'checked' : '' ?> />
                          <label for="1-stars-rest" class="star">&#9733;</label>
                        </div>
                        <blockquote class="blockquote mb-4">
                          <p><q><?= $review["review"] ?></q></p>
                        </blockquote>
                        <figcaption class="blockquote-footer">
                          <cite title="Source Title"><?= $user["first_name"] . " " . $user["last_name"] ?></cite>
                        </figcaption>
                      </figure>
                      <hr>

                    </div>
                  <?php endforeach;
                else : ?>
                  <h5 class="text-center text-danger">Sorry! No reviews available for this product</h5>
                <?php endif ?>

              </div>

            </div>
          </div>
        </div>
      </div>

    </div>
  </div>

</section>

<?php
require_once("shared/footer.php");
?>