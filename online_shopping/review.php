<?php
$cur_page = "orders";
$title = "Order History";
require_once("shared/header.php");

//If not logged in redirect to not home page
if (!isset($_SESSION["user"])) {
  echo "<script>window.location='index.php'</script>";
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {

  $values = array(
    "user_id" => (int)$_SESSION["user_id"],
    "product_id" => (int)input("product_id"),
    "rating" => (int)input("rating"),
    "review" => input("review"),
  );
  
  if (input('review_id') == "") {
    insert(json_reviews, $values);
  } else {
    update(json_reviews, $values, array("id" => input('review_id')));
  }

  echo "<script>alert('Rating & Review posted successfully');window.location='review.php?pid=" . input('product_id') . "&oid=" . input('order_id') . "'</script>";
}

$product_id = input("pid");
$product = get(json_products, array("id" => $product_id));

$order_id = (int)input("oid");
$user_id = (int)$_SESSION["user_id"];

$review = get(json_reviews, array("product_id" => $product["id"], "user_id" => $user_id));

?>

<section class="content container">

  <div class="my-account my-4">
    <div class="d-flex justify-content-center gap-3">
      <a href="my-account.php" class="btn btn-outline-success">My Profile</a>
      <a href="change-password.php" class="btn btn-outline-success">Change Password</a>
      <a href="orders.php" class="btn btn-outline-success">Order History</a>
      <a href="order-details.php?oid=<?= $order_id ?>" class="btn btn-outline-success">Order Details</a>
      <a href="review.php" class="btn btn-success">Rating & Review</a>
    </div>
  </div>
  <hr>

  <div class="border p-4">
    <h5 class="mb-4">Rating & Review for (<?= $product["product_name"] ?>)</h5>
    <form action="<?= htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">
      <div class="mb-3">
        <label for="" class="form-label">Rating</label>
        <div class="star-rating">
          <input type="radio" id="5-stars-rest" name="rating" value="5" <?= $review["rating"] == 5 ? 'checked' : '' ?> required />
          <label for="5-stars-rest" class="star">&#9733;</label>
          <input type="radio" id="4-stars-rest" name="rating" value="4" <?= $review["rating"] == 4 ? 'checked' : '' ?> />
          <label for="4-stars-rest" class="star">&#9733;</label>
          <input type="radio" id="3-stars-rest" name="rating" value="3" <?= $review["rating"] == 3 ? 'checked' : '' ?> />
          <label for="3-stars-rest" class="star">&#9733;</label>
          <input type="radio" id="2-stars-rest" name="rating" value="2 " <?= $review["rating"] == 2 ? 'checked' : '' ?> />
          <label for="2-stars-rest" class="star">&#9733;</label>
          <input type="radio" id="1-stars-rest" name="rating" value="1" <?= $review["rating"] == 1 ? 'checked' : '' ?> />
          <label for="1-stars-rest" class="star">&#9733;</label>
        </div>
      </div>

      <div class="mb-3">
        <label for="review" class="form-label">Review</label>
        <textarea name="review" id="review" class="form-control" rows="3"><?= $review["review"] ?></textarea>
      </div>
      <input type="hidden" name="review_id" id="review_id" value="<?= $review["id"] ?>">
      <input type="hidden" name="product_id" id="product_id" value="<?= $product["id"] ?>">
      <input type="hidden" name="order_id" id="order_id" value="<?= $order_id ?>">
      <button type="submit" class="btn btn-success">Submit</button>
    </form>
  </div>

</section>



<?php
require_once("shared/footer.php");
?>