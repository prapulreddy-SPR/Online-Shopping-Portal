<?php
include_once("includes/config.php");
include_once("data_php/base.php");

?>
<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Shopping | <?= $title ?></title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
  <!-- Font awsome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">
  <!-- DataTable -->
  <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap5.min.css">
  <!-- Own Style -->
  <link rel="stylesheet" href="<?= base_url ?>/assets/style.css">
</head>

<body>
  <nav class="top-bar sticky-top">
    <div class="top-bar-menu container">
      <div>
        <a href="#" class=""><i class="fa fa-phone me-1  fa-fw"></i>757-839-9437 | </a>
        <a href="#" class=""> <i class="fa fa-envelope me-1  fa-fw"></i>contact-us@onlineshopping.com</a>
      </div>
      <div>
        <?php if(isset($_SESSION["user"])):?>
          
        <a href="index.php" class="me-5"> Welcome ! <?= $_SESSION["fullname"]?> </a>
        <a href="logout.php" class=""> <i class="fas fa-sign-out me-1 fa-fw"></i>Logout | </a>
        <a href="my-account.php" class=""> <i class="fa fa-user me-1 fa-fw"></i>My Profile | </a>
          <?php else:?>
            
        <a href="login.php" class=""> <i class="fa fa-right-to-bracket me-1 fa-fw"></i>Login | </a>
        <a href="register.php" class=""> <i class="fa fa-home me-1 fa-fw"></i>Register | </a>
        <?php endif;?>
        <a href="cart.php" class=""> <i class="fa fa-shopping-cart me-1 fa-fw"></i>My Cart <span class="badge rounded-pill bg-danger"><?= (!isset($_SESSION["cart"])) ? 0 : count($_SESSION["cart"])?></span> </a>
      </div>

    </div>
  </nav>

  <nav class="navbar navbar-expand-lg" data-bs-theme="dark" style="background-color: #2874f0;">
    <div class="container">
      <a class="navbar-brand text-warning" href="#"> <i class="fa fa-basket-shopping me-1  fa-fw"></i> Shopping</a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav me-auto mb-2 mb-lg-0 navbar-nav-scroll" style="--bs-scroll-height: 100px;">
          <li class="nav-item">
            <a class="nav-link <?= $cur_page == 'home' ? 'active' : '' ?>" href="index.php">Home</a>
          </li>
          <?php
          $categories = getAll(json_category, array("status" => true));
          $categories = array_slice($categories, 0, 8, true);
          foreach ($categories as $value) : ?>
            <li class="nav-item">
              <a class="nav-link <?= $cur_page == $value['category'] ? 'active' : '' ?>" href="<?= base_url ?>/category.php?cid=<?= $value['id'] ?>"><?= $value["category"] ?></a>
            </li>
          <?php endforeach ?>
        </ul>
      </div>
    </div>
  </nav>