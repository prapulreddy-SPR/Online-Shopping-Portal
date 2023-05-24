<?php
$cur_page = "ratings_reviews";
$title = "Ratings & Reviews";
require_once("shared/header.php");

$product_id = input("pid");
$product = get(json_products, array("id" => $product_id));
if ($product == null) {
  header("HTTP/1.1 404 Not Found");
  echo '<h1 class="text-danger my-5 text-center">Product Not Found !</h1>';
  exit();
}
$category = get(json_category, array("id" => $product["category_id"]));
$sub_category = get(json_sub_category, array("id" => $product["sub_category_id"]));

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
        <h5 class="text-secondary">SUB CATEGORIES</h5>
        <hr>
        <div class="sub-category-list d-flex flex-column">

          <?php
          $sub_cat = getAll(json_sub_category, array("category_id" => $category["id"], "status" => true));
          asort($sub_cat);
          foreach ($sub_cat as $sub) : ?>
            <a class="<?= $sub_category["id"] == $sub["id"] ? 'active' : '' ?>" href="sub_category.php?scid=<?= $sub["id"] ?>"> <i class="fa-solid fa-angles-right me-2 text-primary"></i> <?= $sub["sub_category"] ?></a>
          <?php endforeach ?>

        </div>
      </div>

      <div class="sidebar-category mb-5">
        <h5 class="text-secondary">CATEGORIES</h5>
        <hr>
        <div class="sub-category-list d-flex flex-column">

          <?php
          $categories = getAll(json_category, array("status" => true));
          asort($categories);
          foreach ($categories as $cat) : ?>
            <a class="<?= $category["id"] == $cat["id"] ? 'active' : '' ?>" href="category.php?cid=<?= $cat["id"] ?>"> <i class="fa-solid fa-angles-right me-2"></i> <?= $cat["category"] ?></a>
          <?php endforeach ?>

        </div>
      </div>
    </div>

    <!-- end of Sidebar -->

    <div class="col-sm-9">
      <h3 class="page-title">Ratings & Reviews for ( <?= $product["product_name"] ?> )</h3>

      <div class="product-ratings-reviews border p-2">

        <?php
        $reviews = getAll(json_reviews, array("product_id" => $product["id"]));
        if ($reviews) :
          $sno = 0;
          foreach ($reviews as $review) :
            $sno += 1; 
            $user = get(json_users, array("id"=>$review["user_id"]))?>
            <div class="p-3 mb-4">
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
                  <p><q><?= $review["review"]?></q></p>
                </blockquote>
                <figcaption class="blockquote-footer">
                  <cite title="Source Title"><?= $user["first_name"]." ".$user["last_name"]?></cite>
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


</section>

<?php
require_once("shared/footer.php");
?>