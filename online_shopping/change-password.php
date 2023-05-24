<?php
$cur_page = "changepassword";
$title = "Change Password";
require_once("shared/header.php");

//If not logged in redirect to not home page
if (!isset($_SESSION["user"])) {
  echo "<script>window.location='index.php'</script>";
}



if ($_SERVER["REQUEST_METHOD"] == "POST") {

  $values = array(
    "password" => input("password")
  );
  update(json_users, $values, array("id" => $_SESSION["user_id"]));
  echo "<script>alert('Password Updated Successfully');window.location='change-password.php'</script>";
}

$user_id = $_SESSION["user_id"];
$user = get(json_users, array("id" => $user_id, "status" => true));

?>

<section class="content container">

  <div class="my-account my-4">
    <div class="d-flex justify-content-center gap-3">
      <a href="my-account.php" class="btn btn-outline-success">My Profile</a>
      <a href="change-password.php" class="btn btn-success">Change Password</a>
      <a href="orders.php" class="btn btn-outline-success">Order History</a>
    </div>
  </div>
  <hr>

  <div class="border p-4">
    <div class="d-flex justify-content-center">
      <form onsubmit="return checkPassword(this)" action="<?= htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post" style="width:40%;">
        <div class="mb-3">
          <label for="password" class="form-label required">New Password</label>
          <input type="password" class="form-control" name="password" id="password" required>
        </div>
        <div class="mb-3">
          <label for="confirm_password" class="form-label required">Confirm Password</label>
          <input type="password" class="form-control" name="confirm_password" id="confirm_password" required>
          <span id="error_msg" class="text-danger small-text"></span>
        </div>
        <button class="btn btn-sm btn-primary w-100">Update Password</button>
      </form>
    </div>
  </div>

</section>



<?php
require_once("shared/footer.php");
?>