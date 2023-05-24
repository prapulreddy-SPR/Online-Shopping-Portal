<?php
$cur_page = "myaccount";
$title = "My Account";
require_once("shared/header.php");

//If not logged in redirect to not home page
if (!isset($_SESSION["user"])) {
  echo "<script>window.location='index.php'</script>";
}



if ($_SERVER["REQUEST_METHOD"] == "POST") {

  $values = array(
    "first_name" => input("first_name"),
    "last_name" => input("last_name"),
    "contact_no" => input("contact_no"),
    "address" => input("address")
  );
  update(json_users, $values, array("id" => $_SESSION["user_id"]));
  echo "<script>alert('Profile Updated Successfully');window.location='my-account.php'</script>";
}

$user_id = $_SESSION["user_id"];
$user = get(json_users, array("id" => $user_id, "status" => true));

?>

<section class="content container">

  <div class="my-account my-4">
    <div class="d-flex justify-content-center gap-3">
      <a href="my-account.php" class="btn btn-success">My Profile</a>
      <a href="change-password.php" class="btn btn-outline-success">Change Password</a>
      <a href="orders.php" class="btn btn-outline-success">Order History</a>
    </div>
  </div>
  <hr>

  <div class="border p-4">
    <h5 class="text-center mb-3">Personal Info</h5>
    <div class="d-flex justify-content-center">
      <form action="<?= htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post" style="width:40%;">
        <div class="mb-3">
          <label for="first_name" class="form-label required">First Name</label>
          <input type="text" class="form-control" name="first_name" id="first_name" value="<?= $user["first_name"] ?>" required>
        </div>
        <div class="mb-3">
          <label for="last_name" class="form-label required">Last Name</label>
          <input type="text" class="form-control" name="last_name" id="last_name" value="<?= $user["last_name"] ?>" required>
        </div>
        <div class="mb-3">
          <label for="email" class="form-label">Email</label>
          <input type="email" class="form-control" name="email" id="email" value="<?= $user["email"] ?>" disabled>
        </div>
        <div class="mb-3">
          <label for="contact_no" class="form-label required">Contact No</label>
          <input type="text" class="form-control" name="contact_no" id="contact_no" value="<?= $user["contact_no"] ?>" required>
        </div>
        <div class="mb-3">
          <label for="address" class="form-label required">Address</label>
          <textarea name="address" id="address" class="form-control" rows="4" required><?= $user["address"] ?></textarea>
        </div>
        <button class="btn btn-sm btn-primary w-100">Update Profile</button>
      </form>
    </div>
  </div>


</section>



<?php
require_once("shared/footer.php");
?>