<?php
$title = "Admin Home";
require_once("shared/header.php");
require_once("../data_php/base.php");

$error="";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $filters = array("user_name" => input('user_name'), "password" => input('password'));

  $admin = get(json_admin, $filters);
  if($admin)
  {
    $_SESSION['logged_in'] = true;
    $_SESSION["admin"] = true;
    header("location:home.php");
  }
  else{
    $error = "Invalid Login";
  }
}
?>

<div class="container-fluid">
  <div class="admin-login">
    <div class="card">
      <div class="card-header">
        <h6>Admin Login</h6>
      </div>
      <div class="card-body">
        <h6 class="text-danger text-center"><?= $error;?></h6>  
        <form action="<?= htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="POST">
          <div class="mb-3">
            <label for="user_name" class="form-label">Username</label>
            <input type="text" class="form-control" name="user_name" id="user_name" required>
          </div>
          <div class="mb-3">
            <label for="password" class="form-label">Password</label>
            <input type="password" class="form-control" name="password" id="password" required>
          </div>

          <button type="submit" class="btn btn-dark w-100">Login</button>
        </form>
      </div>
    </div>

  </div>
</div>



<?php require_once("shared/footer.php") ?>