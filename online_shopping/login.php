<?php
$cur_page = "login";
$title = "Login";
require_once("shared/header.php");

$error="";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

  $values = array(
    "email" => input("email"),
    "password" => input("password"),
    "status" => true
  );

  $user = get(json_users, $values);
  
  if ($user) {
    $_SESSION['logged_in'] = true;
    $_SESSION["user"] = true;
    $_SESSION["user_id"] = $user["id"];
    $_SESSION["fullname"] = $user["first_name"] . " " . $user["last_name"];
    if ($user["address"]) {
      header("location:index.php");
    } else {
      header("location:my-account.php");
    }
  } else {
    $error = "Invalid Login Credentials";
  }

}

?>

<section class="content login container">
  
  <div class="row justify-content-center " style="margin-top: 8%;">
    <div class="col-sm-4 border p-4 bg-img" style="height:auto;">
      <div class="d-flex flex-column gap-3 align-items-center justify-content-center" style="height:100%;">
        <h3>Login</h3>
        <p>Not a member yet ? register <a href="register.php" class="text-info">here</a></p>
      </div>
    </div>
    <div class="col-sm-4 border p-4">
      <h5 class="text-danger text-center"><?= $error?></h5>
    <form action="<?= htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="POST">
        <div class="mb-4">
          <label for="email" class="form-label">Email</label>
          <input type="email" class="form-control" name="email" id="email" required>
        </div>
        <div class="mb-4">
          <label for="password" class="form-label">Password</label>
          <input type="password" class="form-control" name="password" id="password" required>
        </div>
        <button class="btn btn-sm btn-primary w-100">Login</button>
      </form>
    </div>
  </div>

</section>



<?php
require_once("shared/footer.php");
?>