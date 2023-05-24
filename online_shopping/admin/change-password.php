<?php
$active = "change_password";
$title = "Change Password";
require_once("shared/header.php");
require_once("../data_php/base.php");

//If not admin redirect to not authorized page
if (!isset($_SESSION["admin"])) {
  echo "<script>window.location='index.php'</script>";
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {

  $values = array(
    "password" => input("password")
  );
  update(json_admin, $values, array("id"=>1));
  echo "<script>alert('Password Updated Successfully');window.location='change-password.php'</script>";
}

?>

<div class="content container-fluid">
  <div class="row">
    <div class="col-sm-3">
      <?php require_once("shared/sidebar.php"); ?>
    </div>
    <div class="col-sm-9">

      <div class="card mb-3">
        <div class="card-header">Change Password</div>
        <div class="card-body p-3">
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
              <button class="btn btn-sm btn-secondary w-100">Update Password</button>
            </form>
          </div>

        </div>
      </div>

    </div>
  </div>

</div>

<?php require_once("shared/footer.php"); ?>