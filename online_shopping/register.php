<?php
$cur_page = "register";
$title = "Register";
require_once("shared/header.php");

$error="";
if ($_SERVER["REQUEST_METHOD"] == "POST") {

  $user = get(json_users, array("email"=>input("email")));

  if($user == null){
    $values = array(
      "first_name" => input("first_name"),
      "last_name" => input("last_name"),
      "email" => input("email"),
      "password" => input("password"),
      "status" => true
    );
    
    insert(json_users, $values);
    echo "<script>alert('Registered Successfully');window.location='login.php'</script>";
  }

  $error="Email already registered";
}

?>

<section class="content register container">
  
  <div class="row justify-content-center" style="margin-top: 4%;">
    <div class="col-sm-4 border p-4 bg-img" style="height:auto;">
      <div class="d-flex flex-column gap-3 align-items-center justify-content-center" style="height:100%;">
        <h3>Register Now</h3>
        <p>Already Registered ? <a href="login.php" class="text-info">Login</a></p>
      </div>
    </div>
    <div class="col-sm-4 border p-4">
      <h5 class="text-center text-danger"><?= $error?></h5>
      <form action="<?= htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="POST">
        <div class="mb-3">
          <label for="first_name" class="form-label">First Name</label>
          <input type="text" class="form-control" name="first_name" value="<?= $_REQUEST['first_name']?>" id="first_name" required>
        </div>
        <div class="mb-3">
          <label for="last_name" class="form-label">Last Name</label>
          <input type="text" class="form-control" name="last_name" value="<?= $_REQUEST['last_name']?>" id="last_name" required>
        </div>
        <div class="mb-3">
          <label for="email" class="form-label">Email</label>
          <input type="email" class="form-control" name="email" value="<?= $_REQUEST['email']?>" id="email" required>
        </div>
        <div class="mb-3">
          <label for="password" class="form-label">Password</label>
          <input type="password" class="form-control" name="password" id="password" required>
        </div>
        <button class="btn btn-sm btn-primary w-100">Register</button>
      </form>
    </div>
  </div>

</section>



<?php
require_once("shared/footer.php");
?>